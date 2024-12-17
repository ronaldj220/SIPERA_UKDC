<?php

namespace App\Models\Admin;

use App\Models\Recruitmen;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;


class Departemen extends Model
{
    use HasFactory;
    use Sortable;
    protected $table = 'departemen';
    protected $fillable = [
        'departemen',
        'PIC'
    ];
    public $timestamps = true;
    
    public function rekrutmen()
    {
        return $this->belongsTo(Recruitmen::class, 'id_departemen');
    }
    
    // Relation One-to-Many unitKerja
    public function unitKerja(){
        return $this->hasMany(UnitKerja::class, 'id_departemen', 'id_departemen');
    }
    public $sortable = [
        'departemen'
    ];
}
