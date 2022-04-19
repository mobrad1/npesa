<?php


namespace Modules\Admin\Services;


use App\Services\BaseService;
use Spatie\Permission\Models\Role;

class RoleService extends BaseService
{
    public function __construct()
    {
        parent::__construct(Role::class);
    }
    public function addPermissions($attributes,$id)
    {
        $role = $this->find($id);
        return  $role->syncPermissions($attributes);
    }
    public function removePermissions($attributes,$id)
    {
        $role = $this->find($id);
        return  $role->revokePermissionTo($attributes);
    }
}
