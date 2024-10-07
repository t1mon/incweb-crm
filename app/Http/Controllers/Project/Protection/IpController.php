<?php

namespace App\Http\Controllers\Project\Protection;

use App\Http\Controllers\Controller;
use App\Models\Project\Project;
use App\Models\Project\Protection\Ip;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;

class IpController extends Controller
{
    public function index(int|string $project)
    {
        $project_model = Project::findOrFail($project);
        $ips = Ip::where('project_id', $project)->latest()->paginate(20);

        $ips->each(function($ip) use ($project_model){
            $ip->block_until_tz = Carbon::parse(time: $ip->block_until_tz, tz: 'UTC')->setTimezone($project_model->settings['timezone']);
            $ip->created_at_tz = Carbon::parse(time: $ip->created_at, tz: 'UTC')->setTimezone($project_model->settings['timezone']);
            $ip->updated_at_tz = Carbon::parse(time: $ip->updated_at, tz: 'UTC')->setTimezone($project_model->settings['timezone']);
        });
        
        return view(view: 'material-dashboard.project.protection.ip.index', data: ['project' => $project_model, 'ips' => $ips]);
    }

    public function create(int|string $project)
    {
        $project_model = Project::findOrFail($project);
        return view(view: 'material-dashboard.project.protection.ip.create', data: ['project' => $project_model]);
    }

    public function store(Request $request, int|string $project)
    {
        $project_model = Project::select(['id', 'settings'])->findOrFail($project);
        $now = now()->setTimezone($project_model->settings['timezone']);
        $block_until_utc = Carbon::parse(time: $request->block_until, tz: $project_model->settings['timezone'])->setTimezone('UTC');

        $request->validate(rules: [
            'ip' => ['required', 'ip', Rule::unique('projects_ips')->where('project_id', $request->project_id)],
            'enabled' => 'required|boolean',
            'block_until' => 'required|after:'.$now,
        ]);

        Ip::insert([
            'project_id' => $request->project_id,
            'ip' => $request->ip,
            'enabled' => $request->enabled,
            'block_until' => $block_until_utc,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route(route: 'project.protection.ip.index', parameters: ['project' => $request->project_id]);
    }

    public function edit(int|string $project, int|string $ip)
    {
        $ip_model = Ip::where(['project_id' => $project, 'id' => $ip])->with('project:id,name,settings')->firstOrFail();
        $ip_model->block_until_tz = Carbon::parse(time: $ip_model->block_until, tz: 'UTC')->setTimezone($ip_model->project->settings['timezone']);
        return view(view: 'material-dashboard.project.protection.ip.edit', data: ['project' => $ip_model->project, 'ip' => $ip_model]);
    }

    public function update(Request $request, int|string $project, int|string $ip)
    {
        $project_model = Project::select(['id', 'settings'])->findOrFail($project);
        $now = now()->setTimezone($project_model->settings['timezone']);

        $request->validate(rules: [
            'ip' => ['required', 'ip', Rule::unique('projects_ips')->where('project_id', $project_model->id)->ignore($ip)],
            'enabled' => 'required|boolean',
            'block_until' => 'required|after:'.$now,
        ]);

        $block_until_utc = Carbon::parse(time: $request->block_until, tz: $project_model->settings['timezone'])->setTimezone('UTC');

        $ip_model = Ip::findOrFail($ip);
        $ip_model->update([
            'ip' => $request->ip,
            'enabled' => $request->enabled,
            'block_until' => $block_until_utc,
        ]);

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
