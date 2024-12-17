<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LokasiPsikotes extends Model
{
    use HasFactory;
    protected $table = 'lokasi_psikotes';
    
    protected $fillable = [
        'lokasi_psikotes',
        'ruangan_psikotes',
        'alamat_psikotes'
    ];
    
     public function psikotes()
    {
        return $this->hasMany(Psikotes::class, 'lokasi_psikotes_id'); // Menentukan relasi
    }
}
