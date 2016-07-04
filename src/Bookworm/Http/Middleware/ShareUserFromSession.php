<?php

namespace Bookworm\Http\Middleware;

use Closure;
use Illuminate\Contracts\View\Factory as ViewFactory;

class ShareUserFromSession
{
    /**
     * @var \Illuminate\Contracts\View\Factory
     */
    private $view;

    public function __construct(ViewFactory $view)
    {
        $this->view = $view;
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $this->view->share('me', $request->user());

        return $next($request);
    }
}
