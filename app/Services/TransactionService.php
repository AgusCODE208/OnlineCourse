<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use App\Models\Pricing;
use App\Models\Transaction;
use App\Repositories\PricingRepositoryInterface;
use App\Repositories\TransactionRepositoryInterface;

class TransactionService
{
    protected $pricingRepository;
    protected $transactionRepository;

    public function __construct(
        PricingRepositoryInterface $pricingRepository,
        TransactionRepositoryInterface $transactionRepository
    ) {
        $this->pricingRepository = $pricingRepository;
        $this->transactionRepository = $transactionRepository;
    }
    public function prepareCheckOut(Pricing $pricing)
    {
        $user = Auth::user();
        $alreadySubscribed = $pricing->isSubscribedByUser($user->id);

        $tax = 0.11;
        $total_tax_amount = $pricing->price * $tax;
        $sub_total_amount = $pricing->price;
        $grant_total_amount = $sub_total_amount + $total_tax_amount;

        $started_at = now();
        $ended_at = $started_at->copy()->addMonths($pricing->duration);

        session()->put('pricing_id', $pricing->id);

        return compact(
            'total_tax_amount',
            'grant_total_amount',
            'sub_total_amount',
            'pricing',
            'user',
            'alreadySubscribed',
            'started_at',
            'ended_at'
        );
    }

    public function getRecentPricing()
    {
        $pricingId = session()->get('pricing_id');
        // return Pricing::find($pricingId);
        return $this->pricingRepository->findByID($pricingId);
    }

    public function getUserTransaction()
    {
        $user = Auth::user();

        return $this->transactionRepository->getUserTransactions($user->id);

        // return Transaction::with('pricing')
        //     ->where('user_id', $user->id)
        //     ->orderBy('created_at', 'desc')
        //     ->get();
    }
}
