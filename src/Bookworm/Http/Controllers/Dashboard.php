<?php

namespace Bookworm\Http\Controllers;

use Bookworm\Projects\ProjectRepository;

class Dashboard extends Controller
{
	
	protected $project;

	public function __construct(ProjectRepository $project)
	{
		$this->project = $project;
	}

    public function index()
    {
    	$projects = $this->project->allActive();

        return view('dashboard')
        			->with('projects', $projects);
    }
}
