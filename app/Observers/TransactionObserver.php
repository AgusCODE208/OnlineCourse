<?php

namespace App\Observers;

use App\Helpers\TransactionHelper;
use App\Models\Transaction;

class TransactionObserver
{
    public function creating(Transaction $transaction): void
    {
        $transaction->booking_trx_id = TransactionHelper::generateUniqueTrxId();
    }
    public function created(Transaction $transaction): void
    {
        //
    }
    public function update(Transaction $transaction): void
    {
        //
    }
    public function delete(Transaction $transaction): void
    {
        //
    }

    public function restored(Transaction $transaction): void
    {
        //
    }
}
