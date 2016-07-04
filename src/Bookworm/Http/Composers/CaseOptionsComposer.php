<?php

namespace Bookworm\Http\Composers;

use Bookworm\Projects\Project;
use Illuminate\View\View;

class CaseOptionsComposer implements Composer {

    /**
     * Bind data to the view.
     *
     * @param  View $view
     *
     * @return void
     */
    public function compose(View $view)
    {
        $projects = Project::orderBy('title', 'asc')->lists('title','ref')->all();

        $view->with('projects', $projects);
    }

}
