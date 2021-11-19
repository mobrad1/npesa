<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    //
    public function login(Request $request)
    {
        // TODO refactor into a service class responsible for login
        $request->validate([
            "email" => "required|email",
            "password" => "required",
            "device_name" => "required",
        ]);

        $user = User::where("email", $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                "email" => ["The provided credentials are incorrect."],
            ]);
        }

        $token = $user->createToken($request->device_name)->plainTextToken;
        return $this->sendResponse(
            [
                "token" => $token,
                "user" => $user,
            ],
            "Login successfully"
        );
    }
}
