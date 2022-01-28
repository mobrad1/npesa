<?php


namespace App\Enums;


class TransactionCategories extends BaseEnum
{
    const SEND_MONEY = "Send Money";
    const AIRTIME = "Airtime";
    const PAY_BILLS ="Pay Bills";
    const SAVINGS = "Savings";
    const LOANS = "Loans";
    const WITHDRAWALS = "Withdrawals";
    const DEPOSITS = "Deposits";
    const BANK_TRANSFERS = "Bank Transfers";
    const MICROFINANCE_TRANSFERS = "Microfinance Transfers";
    const MOMO_TRANSFERS = "Momo Transfers";
}
