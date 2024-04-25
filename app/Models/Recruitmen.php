<?php

namespace App\Models;

use App\Models\Admin\Departemen;
use App\Models\Admin\Psikotes;
use App\Models\Admin\Surat_Penerimaan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recruitmen extends Model
{
    use HasFactory;
    protected $table = 'recruitmen';
    protected $fillable = [
        'no_doku',
        'tgl_pengajuan',
        'id_user',
        'id_departemen',
        'jam_hadir',
        'jam_selesai',
        'kegaiatan',
        'jabatan_pelamar',
        'CV',
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
    public function users()
    {
        return $this->hasOne(User::class, 'id_user');
    }
    public function departemen()
    {
        return $this->hasMany(Departemen::class, 'id_departemen');
    }
}
