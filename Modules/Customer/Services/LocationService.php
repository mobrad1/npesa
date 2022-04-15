<?php


namespace Modules\Customer\Services;


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
        return Business::where('latitude',$attributes['latitude'])
            ->where('longitude',$attributes['longitude']);
    }
    public function findBusiness(array $attributes)
    {
        return Business::where('latitude',$attributes['latitude'])
            ->where('longitude',$attributes['longitude']);
    }
    public function findBank(array $attributes)
    {
        return Business::where('latitude',$attributes['latitude'])
            ->where('longitude',$attributes['longitude']);
    }
    public function findAgent(array $attributes)
    {
        return Business::where('latitude',$attributes['latitude'])
            ->where('longitude',$attributes['longitude']);
    }
}
