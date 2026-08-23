<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kandidat extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Relasi: Satu Paslon Memiliki Banyak Suara (Votes)
    public function votes()
    {
        return $this->hasMany(Vote::class, 'kandidat_id');
    }
}
