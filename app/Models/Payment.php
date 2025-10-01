<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        "subscription_id",
        "payment_id_mercadopago",
        "amount",
        "status",
        "paid_at",
    ];
    protected $casts = [
        "paid_at" => "datetime",
    ];

    public function plan()
    {
        // atalho: pega direto o plano pela assinatura
        return $this->subscription?->plan;
    }
    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }
}
