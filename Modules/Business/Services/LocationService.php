<?php


namespace Modules\Business\Services;


use App\Filters\BusinessFilter;
use App\Services\BaseService;
use Modules\Business\Entities\Business;

class LocationService extends BaseService
{
    public function __construct()
    {
        parent::__construct(Business::class);
    }

    public function findATM(array $attributes)
    {
        return Business::all();
    }
    public function findBusiness(array $attributes)
    {
        return Business::all();
    }
    public function findBank(array $attributes)
    {
        return Business::all();
    }
    public function findAgent(array $attributes)
    {
        return Business::all();
    }
}
