<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;

use Modules\Admin\Http\Requests\AdminRegisterRequest;
use Modules\Admin\Services\RegisterService;

class RegisterAPIController extends Controller
{
  public $registerService;
  public function __construct(RegisterService $registerService)
  {
      $this->registerService = $registerService;
  }

    public function store(AdminRegisterRequest $request)
  {
      $data = $request->validated();
      $this->registerService->storeOrUpdate($data);
      return $this->sendResponse([],"Admin registration Successful");
  }
}
