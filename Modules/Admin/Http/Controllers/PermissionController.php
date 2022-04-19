<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Admin\Http\Requests\CreatePermissionRequest;
use Modules\Admin\Http\Requests\UpdatePermissionRequest;
use Modules\Admin\Services\PermissionService;

class PermissionController extends Controller
{
 public $permissionService;

    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
    }
    public function store(CreatePermissionRequest $request)
    {
        $data = $request->validated();
        $role = $this->permissionService->storeOrUpdate($data);
        return $this->sendResponse($role,'Permission created Successfully');
    }
    public function update(UpdatePermissionRequest $request,$id)
    {
        $data = $request->validated();
        $role = $this->permissionService->storeOrUpdate($data,$id);
        return $this->sendResponse($role,'Permission Updated Successfully');
    }
    public function delete($id)
    {
        $this->permissionService->delete($id);
        return $this->sendResponse([],'Permission deleted Successfully');
    }
    public function index()
    {
        $roles = $this->permissionService->all();
        return $this->sendResponse($roles,'Permission fetched successfully');
    }
}
