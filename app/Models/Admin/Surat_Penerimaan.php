<?php

namespace App\Models\Admin;

use App\Models\Recruitmen;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Surat_Penerimaan extends Model
{
    use HasFactory;
    protected $table = 'surat_penerimaan';
    protected $fillable = [
        'no_doku',
        'tgl_pengajuan',
        'rekrutmen_id',
        'psikotes_id',
        'tempat_lahir',
        'tgl_lahir',
        'alamat',
        'tgl_kerja',
        'status_penerimaan',
        'status_approval'
    ];
    public function rekrutmen()
    {
        return $this->belongsTo(Recruitmen::class);
    }
}
