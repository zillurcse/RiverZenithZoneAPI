<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthLoginRequest;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function login(AuthLoginRequest $request){
        $credential = $request->validated();
        $user =  Admin::where('email', $credential['email'])->first();
        $match = Hash::check($credential['password'], $user->password);
        if ($match){
            $user['token'] = $user->createToken('admin-token')->plainTextToken;
            return $this->helper()->response('login successfully', $user);
        }
    }
}
