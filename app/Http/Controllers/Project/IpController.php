<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Models\Project\Ip;
use Illuminate\Http\Request;

class IpController extends Controller
{
    public function index(int|string $project)
    {
        $ips = Ip::where('project_id', $project)->latest()->paginate(20);
        return view(view: 'material-dashboard.project.ip.index', data: ['ips' => $ips]);
    }

    public function edit(int|string $ip)
    {
        $ip_model = Ip::with('project:id,name')->firstOrFail($ip);
        return view(view: 'material-dashboard.project.ip.edit', data: ['ip' => $ip_model]);
    }

    public function update(Request $request, int|string $ip)
    {
        $request->validate(rules: [
            'project_id' => 'required|exists:projects,id',
            'ip' => 'required|unique:projects_ips:ip,'.$ip,
            'enabled' => 'required|boolean',
            'block_until' => 'required|after:now',
        ]);

        $ip_model = Ip::findOrFail($ip);
        $ip_model->update($request->all());

        return redirect()->route(route: 'project.ip.index', parameters: ['project' => $ip_model->project_id]);
    }

    public function destroy(int|string $ip)
    {
        $ip_model = Ip::select(['id', 'project_id'])->findOrFail($ip);
        $project_id = $ip_model->project_id;

        $ip_model->delete();
        return redirect()->route(route: 'project.ip.index', parameters: ['project' => $project_id]);
    }
}
