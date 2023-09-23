<?php

namespace App\Models\Project\Integrations;

use App\Models\Project\Project;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Matomba extends Model
{
    use HasFactory;

    protected $table = 'integrations_matomba';

    protected $fillable = [
        'project_id',
        'service',
    ];

    public $timestamps = false;

    //
    //  Связи
    //
    public function project(): BelongsTo
    {
        return $this->belongsTo(related: Project::class);
    } // project

    //
    //  Фильтры
    //
    public function scopeProject(Builder $query, Project|int $project): void
    {
        $query->where('project_id', $project instanceof Project ? $project->id : $project);
    } // scopeProject

    public function scopeService(Builder $query, string $service): void
    {
        $query->where('service', $service);
    } // scopeService
}
