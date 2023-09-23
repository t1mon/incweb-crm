<?php

namespace App\Commands\V2\Project\Integrations\Matomba\Show;
use App\Repositories\Project\Integrations\Matomba\Repository;

class Handler
{
    /**
     * Handler constructor.
     */
    public function __construct(
        private Repository $repository,
    )
    {
    }

    /**
     * @param ShowCommand $command
     */
    public function handle(Command $command)
    {
        return $this->repository->query()->findOrFail($command->matombaId);
    }
}
