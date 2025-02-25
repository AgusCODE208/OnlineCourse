<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Services\TransactionService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $transactionService;

    public function __construct(
        TransactionService $transactionService
    ) {
        $this->transactionService = $transactionService;
    }

    public function subscriptions()
    {
        $transaction = $this->transactionService->getUserTransaction();
        return view('front.berlangganan', compact('transaction'));
    }

    public function subscriptions_details(Transaction $transaction)
    {
        return view('front.subscriptions_details', compact('transaction'));
    }
}
