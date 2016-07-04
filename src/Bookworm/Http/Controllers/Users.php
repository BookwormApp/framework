<?php

namespace Bookworm\Http\Controllers;

use Bookworm\Events\UserCreated;
use Bookworm\Exceptions\NotFoundException;
use Bookworm\Exceptions\PermissionException;
use Bookworm\Users\UserRepository;
use Illuminate\Http\Request;

class Users extends Controller {

    /**
     * @var \Bookworm\Users\UserRepository
     */
    private $user;

    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }

    public function index(Request $request)
    {
        $filters = $request->except(['page','sort']);
        $sort = $request->input('sort');

        $users = $this->user->search($filters, $sort);

        return view('users.index')
                    ->with('users', $users);
    }

    public function create(Request $request)
    {
        return view('users.form')
                    ->with('user', false);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required'],
            'email' => ['required', 'unique:users,email'],
            'password' => ['required', 'confirmed']
        ]);

        $user = $this->user->create($request->input());

        event(new UserCreated($user));

        notice('New user created');

        return redirect('settings/users');
    }

    public function edit($ref, Request $request)
    {
        $user = $this->user->findByRef($ref);

        if ( ! $user ) {
            throw new NotFoundException;
        }

        return view('users.form')
                    ->with('user', $user);
    }

    public function update($ref, Request $request)
    {
        $user = $this->user->findByRef($ref);

        if ( ! $user ) {
            throw new NotFoundException;
        }

        $this->validate($request, [
            'name' => ['required'],
            'email' => ['required', 'unique:users,email,'.$user->id],
            'password' => ['confirmed'],
        ]);

        $user = $this->user->update($user, $request->input());

        notice()->success('Updated user');

        return redirect('settings/users');
    }

    public function destroy($ref, Request $request)
    {
        $user = $this->user->findByRef($ref);

        if ( ! $user ) {
            throw new NotFoundException;
        }

        if ( $request->user()->is($user) ) {
            throw new PermissionException('You cannot delete yourself');
        }

        $this->user->delete($user);

        notice('Deleted user');

        return redirect('settings/users');
    }

}
