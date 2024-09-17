<?php

namespace App\Models\Project\Protection;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ip extends Model
{
    use HasFactory;

    protected $table = 'projects_ips';

    protected $fillable = [
        'project_id',
        'ip',
        'enabled',
        'block_until',
    ];

    protected $casts = [
        'enabled' => 'boolean',
    ];

    public const DEFAULT_BLOCK_DAYS = 1;

    public function project(): BelongsTo
    {
        return $this->belongsTo(related: \App\Models\Project\Project::class);
    }
}
