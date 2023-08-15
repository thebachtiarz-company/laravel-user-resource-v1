<?php

declare(strict_types=1);

namespace TheBachtiarz\UserResource\Console\Commands;

use TheBachtiarz\Base\App\Console\Commands\AbstractCommand;
use TheBachtiarz\Base\App\Libraries\Log\LogLibrary;
use TheBachtiarz\UserResource\Services\AccountSyncService;

use function sprintf;

class AccountSynchronizeCommand extends AbstractCommand
{
    /**
     * {@inheritDoc}
     *
     * @param ConfigService $configService
     * @param LogLibrary    $logLibrary
     */
    public function __construct(
        protected AccountSyncService $accountSyncService,
        protected LogLibrary $logLibrary,
    ) {
        $this->signature    = 'thebachtiarz:account:resources:sync';
        $this->commandTitle = 'User resources synchronize';
        $this->description  = 'Synchronize All User Resource Into Local';

        parent::__construct();
    }

    public function commandProcess(): bool
    {
        $this->logLibrary->log(sprintf('======> %s, starting...', $this->commandTitle));

        $syncProcess = $this->accountSyncService->execute();

        $this->logLibrary->log(sprintf('======> %s, finish', $this->commandTitle));

        return $syncProcess['status'];
    }

    // ? Public Methods

    // ? Protected Methods

    // ? Private Methods

    // ? Getter Modules

    // ? Setter Modules
}
