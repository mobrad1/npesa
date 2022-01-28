<?php


namespace App\Filters;


class TransactionFilter extends Filter
{
    protected $filters = ['transaction_category','amount','date','details'];

    function transaction_category($value)
    {
        return $this->builder->where('transaction_category','=',$value);
    }
    function amount($value)
    {
        return $this->builder->where('amount','=',$value);
    }
    function date($value)
    {
        $from = date($value["from"]);
        $to = date($value["to"]);
        return $this->builder->whereBetween('created_at',[$from,$to]);
    }
    function details($value)
    {

    }
}
