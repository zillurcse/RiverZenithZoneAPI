<?php

namespace App;

use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Model;

class AdminAuthenticationClass extends Model implements
AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract
{
    use \Illuminate\Auth\Authenticatable, \Illuminate\Foundation\Auth\Access\Authorizable, \Illuminate\Auth\Passwords\CanResetPassword, \Illuminate\Auth\MustVerifyEmail;
    protected $table = "admins";
}
