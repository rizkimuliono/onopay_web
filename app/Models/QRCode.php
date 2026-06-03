<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QRCode extends Model
{
    protected $table = 'qr_codes';

    protected $fillable = [
        'code',
        'merchant_code',
        'user_id',
        'amount',
        'description',
        'qr_mode',
        'qr_data',
        'status',
        'expires_at',
        'qr_image',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'expires_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
