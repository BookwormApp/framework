<?php

namespace Bookworm\Http\Controllers;

class Dashboard extends Controller
{
    public function index()
    {
        return view('dashboard');
    }
}
