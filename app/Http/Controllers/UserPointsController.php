<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Resources\UserCollection;

class UserPointsController extends Controller
{
    /**
     * @OA\Post(

     *  path="/api/{user}/points",

     *  operationId="userPointsStore",

     *  summary="Increment user points",

     *  @OA\Parameter(name="user",

     *    in="query",

     *    required=true,

     *    @OA\Schema(type="integer")

     *  ),

     *  @OA\Response(response="200",

     *    description="User Response",

     *  )

     * )

     */
    public function store(User $user)
    {
        $user->incrementPoints();

        $users = User::query()->latest('points')->get();

        return new UserCollection($users);
    }

    /**
     * @OA\Delete(

     *  path="/api/{user}/points",

     *  operationId="userPointsStore",

     *  summary="Decrement user points",

     *  @OA\Parameter(name="user",

     *    in="query",

     *    required=true,

     *    @OA\Schema(type="integer")

     *  ),

     *  @OA\Response(response="200",

     *    description="User Response",

     *  )

     * )

     */
    public function destroy(User $user)
    {
        $user->decrementPoints();

        $users = User::query()->latest('points')->get();

        return new UserCollection($users);
    }
}
