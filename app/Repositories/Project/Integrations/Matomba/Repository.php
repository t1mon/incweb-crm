<?php

namespace App\Repositories\Project\Integrations\Matomba;

use App\Models\Project\Integrations\Matomba;
use App\Models\Project\Project;
use Illuminate\Database\Eloquent\Builder;

class Repository{
    public function query(): Builder
    {
        return Matomba::query();
    } // query

    public function create(Project|int $project, string $service): Matomba
    {
        return $this->query()->create([
            'project_id' => $project instanceof Project ? $project->id : $project,
            'service' => $service,
        ]);
    }

    public function update(Matomba|int $matomba, string $service): Matomba
    {
        if(is_int($matomba))
            $matomba = Matomba::findOrFail($matomba);

        $matomba->update(['service' => $service]);
        
        return $matomba;
    } // update

    public function delete(Matomba|int $matomba): void
    {
        if(is_int($matomba))
            $matomba = Matomba::findOrFail($matomba);

        $matomba->delete();
    } // delete
};