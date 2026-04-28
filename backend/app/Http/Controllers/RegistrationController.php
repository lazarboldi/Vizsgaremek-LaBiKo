<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Models\User;

class RegistrationController extends Controller
{
    public function registration(StoreUserRequest $request)
    {
        $data = $request->validated();
        $data['role'] = 'user';
        $user = User::create($data);

        return response()->json([
            'message' => "A(z) {$user->email} sikeresen regisztrálva.",
            'user' => $user,
        ]);
    }
}
