<?php

namespace App\Commands\V2\Project\Integrations\Matomba\Index;
use App\Repositories\Project\Integrations\Matomba\Repository as MatombaRepository;

class Handler
{
    /**
     * Handler constructor.
     */
    public function __construct(
        private MatombaRepository $matombaRepository,
    )
    {
        //
    }

    /**
     * @param IndexCommand $command
     */
    public function handle(Command $command)
    {
        return $this->matombaRepository->query()->project($command->projectId)->get();
    }
}
