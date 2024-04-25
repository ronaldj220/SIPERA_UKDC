<?php

namespace App\Models\Admin;

use App\Models\Recruitmen;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departemen extends Model
{
    use HasFactory;
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
}
