<?php


namespace Modules\Admin\Services;


use App\Services\BaseService;
use Modules\Admin\Entities\Admin;

class LoginService extends BaseService
{
    public function __construct()
    {
        parent::__construct(Admin::class);
    }
}
