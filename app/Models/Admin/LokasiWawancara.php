<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Recruitmen;
use Kyslik\ColumnSortable\Sortable;



class LokasiWawancara extends Model
{
    use HasFactory;
    use Sortable;
    protected $table = 'lokasi_wawancara';
    
    protected $fillable = [
        'ruangan',    
        'lokasi',    
    ];
    
    public function recruitmen()
    {
        return $this->hasMany(Recruitmen::class, 'id_lokasi_wawancara');
    }
    
    public $sortable = ['ruangan', 'lokasi'];
}
