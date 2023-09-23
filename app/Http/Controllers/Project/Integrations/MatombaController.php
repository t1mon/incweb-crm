<?php

namespace App\Http\Controllers\Project\Integrations;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project\Integrations\Matomba\Create as CreateRequest;
use App\Commands\V2\Project\Integrations\Matomba as Commands;
use App\Models\Project\Project;
use Joselfonseca\LaravelTactician\CommandBusInterface;

class MatombaController extends Controller
{
    public function __construct(
        private CommandBusInterface $bus,
    )
    {
        //
    } // Конструктор

    public function index(int $project_id)
    {
        $project = Project::findOrFail($project_id);

        $this->bus->addHandler(
            command: Commands\Index\Command::class,
            handler: Commands\Index\Handler::class,
        );

        $matombas = $this->bus->dispatch(
            command: Commands\Index\Command::class,
            input: [
                'projectId' => $project_id,
            ],
        );

        return view(view: 'material-dashboard.project.integrations.matomba.index', data: compact('project', 'matombas'));
    } // index

    public function create(int $project_id)
    {
        $project = Project::findOrFail($project_id);
        return view(view: 'material-dashboard.project.integrations.matomba.create', data: compact('project'));
    } // create

    public function store(CreateRequest $request)
    {
        $this->bus->addHandler(
            command: Commands\Create\Command::class,
            handler: Commands\Create\Handler::class,
        );

        $this->bus->dispatch(
            command: Commands\Create\Command::class,
            input: [
                'projectId' => $request->project_id,
                'service' => $request->service,
            ],
        );

        return redirect()->route('project.integrations.matomba.index', $request->project_id);
    } // store

    public function edit(int $matomba)
    {
        $this->bus->addHandler(
            command: Commands\Show\Command::class,
            handler: Commands\Show\Handler::class,
        );

        $matomba = $this->bus->dispatch(
            command: Commands\Show\Command::class,
            input: [
                'matombaId' => $matomba,
            ],
        );

        $project = Project::findOrFail($matomba->project_id);

        return view(view: 'material-dashboard.project.integrations.matomba.edit', data: compact('project', 'matomba'));
    } // edit

    public function update(CreateRequest $request, int $matomba)
    {
        $this->bus->addHandler(
            command: Commands\Update\Command::class,
            handler: Commands\Update\Handler::class,
        );

        $matomba = $this->bus->dispatch(
            command: Commands\Update\Command::class,
            input: [
                'matombaId' => $matomba,
                'service' => $request->service,
            ],
        );

        return redirect()->route('project.integrations.matomba.index', $matomba->project_id);
    } // update

    public function destroy(int $matomba)
    {

    } // destroy

}
