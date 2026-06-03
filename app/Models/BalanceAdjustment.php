<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BalanceAdjustment extends Model
{
    protected $table = 'balance_adjustments';
    protected $fillable = [
        'user_id',
        'admin_id',
        'amount',
        'type',
        'reason',
        'notes',
        'balance_before',
        'balance_after',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}
