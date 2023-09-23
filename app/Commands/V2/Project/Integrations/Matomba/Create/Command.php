<?php

namespace App\Commands\V2\Project\Integrations\Matomba\Create;

class Command
{
    /**
     * Command constructor.
     */
    public function __construct(
        public readonly int $projectId,
        public readonly string $service,
    )
    {
    }
}
