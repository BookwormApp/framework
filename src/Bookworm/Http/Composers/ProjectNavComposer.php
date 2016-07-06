<?php

namespace Bookworm\Http\Composers;

use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Bookworm\Projects\ProjectRepository;

class ProjectNavComposer {

	protected $project;

	protected $request;

	public function __construct(ProjectRepository $project, Request $request)
	{
		$this->project = $project;
		$this->request = $request;
	}

	public function compose(View $view)
	{
		$current = $this->request->project;
		$projects = $this->project->allActive();
		$projects = $projects->filter(function($project) use($current) {
			return ! $project->is($current);
		});

		$view->with('projects', $projects);
	}

}