<?php

namespace App\Commands\V2\Project\Integrations\Matomba\Index;

class Command
{
    /**
     * Command constructor.
     */
    public function __construct(
        public readonly int $projectId,
    )
    {
        //
    }
}
