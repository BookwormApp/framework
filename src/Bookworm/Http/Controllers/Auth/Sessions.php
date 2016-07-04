<?php

namespace Bookworm\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Guard;
use Bookworm\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;

class Sessions extends Controller
{
    use ThrottlesLogins;

    protected $auth;

    public function __construct(Guard $auth)
    {
        $this->auth = $auth;

        $this->middleware('guest', ['except' => ['logout', 'session']]);
    }

    public function create()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if ($this->hasTooManyLoginAttempts($request)) {
            return $this->sendLockoutResponse($request);
        }

        $credentials = ['email' => $request->input('email'), 'password' => $request->input('password')];
        $remember = $request->has('remember');

        if ($this->auth->attempt($credentials, $remember)) {
            $this->clearLoginAttempts($request);

            return redirect('');
        }

        $this->incrementLoginAttempts($request);
        notice()->error('Invalid login details');

        return redirect('login')->withInput($request->except('password'));
    }

    public function destroy()
    {
        $this->auth->logout();

        return redirect('login');
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function loginUsername()
    {
        return 'email';
    }
}
