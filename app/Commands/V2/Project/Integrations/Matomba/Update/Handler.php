<?php

namespace App\Commands\V2\Project\Integrations\Matomba\Update;
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
     * @param UpdateCommand $command
     */
    public function handle(Command $command)
    {
        $matomba = $this->repository->update(
            matomba: $command->matombaId,
            service: $command->service,
        );

        return $matomba;
    }
}
