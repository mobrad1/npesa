<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Admin\Http\Requests\AdminUpdateRequest;
use Modules\Admin\Services\AdminService;


class AdminController extends Controller
{
    public $adminService;

    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }
    public function update(AdminUpdateRequest $request,$id)
    {
        $data = $request->validated();
        $admin = $this->adminService->storeOrUpdate($data,$id);
        return $this->sendResponse($admin,"Admin updated successfully");
    }

}
