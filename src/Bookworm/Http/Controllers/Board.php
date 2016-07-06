<?php

namespace Bookworm\Http\Controllers;

use Illuminate\Http\Request;
use Bookworm\Projects\Project;
use Bookworm\Cases\CaseRepository;
use Bookworm\Exceptions\NotFoundException;

class Board extends Controller {

    public function __construct(CaseRepository $case)
    {
        $this->case = $case;
    }

    public function index(Request $request)
    {
        $cases = $this->case->boardForProject($request->project);

        return view('cases.board')
            		->with('cases', $cases);
    }

}
