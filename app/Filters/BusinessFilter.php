<?php


namespace App\Filters;


class BusinessFilter extends Filter
{
    protected $filters = ['latitude','longitude','business_name','business_no','category_id'];

    function latitude($value)
    {
        return $this->builder->where('latitude','=',$value);
    }
    function longitude($value)
    {
        return $this->builder->where('longitude','=',$value);
    }
    public function business_name($value){
        return $this->builder->where('business_name',$value);
    }
    public function business_no($value)
    {
        return $this->builder->where('business_no',$value);
    }
    public function category_id($value)
    {
        return $this->builder->where('category_id',$value);
    }
}
