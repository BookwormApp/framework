<?php

namespace Bookworm\Http\Composers;

use Illuminate\View\View;

interface Composer {

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view);

}
