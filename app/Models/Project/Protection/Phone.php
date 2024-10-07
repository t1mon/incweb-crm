<?php

namespace App\Models\Project\Protection;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Phone extends Model
{
    use HasFactory;

    protected $table = 'projects_phones';

    protected $fillable = [
        'project_id',
        'phone',
        'enabled',
        'entries',
        'last_entry_date',
    ];

    protected $casts = [
        'enabled' => 'boolean',
        'entries' => 'integer',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(related: \App\Models\Project\Project::class);
    }
}
