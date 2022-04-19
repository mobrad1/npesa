<?php


namespace App\Services;


use App\Services\BaseService;
use Modules\Business\Entities\Business;


class LocationService extends BaseService
{
    public function __construct()
    {
        parent::__construct(Business::class);
    }

    public function findATM($filter)
    {
        return Business::all();
    }
    public function findBusiness($filter)
    {
        return Business::all();
    }
    public function findBank($filter)
    {
        return Business::all();
    }
    public function findAgent($filter)
    {
        return Business::all();
    }
}
