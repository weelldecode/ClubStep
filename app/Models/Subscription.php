<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $fillable = [
        "user_id",
        "plan_id",
        "status",
        "started_at",
        "expires_at",
    ];

    protected $casts = [
        "started_at" => "datetime",
        "expires_at" => "datetime",
    ];

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function plan()
    {
        return $this->belongsTo(Plan::class, "plan_id");
    }
}
