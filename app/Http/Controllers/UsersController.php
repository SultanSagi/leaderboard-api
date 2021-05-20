<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserCollection;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        User::create($request->all());

        return response()->json('User created', 201);
    }

    public function index()
    {
        $users = User::query()->get();

        return new UserCollection($users);
    }

    public function destroy(User $user)
    {
        $user->delete();

        return response()->json([], 204);
    }
}
