<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index() {

        $users = User::latest()->get();

        return $users;
    }

    public  function store() {
        request()->validate([
            // 'name' => 'required',
            'email' => 'required|unique:users,email',
            // 'password' => 'required|min:8',
        ]);
        return User::create([

            'name' => request('name'),
            'email' => request('email'),
            'password' =>bcrypt(request('password')),
        ]);
    }

    public function update(User $user)
    {
        // request()->validate([
        //     'name' => 'required',
        //     'email' => 'required|unique:users,email,'.$user->id,
        //     'password' => 'sometimes|min:8',
        // ]);

        $user->update([
            'name' => request('name'),
            'email' => request('email'),
            'password' => request('password') ? bcrypt(request('password')) : $user->password,
        ]);

        return $user;
    }
}
