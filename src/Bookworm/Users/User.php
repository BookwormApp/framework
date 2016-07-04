<?php

namespace Bookworm\Users;

use Bookworm\Support\Entities\Model;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements
    AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    protected $table = 'users';
    protected $fillable = ['name', 'email', 'password'];
    protected $hidden = ['password', 'remember_token'];

    /* Attributes */

    public function setPasswordAttribute($password)
    {
        $this->setPassword($password);
    }

    public function setPassword($password, $hashed = false)
    {
        if (!empty($password)) {
            $password = $hashed ? $password : bcrypt($password);
            $this->attributes['password'] = $password;
        }

        return $this;
    }
}
