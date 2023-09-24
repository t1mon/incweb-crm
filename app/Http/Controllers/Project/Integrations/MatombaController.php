<?php

namespace App\Http\Controllers\Project\Integrations;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project\Integrations\Matomba\Create as CreateRequest;
use App\Models\Project\Host;
use App\Models\Project\Project;

class MatombaController extends Controller
{
    public function index(int $project_id)
    {
        $project = Project::findOrFail($project_id);

        $matombas = Host::where('project_id', $project_id)
            ->where('host', 'like', 'https://%.mtmba.ru')
            ->get();

        $webhookUrl = route(name: 'v2.integrations.matomba.webhook', parameters: $project_id);

        return view(view: 'material-dashboard.project.integrations.matomba.index', data: compact('project', 'matombas', 'webhookUrl'));
    } // index

    public function create(int $project_id)
    {
        $project = Project::findOrFail($project_id);
        return view(view: 'material-dashboard.project.integrations.matomba.create', data: compact('project'));
    } // create

    public function store(CreateRequest $request)
    {
        Host::create([
            'project_id' => $request->project_id,
            'host' => $request->host,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('project.integrations.matomba.index', $request->project_id);
    } // store

    public function edit(int $matomba)
    {
        $matomba = Host::with('project')->findOrFail($matomba);

        return view(
            view: 'material-dashboard.project.integrations.matomba.edit',
            data: [
                'project' => $matomba->project,
                'matomba' => $matomba,
            ]
        );
    } // edit

    public function update(CreateRequest $request, int $matomba)
    {
        $matomba = Host::firstOrFail($matomba);

        $matomba->update([
            'project_id' => $request->project_id,
            'host' => $request->host,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('project.integrations.matomba.index', $matomba->project_id);
    } // update

    public function destroy(int $matomba)
    {
        $matomba = Host::findOrFail($matomba);
        $project_id = $matomba->project_id;
        $matomba->delete();

        return redirect()->route('project.integrations.matomba.index', $project_id);
    } // destroy

}
