<?php
namespace App\Services;

use App\Models\BankAccount;

class BankAccountService
{

    
    /**
     * Stores Bank Account Details
     *
     * @param  array $data
     * @return array
     */
    public function storeDetails(array $data)
    {

        $account = BankAccount::create($data);

        return [
            'status'=> $account ? true : false,
            'message'=> $account ? "Account information has been saved" : "An error occured",
            'httpcode'=> $account ? 200 : 500
        ];
    }
}