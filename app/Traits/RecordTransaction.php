<?php


namespace App\Traits;


use App\Models\Transaction;

trait RecordTransaction
{
    public function recordReciepient($amount,$channel,$transactionType,$transaction_category,$transaction_from_group,$transaction_to_group,$transaction_to_account_number,$transaction_from_account_number,$toModel = null,$fromModel = null)
    {
        Transaction::create([
            "channel" => $channel,
            "transaction_type" => $transactionType,
            "transactional_from_type" => $fromModel != null ? get_class($fromModel) : null,
            "transactional_to_type" =>$toModel != null ? get_class($toModel) : null,
            "transactional_from_id" => optional($fromModel)->id,
            "transactional_to_id" => optional($toModel)->id,
            "transaction_category" => $transaction_category,
            "transaction_from_group" => $transaction_from_group,// GTB OR ZENITH
            "transaction_to_group" => $transaction_to_group ,// AGOGA
            "transaction_to_account_number" => $transaction_to_account_number,
            "transaction_from_account_number" => $transaction_from_account_number,
            "transaction_cost" => 50,
            "reference" => "bread",
            "amount" => $amount,
            "status" => "Complete",
        ]);
    }
    public function recordSender($amount,$channel,$transactionType,$transaction_category)
    {
        Transaction::create([
            "channel" => $channel,
            "transaction_type" => $transactionType,
            "transactional_type" => get_class($this),
            "transactional_id" => $this->id,
            "transaction_category" => $transaction_category,
            "transaction_cost" => 50,
            "reference" => "bread",
            "amount" => $amount,
            "status" => "Complete",
            "direction" => "Debit"
        ]);
    }
}
