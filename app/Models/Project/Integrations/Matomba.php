<?php

namespace App\Models\Project\Integrations;

use App\Models\Project\Project;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    //  Фильтры
    //
    public function scopeProject(Builder $query, Project|int $project): void
    {
        $query->where('project_id', $project instanceof Project ? $project->id : $project);
    } // scopeProject
}
