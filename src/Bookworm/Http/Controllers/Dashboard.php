<?php

namespace Bookworm\Http\Controllers;

use Bookworm\Http\Controllers\Controller;

class Dashboard extends Controller {

	public function index()
	{
		return view('dashboard');
	}

}