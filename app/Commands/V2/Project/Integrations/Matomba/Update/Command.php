<?php

namespace App\Commands\V2\Project\Integrations\Matomba\Update;

class Command
{
    /**
     * Command constructor.
     */
    public function __construct(
        public readonly int $matombaId,
        public readonly string $service,
    )
    {
        //
    }
}
