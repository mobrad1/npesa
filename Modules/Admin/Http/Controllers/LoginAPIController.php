<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Modules\Admin\Http\Requests\LoginRequest;
use Modules\Admin\Services\LoginService;

class LoginAPIController extends Controller
{
  public $loginService;
  public function __construct(LoginService $loginService)
  {
      $this->loginService = $loginService;
  }

  public function store(LoginRequest $request)
  {
    $data = $request->validated();
    $admin = $this->loginService->filter(['phone',$data['phone']])->first();
    if (!$admin || !Hash::check($data['pin'], $admin->pin)) {
            throw ValidationException::withMessages([
                "phone" => ["The provided credentials are incorrect."],
                "pin" => ["Pin doesnt match with phone number"]
            ]);
        }

    $token = $admin->createToken($data['device_name'])->plainTextToken;
    return $this->sendResponse(
            [
                "token" => $token,
                "admin" => $admin,
            ],
            "Customer Login successfully"
    );
  }
}
