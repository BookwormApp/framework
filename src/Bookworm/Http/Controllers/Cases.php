<?php

namespace Bookworm\Http\Controllers;

use Illuminate\Http\Request;
use Bookworm\Projects\Project;
use Bookworm\Cases\CaseRepository;
use Bookworm\Exceptions\NotFoundException;

class Cases extends Controller {

    public function __construct(CaseRepository $case)
    {
        $this->case = $case;
    }

    public function index(Request $request)
    {
        $filters = $request->except(['page','sort']);
        $sort = $request->input('sort');

        $cases = $this->case->searchForProject($request->project, $filters, $sort);

        return view('cases.index')
            ->with('cases', $cases);
    }

    public function create(Request $request)
    {
        return view('cases.form')
            ->with('case', false);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => ['required'],
            'project' => ['exists:projects,ref'],
            'type' => ['required', 'in:'.implode(',', array_keys(config('cases.types')))]
        ]);

        $case = $this->case->create($request->input(), [
            'createdBy' => $request->user(),
            'project' => $request->project
        ]);

        notice('New case created');

        return project_redirect('cases');
    }

    public function view($project, $ref, Request $request)
    {
        $case = $this->case->findByRef($ref);

        if ( ! $case ) {
            throw new NotFoundException;
        }

        return view('cases.view')
                ->with('case', $case);
    }

    public function edit($project, $ref, Request $request)
    {
        $case = $this->case->findByRef($ref);

        if ( ! $case ) {
            throw new NotFoundException;
        }

        return view('cases.form')
            ->with('case', $case);
    }

    public function update($project, $ref, Request $request)
    {
        $case = $this->case->findByRef($ref);

        if ( ! $case ) {
            throw new NotFoundException;
        }

        $this->validate($request, [
            'title' => ['required'],
            'type' => ['required', 'in:'.implode(',', array_keys(config('cases.types')))]
        ]);


        $case = $this->case->update($case, $request->input());

        notice()->success('Updated case');

        return project_redirect('cases');
    }

    public function destroy($project, $ref, Request $request)
    {
        $case = $this->case->findByRef($ref);

        if ( ! $case ) {
            throw new NotFoundException;
        }

        $this->case->delete($case);

        notice('Deleted case');

        return project_redirect('cases');
    }

}
