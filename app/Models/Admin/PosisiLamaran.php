<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;


class PosisiLamaran extends Model
{
    use HasFactory;
    use Sortable;
    protected $table='posisi_lamaran';
    
    protected $fillable = [
        'posisi',
        'unit_kerja',
        'status_pegawai',
        'masa_percobaan_awal',
        'masa_percobaan_akhir',
        'lama_masa_percobaan'
    ];
    
    public function suratPenerimaan()
    {
        return $this->hasMany(Surat_Penerimaan::class, 'id_posisi_lamaran');
    }
    
    public $sortable = [
        'posisi',
        'lama_masa_percobaan'
    ];

}
