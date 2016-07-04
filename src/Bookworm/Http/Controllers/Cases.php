<?php

namespace Bookworm\Http\Controllers;

use Bookworm\Exceptions\NotFoundException;
use Bookworm\Cases\CaseRepository;
use Bookworm\Projects\Project;
use Illuminate\Http\Request;

class Cases extends Controller {

    public function __construct(CaseRepository $case)
    {
        $this->case = $case;
    }

    public function index(Request $request)
    {
        $filters = $request->except(['page','sort']);
        $sort = $request->input('sort');

        $cases = $this->case->search($filters, $sort);

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
            'project' => ['exists:projects,ref']
        ]);

        $related = [];

        if ( $request->input('project') ) {
            $related['project'] = Project::where('ref','=',$request->input('project'))->first();
        }

        $case = $this->case->create($request->input(), [
            'createdBy' => $request->user()
        ], $related);

        notice('New case created');

        return redirect('cases');
    }

    public function edit($ref, Request $request)
    {
        $case = $this->case->findByRef($ref);

        if ( ! $case ) {
            throw new NotFoundException;
        }

        return view('cases.form')
            ->with('case', $case);
    }

    public function update($ref, Request $request)
    {
        $case = $this->case->findByRef($ref);

        if ( ! $case ) {
            throw new NotFoundException;
        }

        $this->validate($request, [
            'title' => ['required'],
        ]);

        $related = [];

        if ( $request->input('project') ) {
            $related['project'] = Project::where('ref','=',$request->input('project'))->first();
        }

        $case = $this->case->update($case, $request->input(), $related);

        notice()->success('Updated case');

        return redirect('cases');
    }

    public function destroy($ref, Request $request)
    {
        $case = $this->case->findByRef($ref);

        if ( ! $case ) {
            throw new NotFoundException;
        }

        $this->case->delete($case);

        notice('Deleted case');

        return redirect('cases');
    }

}
