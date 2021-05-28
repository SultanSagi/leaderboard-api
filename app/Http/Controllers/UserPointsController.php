<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Resources\UserCollection;

class UserPointsController extends Controller
{
    public function store(User $user)
    {
        $user->incrementPoints();

        $users = User::query()->latest('points')->get();

        return new UserCollection($users);
    }

    public function destroy(User $user)
    {
        $user->decrementPoints();

        $users = User::query()->latest('points')->get();

        return new UserCollection($users);
    }
}
