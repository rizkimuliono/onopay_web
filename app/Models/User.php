<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'onopay_users';

    protected $fillable = [
        'phone_number',
        'name',
        'email',
        'balance',
        'status',
        'pin',
    ];

    protected $hidden = [
        'pin',
    ];

    protected $casts = [
        'balance' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function qrcodes()
    {
        return $this->hasMany(QRCode::class);
    }
}
