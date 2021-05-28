<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserCollection;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    /**
     * @OA\Post(

     *  path="/api/users",

     *  operationId="usersStore",

     *  summary="Create a user",

     *  @OA\Parameter(name="name",

     *    in="query",

     *    required=true,

     *    @OA\Schema(type="string")

     *  ),

     *  @OA\Response(response="200",

     *    description="User Response",

     *  )

     * )

     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        User::create($request->all());

        return response()->json('User created', 201);
    }

    /**
     * @OA\Get(

     *  path="/api/users",

     *  operationId="usersList",

     *  summary="Get all users",


     *  @OA\Response(response="200",

     *    description="User Response",

     *  )

     * )

     */
    public function index()
    {
        $users = User::query()->latest('points')->get();

        return new UserCollection($users);
    }

    /**
     * @OA\Delete(

     *  path="/api/users/{user}",

     *  operationId="usersDelete",

     *  summary="Delete a user",

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
        $user->delete();

        return response()->json([], 204);
    }
}
