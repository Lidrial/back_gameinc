<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(User $user)
    {
        //
        return $user->all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $storeUserRequest)
    {
        //
//        dd($request->all());
        $validatedData = $storeUserRequest->validated();
        $user = User::create($validatedData);

        return response()->json($user, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        return User::find($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $updateUserRequest, string $id)
    {
        //
        $user = User::findOrFail($id);
        if (!$user) {
            // User with the given ID not found
            return response()->json(['message' => 'Profil inexistant'], 404);
        }

        $user->update($updateUserRequest->all());

        // User profile successfully updated
        return response()->json(['message' => 'Profil mis à jour'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $user = User::destroy($id);
        if (!$user) {
            // User with the given ID not found
            return response()->json(['message' => 'Profil inexistant'], 404);
        }

        // User profile successfully deleted
        return response()->json(['message' => 'Profil supprimé'], 200);
    }
}
