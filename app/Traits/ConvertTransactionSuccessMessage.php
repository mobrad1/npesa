<?php


namespace App\Traits;


use Carbon\Carbon;

trait ConvertTransactionSuccessMessage
{
    public function moneySentMessage($transaction)
    {
        $done_at = Carbon::now()->toTimeString();
        $done_on = date('Y-m-d');
        $response = "Money Sent!\n\n";
        $response .= "You sent ".$transaction->transaction_amount." to $transaction->transanction_to_user_number on $done_on at $done_at. ";
        $response .= "Cost ".$transaction->transaction_cost." New Balance: ".$transaction->sender()->balance." Ref: $transaction->transaction_reference_internal";
        return $response;
    }
    public function payBillMessage($transaction)
    {

        $receiver = $transaction->receiver();
        $done_at = Carbon::now()->toTimeString();
        $done_on = date('Y-m-d');
        $message = "Bill Paid!\n\n";
        $message .= "".$transaction->transaction_amount." To $receiver->business_name BizNo $receiver->business_no AcctNo $transaction->transaction_account_number By: $transaction->transaction_from_user_number";
        $message .= "Cost ".$transaction->transaction_cost." Balance ".$transaction->sender()->balance." on $done_on at $done_at Ref: $transaction->transaction_reference_internal"; //
        return $message;
    }
    public function airtimeSentMessage($transaction)
    {
        // mesaage sender
        $done_at = Carbon::now()->toTimeString();
        $done_on = date('Y-m-d');
        $response = "Airtime Sent!\n\n";
        $response .= "You sent ".$transaction->transaction_amount." airtime to $transaction->transaction_account_number on $done_on at $done_at. ";
        $response .= "Cost ".$transaction->transaction_cost." Balance: ".$transaction->sender()->balance." Ref: $transaction->transaction_reference_internal";
        return $response;
    }
    public function withdrawalMessage($transaction)
    {
        // mesaage sender
        $done_at = Carbon::now()->toTimeString();
        $done_on = date('Y-m-d');
        $response = "Withdrawal!\n\n";
        $response .= "You withdrew ".$transaction->transaction_amount."from $transaction->transaction_account_number on $done_on at $done_at. ";
        $response .= "Cost ".$transaction->transaction_cost." Balance: ".$transaction->sender()->balance." Ref: $transaction->transaction_reference_internal";
        return $response;
    }

}
