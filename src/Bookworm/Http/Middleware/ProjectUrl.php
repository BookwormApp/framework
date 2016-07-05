<?php 

namespace Bookworm\Http\Middleware;

use Closure;
use Bookworm\Exceptions\NotFoundException;
use Bookworm\Projects\ProjectRepository;
use Illuminate\Contracts\View\Factory;

class ProjectUrl {

    /**
     * @var ProjectRepository
     */
    private $project;
    /**
     * @var Factory
     */
    private $view;

    public function __construct(ProjectRepository $project, Factory $view)
    {
        $this->project = $project;
        $this->view = $view;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     * @throws NotFoundException
     */
	public function handle($request, Closure $next)
	{
        $slug = trim($request->segment(1),' /');

        $project = $this->project->findBySlug($slug);

        if ( ! $project ) {
            throw new NotFoundException('Project not found');
        }

        $request->project = $project;
        $this->view->share('currentProject', $project);

        return $next($request);
	}

}
