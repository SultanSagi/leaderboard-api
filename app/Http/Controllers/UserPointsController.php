<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserPointsController extends Controller
{
    public function store(User $user)
    {
        $user->incrementPoints();

        return response()->json(['point incremented']);
    }

    public function destroy(User $user)
    {
        $user->decrementPoints();

        return response()->json(['point decremented']);
    }
}
