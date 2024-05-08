<?php

namespace App\Http\Controllers\Admin;

use App\Admin\Message;
use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\UserResource;

class UserController extends Controller
{
    public function info(){
        $user = UserResource::make(admin()->user);
        return $this->helper()->response(Message::FETCH(), $user);
    }
}
