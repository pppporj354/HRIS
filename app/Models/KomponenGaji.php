<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KomponenGaji extends Model
{
    use HasFactory;
    protected $table = 'komponen_gaji';
    protected $primaryKey = 'id_komponen_gaji';

    public function dataKaryawan()
    {
        return $this->belongsTo(DataKaryawan::class, 'data_karyawan_id');
    }
}
