<?php


namespace Modules\Admin\Services;


use App\Services\BaseService;
use Spatie\Permission\Models\Permission;

class PermissionService extends BaseService
{
    public function __construct()
    {
        parent::__construct(Permission::class);
    }

}
