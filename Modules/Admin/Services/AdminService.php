<?php


namespace Modules\Admin\Services;


use App\Services\BaseService;
use Modules\Admin\Entities\Admin;

class AdminService extends BaseService
{
    public function __construct()
    {
        parent::__construct(Admin::class);
    }
    public function storeOrUpdate(array $attributes, int $id = null)
    {
        $model = $id == null ? new $this->class :  $this->find($id);
        if(isset($attributes['role'])){
            $model->syncRoles($attributes['role']);
        }
        unset($attributes['role']);
        $model->fill($attributes);
        $model->save();
        return $model;
    }
}
