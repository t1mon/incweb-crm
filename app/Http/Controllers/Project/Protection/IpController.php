<?php

namespace App\Http\Controllers\Project\Protection;

use App\Http\Controllers\Controller;
use App\Models\Project\Project;
use App\Models\Project\Protection\Ip;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class IpController extends Controller
{
    public function index(int|string $project)
    {
        $project_model = Project::findOrFail($project);
        $ips = Ip::where('project_id', $project)->latest()->paginate(20);
        
        return view(view: 'material-dashboard.project.protection.ip.index', data: ['project' => $project_model, 'ips' => $ips]);
    }

    public function create(int|string $project)
    {
        $project_model = Project::findOrFail($project);
        return view(view: 'material-dashboard.project.protection.ip.create', data: ['project' => $project_model]);
    }

    public function store(Request $request, int|string $project)
    {
        $now = now();
        $request->validate(rules: [
            'project_id' => 'required|exists:projects,id',
            'ip' => ['required', 'ip', Rule::unique('projects_ips')->where('project_id', $request->project_id)],
            'enabled' => 'required|boolean',
            'block_until' => 'required|after:'.$now,
        ]);

        Ip::insert([
            'project_id' => $request->project_id,
            'ip' => $request->ip,
            'enabled' => $request->enabled,
            'block_until' => $request->block_until,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        return redirect()->route(route: 'project.protection.ip.index', parameters: ['project' => $request->project_id]);
    }

    public function edit(int|string $project, int|string $ip)
    {
        $ip_model = Ip::where(['project_id' => $project, 'id' => $ip])->with('project:id,name')->firstOrFail();
        return view(view: 'material-dashboard.project.protection.ip.edit', data: ['project' => $ip_model->project, 'ip' => $ip_model]);
    }

    public function update(Request $request, int|string $project, int|string $ip)
    {
        $request->validate(rules: [
            'project_id' => 'required|exists:projects,id',
            'ip' => ['required', 'ip', Rule::unique('projects_ips')->where('project_id', $request->project_id)->ignore($ip)],
            'enabled' => 'required|boolean',
            'block_until' => 'required|after:now',
        ]);

        $ip_model = Ip::findOrFail($ip);
        $ip_model->update($request->all());

        return redirect()->route(route: 'project.protection.ip.index', parameters: ['project' => $ip_model->project_id]);
    }

    public function destroy(int|string $project, int|string $ip)
    {
        $ip_model = Ip::select(['id', 'project_id'])->findOrFail($ip);
        $project_id = $ip_model->project_id;

        $ip_model->delete();
        return redirect()->route(route: 'project.protection.ip.index', parameters: ['project' => $project_id]);
    }
}
