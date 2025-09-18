<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gaji extends Model
{
    use HasFactory;
    protected $table = 'gaji';
    protected $primaryKey = 'id_gaji';

    public function dataKaryawan()
    {
        return $this->belongsTo(DataKaryawan::class, 'data_karyawan_id');
    }
}
