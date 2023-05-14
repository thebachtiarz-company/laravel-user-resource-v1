<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use TheBachtiarz\UserResource\Interfaces\Model\UserResourceInterface;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(UserResourceInterface::TABLE_NAME, function (Blueprint $table) {
            $table->id();
            $table->string(UserResourceInterface::ATTRIBUTE_ACCOUNTCODE)->unique();
            $table->string(UserResourceInterface::ATTRIBUTE_BIODATACODE)->unique();
            $table->tinyText(UserResourceInterface::ATTRIBUTE_DATACACHE)->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(UserResourceInterface::TABLE_NAME);
    }
};
