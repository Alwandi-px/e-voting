<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    use HasFactory;

    // Tambahkan properti $fillable di bawah ini
    protected $fillable = [
        'user_id',
        'kandidat_id',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Kandidat
    public function kandidat()
    {
        return $this->belongsTo(Kandidat::class);
    }
}
