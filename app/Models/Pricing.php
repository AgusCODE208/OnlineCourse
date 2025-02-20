<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Transaction;


class Pricing extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name',
        'duration',
        'price'
    ];

    public function transaction(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function isSubscription($userId)
    {
        return $this->transaction()
            ->where('user_id', $userId)
            ->where('is_paid', true)
            ->where('ended_at', ">=", now())
            ->exists();
    }
}
