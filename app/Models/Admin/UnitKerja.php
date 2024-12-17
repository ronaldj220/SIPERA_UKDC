<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class UnitKerja extends Model
{
    use HasFactory;
    use Sortable;
    
    protected $table='unit_kerja';
    
    protected $fillable  = [
        'nama_unit_kerja',    
        'kode_unit',    
        'id_departemen',    
    ];
    
    // Relasi Many-to-One dengan Departemen
    public function departemen()
    {
        return $this->belongsTo(Departemen::class);
    }
    public $sortable = ['nama_unit_kerja', 'kode_unit'];
}
