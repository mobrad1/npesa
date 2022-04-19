<?php

namespace Modules\Admin\Http\Controllers;


use App\Http\Controllers\Controller;
use Modules\Admin\Http\Requests\CreateRoleRequest;
use Modules\Admin\Http\Requests\UpdateRoleRequest;
use Modules\Admin\Services\RoleService;

class RoleController extends Controller
{
    public $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }
    public function store(CreateRoleRequest $request)
    {
        $data = $request->validated();
        $role = $this->roleService->storeOrUpdate($data);
        return $this->sendResponse($role,'Role created Successfully');
    }
    public function update(UpdateRoleRequest $request,$id)
    {
        $data = $request->validated();
        $role = $this->roleService->storeOrUpdate($data,$id);
        return $this->sendResponse($role,'Role Updated Successfully');
    }
    public function delete($id)
    {
        $this->roleService->delete($id);
        return $this->sendResponse([],'Role deleted Successfully');
    }
    public function index()
    {
        $roles = $this->roleService->all();
        return $this->sendResponse($roles,'Role fetched successfully');
    }
    public function addPermissions($id)
    {
        $permissions =  request('permissions');
        $result = $this->roleService->addPermissions($permissions,$id);
        return $this->sendResponse($result,'Permission added to role');
    }
    public function removePermissions($id)
    {
        $permissions =  request('permissions');
        $result = $this->roleService->removePermissions($permissions,$id);
        return $this->sendResponse($result,'Permission removed from role');
    }
}
