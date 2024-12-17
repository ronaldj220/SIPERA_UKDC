<?php

namespace App\Models\Admin;

use App\Models\Recruitmen;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Psikotes extends Model
{
    use HasFactory;
    use Sortable;
    protected $table = 'psikotes';
    protected $fillable = [
        'no_doku_psikotes',
        'no_doku_rektor',
        'id_rekrutmen',
        'lokasi_psikotes_id',
        'tgl_pengajuan',
        'tgl_kirim',
        'jumlah_kirim',
        'tgl_hadir',
        'jam_hadir',
        'link_psikotes',
        'status_approval',
    ];
    public function rekrutmen()
    {
        return $this->belongsTo(Recruitmen::class, 'id_rekrutmen');
    }
    
    public function lokasiPsikotes()
    {
        return $this->belongsTo(LokasiPsikotes::class, 'lokasi_psikotes_id');
    }
    
    public $sortable = [
        'no_doku_psikotes',
        'status_approval',
        'tgl_kirim'
    ];
}
