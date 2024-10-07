<?php

namespace App\Http\Controllers\Project\Protection;

use App\Http\Controllers\Controller;
use App\Models\Project\Project;
use App\Models\Project\Protection\Phone;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;

class PhoneController extends Controller
{
    public function index(int|string $project)
    {
        $project_model = Project::findOrFail($project);
        $phones = Phone::where('project_id', $project)->paginate(20);
        $phones->each(function($phone) use ($project_model){
            $phone->last_entry_date_tz = is_null($phone->last_entry_date) ? null : Carbon::parse(time: $phone->last_entry_date, tz: $project_model->settings['timezone']);
            $phone->created_at_tz = Carbon::parse(time: $phone->created_at, tz: $project_model->settings['timezone']);
            $phone->updated_at_tz = Carbon::parse(time: $phone->updated_at, tz: $project_model->settings['timezone']);
        });

        return view(view: 'material-dashboard.project.protection.phone.index', data: ['project' => $project_model, 'phones' => $phones]);
    }

    public function create(int|string $project)
    {
        $project_model = Project::findOrFail($project);
        return view(view: 'material-dashboard.project.protection.phone.create', data: ['project' => $project_model]);
    }

    public function store(Request $request, int|string $project)
    {
        Project::select('id')->findOrFail($project);

        $request->validate(rules: [
            'phone' => [
                'required',
                'regex:/^\d+$/s',
                Rule::unique('projects_phones')->where('project_id', $project),
            ],

            'enabled' => 'required|boolean',
        ]);

        Phone::insert([
            'project_id' => $project,
            'phone' => $request->phone,
            'enabled' => $request->enabled,
            'entries' => 0,
            'last_entry_date' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route(route: 'project.protection.phone.index', parameters: ['project' => $project]);
    }

    public function edit(int|string $project, int|string $phone)
    {
        $project_model = Project::findOrFail($project);
        $phone_model = Phone::findOrFail($phone);

        return view(view: 'material-dashboard.project.protection.phone.edit', data: ['project' => $project_model, 'phone' => $phone_model]); 
    }

    public function update(Request $request, int|string $project, int|string $phone)
    {
        Project::select('id')->findOrFail($project);

        $request->validate(rules: [
            'phone' => [
                'required',
                'regex:/^\d+$/s',
                Rule::unique('projects_phones')->where('project_id', $project),
            ],

            'enabled' => 'required|boolean',
        ]);

        $phone_model = Phone::findOrFail($phone);

        $phone_model->update([
            'phone' => $request->phone,
            'enabled' => $request->enabled,
        ]);

        return redirect()->route(route: 'project.protection.phone.index', parameters: ['project' => $project]);
    }

    public function destroy(int|string $project, int|string $phone)
    {
        Project::select('id')->findOrFail($project);
        Phone::destroy($phone);
        return redirect()->route(route: 'project.protection.phone.index', parameters: ['project' => $project]);
    }
}
