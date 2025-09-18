<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;
    protected $table = 'absensi';
    protected $primaryKey = 'id_absensi';

    public function dataKaryawan()
    {
        return $this->belongsTo(DataKaryawan::class, 'data_karyawan_id');
    }
}
