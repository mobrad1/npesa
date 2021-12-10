<?php

namespace Modules\Customer\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;

use Modules\Customer\Http\Requests\CustomerRegisterRequest;
use Modules\Customer\Services\RegisterService;

class RegisterAPIController extends Controller
{
  public $registerService;
  public function __construct(RegisterService $registerService)
  {
      $this->registerService = $registerService;
  }

    public function store(CustomerRegisterRequest $request)
  {
      $data = $request->validated();
      $this->registerService->storeOrUpdate($data);
      return $this->sendResponse([],"Customer registration Successful");
  }
}
