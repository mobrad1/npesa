<?php

namespace Modules\Customer\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Modules\Customer\Http\Requests\LoginRequest;
use Modules\Customer\Services\LoginService;

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
    $customer = $this->loginService->filter(['phone_number',$data['phone_number']])->first();
    if (!$customer || !Hash::check($data['pin'], $customer->pin)) {
            throw ValidationException::withMessages([
                "phone_number" => ["The provided credentials are incorrect."],
                "pin" => ["Pin doesnt match with phone number"]
            ]);
        }

    $token = $customer->createToken($data['device_name'])->plainTextToken;
    return $this->sendResponse(
            [
                "token" => $token,
                "customer" => $customer,
            ],
            "Customer Login successfully"
    );
  }
}
