<?php

namespace App\Models;

use App\Models\Admin\Departemen;
use App\Models\Admin\Psikotes;
use App\Models\Admin\Lowongan;
use App\Models\Admin\LokasiWawancara;
use App\Models\Admin\Surat_Penerimaan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use Carbon\Carbon;


class Recruitmen extends Model
{
    use HasFactory;
    use Sortable;
    protected $table = 'recruitmen';
    protected $fillable = [
        'lowongan_id',
        'no_doku',
        'tgl_pengajuan',
        'tgl_kirim',
        'jumlah_kirim',
        'id_users',
        'alasan_penerimaan',
        'jam_hadir',
        'jam_selesai',
        'kegiatan',
        'jabatan_pelamar',
        'CV_base_64',
        'transkrip_nilai_base_64',
        'kenalan',
        'kenalan_rekrutmen_lainnya',
        'tgl_hadir',
    ];
    protected $casts = [
        'jam_hadir' => 'array',
        'jam_selesai' => 'array',
        'kegiatan' => 'array',
    ];
    public function psikotes()
    {
        return $this->hasOne(Psikotes::class, 'id_rekrutmen');
    }
    public function surat_penerimaan()
    {
        return $this->hasOne(Surat_Penerimaan::class, 'rekrutmen_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'id_users');
    }
    
    // Relasi ke model Lowongan
    public function lowongan()
    {
        return $this->belongsTo(Lowongan::class, 'lowongan_id', 'id');
    }
    public $sortable = [
        'user.nama',
        'no_doku',
        'tgl_pengajuan',
        'tgl_kirim',
    ];
    
    public function getAgeAttribute()
    {
        return Carbon::parse($this->tgl_lahir)->age;
    }
    
    public function lokasiWawancara()
    {
        return $this->belongsTo(LokasiWawancara::class, 'id_lokasi_wawancara');
    }
}
