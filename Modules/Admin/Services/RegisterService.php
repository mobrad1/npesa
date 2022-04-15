<?php


namespace Modules\Admin\Services;


use App\Services\BaseService;
use Illuminate\Support\Facades\Hash;
use Modules\Admin\Entities\Admin;

class RegisterService extends BaseService
{

    public function __construct()
    {
        parent::__construct(Admin::class);
    }

    /**
     * @param array $attributes
     * @param int|null $id
     * @return mixed
     */
    public function storeOrUpdate(array $attributes, int $id = null)
    {
        $model = $id == null ? new $this->class :  $this->find($id);
        $attributes['pin'] = Hash::make($attributes['pin']);
        $model->fill($attributes);
        $model->save();
        return $model;
    }

}
