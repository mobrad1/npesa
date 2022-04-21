<?php


namespace App\Traits;


use App\Models\Transaction;
use Illuminate\Support\Str;

trait RecordTransaction
{
    public function recordInternal($amount,$to_number,$channel,$category,$from_number,$toModel = null,$fromModel = null,$account_number = null,$transaction_from_group = "AGOGA",$transaction_to_group = "AGOGA",$transactionType = "internal")
    {

        return Transaction::create([
            "channel" => $channel,
            "transaction_type" => $transactionType,
            "transactional_from_type" => $fromModel != null ? get_class($this) : null,
            "transactional_to_type" =>$toModel != null ? get_class($toModel) : null,
            "transactional_from_id" => optional($fromModel)->id,
            "transactional_to_id" => optional($toModel)->id,
            "transaction_from_group" => $transaction_from_group,// GTB OR ZENITH
            "transaction_to_group" => $transaction_to_group ,// AGOGA
            "transaction_to_user_number" => $to_number,
            "transaction_from_user_number" => $from_number,
            "transaction_category_id" => $category,
            "transaction_reference_internal" => Str::random(10),
            "transaction_reference_external" => Str::random(10),
            "transaction_account_number" => $account_number,
            "transaction_amount" => $amount,
            "transaction_amount_credit" => $amount,
            "transaction_amount_debit" => $amount,
            "transaction_cost" => 50,
            "transaction_cost_credit"=> 50,
            "transaction_cost_debit" => 50,
            "settlements_type" => "Auto",
            "status" => "Complete",
        ]);

    }
    public function recordExternal($amount,$channel,$category,$from_number,$account_number = null,$toModel = null,$fromModel = null,$transaction_from_group = "AGOGA",$transaction_to_group = "AGOGA",$transactionType = "external")
    {
        return Transaction::create([
            "channel" => $channel,
            "transaction_type" => $transactionType,
            "transactional_from_type" => $fromModel != null ? get_class($this) : null,
            "transactional_to_type" =>$toModel != null ? get_class($toModel) : null,
            "transactional_from_id" => optional($fromModel)->id,
            "transactional_to_id" => optional($toModel)->id,
            "transaction_from_group" => $transaction_from_group,// GTB OR ZENITH
            "transaction_to_group" => $transaction_to_group ,// AGOGA
            "transaction_to_user_number" => null,
            "transaction_from_user_number" => $from_number,
            "transaction_category_id" => $category,
            "transaction_reference_internal" => Str::random(10),
            "transaction_reference_external" => Str::random(10),
            "transaction_account_number" => $account_number,
            "transaction_amount" => $amount,
            "transaction_amount_credit" => $amount,
            "transaction_amount_debit" => $amount,
            "transaction_cost" => 50,
            "transaction_cost_credit"=> 50,
            "transaction_cost_debit" => 50,
            "settlements_type" => "Auto",
            "status" => "Complete",
        ]);
    }

}
