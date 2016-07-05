<?php

namespace Bookworm\Http\Controllers;

use Bookworm\Exceptions\NotFoundException;
use Bookworm\Exceptions\PermissionException;
use Bookworm\Projects\ProjectRepository;
use Illuminate\Http\Request;

class Projects extends Controller {

    public function __construct(ProjectRepository $project)
    {
        $this->project = $project;
    }

    public function index(Request $request)
    {
        $filters = $request->except(['page','sort']);
        $sort = $request->input('sort');

        $projects = $this->project->search($filters, $sort);

        return view('projects.index')
            ->with('projects', $projects);
    }

    public function create(Request $request)
    {
        return view('projects.form')
            ->with('project', false);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => ['required'],
            'slug' => ['required', 'alpha_dash', 'unique:projects,slug']
        ]);

        $project = $this->project->create($request->input(), [
            'createdBy' => $request->user()
        ]);

        notice('New project created');

        return redirect('settings/projects');
    }

    public function edit($ref, Request $request)
    {
        $project = $this->project->findByRef($ref);

        if ( ! $project ) {
            throw new NotFoundException;
        }

        return view('projects.form')
            ->with('project', $project);
    }

    public function update($ref, Request $request)
    {
        $project = $this->project->findByRef($ref);

        if ( ! $project ) {
            throw new NotFoundException;
        }

        $this->validate($request, [
            'title' => ['required'],
            'slug' => ['required', 'alpha_dash', 'unique:projects,slug,'.$project->id]
        ]);

        $project = $this->project->update($project, $request->input());

        notice()->success('Updated project');

        return redirect('settings/projects');
    }

    public function destroy($ref, Request $request)
    {
        $project = $this->project->findByRef($ref);

        if ( ! $project ) {
            throw new NotFoundException;
        }

        $this->project->delete($project);

        notice('Deleted project');

        return redirect('settings/projects');
    }

}
