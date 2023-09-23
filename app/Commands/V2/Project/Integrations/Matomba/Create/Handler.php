<?php

namespace App\Commands\V2\Project\Integrations\Matomba\Create;
use App\Repositories\Project\Integrations\Matomba\Repository;

class Handler
{
    /**
     * Handler constructor.
     */
    public function __construct(
        private Repository $repository
    )
    {
    }

    /**
     * @param CreateCommand $command
     */
    public function handle(Command $command)
    {
        return $this->repository->create(
            project: $command->projectId,
            service: $command->service,
        );
    }
}
