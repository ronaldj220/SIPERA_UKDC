<?php

namespace App\Models\Admin;

use App\Models\Recruitmen;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;


class Surat_Penerimaan extends Model
{
    use HasFactory;
    use Sortable;
    protected $table = 'surat_penerimaan';
    protected $fillable = [
        'no_doku',
        'tgl_pengajuan',
        'rekrutmen_id',
        'id_posisi_lamaran',
        'tgl_kirim',
        'jumlah_kirim',
        'tgl_kerja',
        'status_penerimaan',
        'status_approval'
    ];
    public function rekrutmen()
    {
        return $this->belongsTo(Recruitmen::class);
    }
    
    public function posisiLamaran()
    {
        return $this->belongsTo(PosisiLamaran::class, 'id_posisi_lamaran');
    }
    
    public function departemen()
    {
        return $this->hasOneThrough(
            Departemen::class,
            Recruitmen::class,
            'id', // Foreign key on the Recruitmen table
            'id', // Foreign key on the Departemen table
            'rekrutmen_id', // Local key on the Surat_Penerimaan table
            'id_departemen' // Local key on the Recruitmen table
        );
    }
    
    public $sortable = [
        'no_doku',
    ];

}
