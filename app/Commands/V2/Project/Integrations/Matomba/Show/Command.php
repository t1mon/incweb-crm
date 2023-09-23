<?php

namespace App\Commands\V2\Project\Integrations\Matomba\Show;

class Command
{
    /**
     * Command constructor.
     */
    public function __construct(
        public readonly int $matombaId,
    )
    {
        //
    }
}
