<?php

namespace Bookworm\Http\Controllers\Auth;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Password as Status;
use Bookworm\Http\Controllers\Controller;
use Bookworm\Support\Validation\ValidatesCaptcha;

class Passwords extends Controller {

    use ValidatesCaptcha;

    /**
     * @var \Illuminate\Contracts\Auth\Guard
     */
    private $auth;
    /**
     * @var \Illuminate\Contracts\Auth\PasswordBroker
     */
    private $passwords;

    public function __construct(Guard $auth, PasswordBroker $passwords)
    {
        $this->auth = $auth;
        $this->passwords = $passwords;

        $this->middleware('guest');
    }

    public function form(Request $request)
    {
        return view('auth.passwords.email');
    }

    public function send(Request $request)
    {
        $this->validateCaptcha($request);

        $this->validate($request, [
            'email' => ['required', 'email']
        ]);

        $status = $this->passwords->sendResetLink($request->only('email'), function(Message $message)
        {
           $message->subject('Reset your password');
        });

        switch ( $status ) {

            case Status::RESET_LINK_SENT:
                notice()->success(trans($status));
                return redirect('login');

            case Status::INVALID_USER:
            default:
                notice()->error(trans($status));
                return redirect()->back();
        }
    }

    public function token(Request $request, $token = null)
    {
        if (is_null($token)) {
            return $this->form($request);
        }

        $email = $request->input('email');

        return view('auth.passwords.reset')
                    ->with('token', $token)
                    ->with('email', $email);
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', 'min:6']
        ]);

        $credentials = $request->only(
            'email', 'password', 'password_confirmation', 'token'
        );

        $status = $this->passwords->reset($credentials, function($user, $password) {
            $user->password = $password;
            $user->save();

            $this->auth->login($user);
        });

        switch ( $status ) {

            case Status::PASSWORD_RESET:

                notice()->success(trans($status));
                return redirect('');

            default:

                notice()->error(trans($status));
                return redirect()->back()
                            ->withInput($request->only('email'));

        }

    }


}
