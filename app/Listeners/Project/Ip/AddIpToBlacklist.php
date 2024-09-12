<?php

namespace App\Listeners\Project\Ip;

use App\Events\Leads\LeadCreated;
use App\Models\Project\Ip;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AddIpToBlacklist implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(LeadCreated $event)
    {
        if(is_null($event->lead->ip))
            return;

        $ip = Ip::query()->firstOrNew(
            attributes: [
                'project_id' => $event->lead->project_id,
                'ip' => $event->lead->ip,
                'enabled' => true,
            ]
        );

        if($ip->enabled){
            $ip->block_until = now()->addDay();
            $ip->save();
        }
    }
}
