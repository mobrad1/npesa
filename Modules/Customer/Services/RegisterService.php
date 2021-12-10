<?php


namespace Modules\Customer\Services;


use App\Services\BaseService;
use Illuminate\Support\Facades\Hash;
use Modules\Customer\Entities\Customer;

class RegisterService extends BaseService
{

    public function __construct()
    {
        parent::__construct(Customer::class);
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
