<?php

namespace App\Jobs\Protection;

use App\Models\Project\Protection\Phone;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdatePhoneEntries implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        private int $project_id,
        private string $phone
    )
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $phone = Phone::where([
            'project_id' => $this->project_id,
            'phone' => $this->phone
        ])->firstOrFail();
        
        $phone->update([
            'entries' => $phone->entries + 1,
            'last_entry_date' => now(),
        ]);
    }
}
