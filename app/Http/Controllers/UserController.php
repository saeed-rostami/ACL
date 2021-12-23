<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $user = User::query()->find($request->user_id);



       return $user->isAuthorized('post' , 'delete' , $user->id);
    }
}
