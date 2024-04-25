<?php

namespace App\Models\Admin;

use App\Models\Recruitmen;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Psikotes extends Model
{
    use HasFactory;
    protected $table = 'psikotes';
    protected $fillable = [
        'no_doku_psikotes',
        'no_doku_rektor',
        'id_rekrutmen',
        'tgl_pengajuan',
        'tgl_hadir',
        'jam_hadir',
        'lokasi_hadir',
        'status_approval',
    ];
    public function rekrutmen()
    {
        return $this->belongsTo(Recruitmen::class, 'id_rekrutmen');
    }
}
