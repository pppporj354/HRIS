<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataKaryawan extends Model
{
    use HasFactory;
    protected $table = 'data_karyawan';
    protected $primaryKey = 'id_data_karyawan';
    public function rekrutmen()
    {
        return $this->belongsTo(Rekrutmen::class, 'rekrutmen_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function cuti()
    {
        return $this->hasMany(Cuti::class, 'data_karyawan_id');
    }

    public function absensi()
    {
        return $this->hasMany(Absensi::class, 'data_karyawan_id');
    }

    public function komponenGaji()
    {
        return $this->hasOne(komponenGaji::class, 'data_karyawan_id');
    }

    public function gaji()
    {
        return $this->hasMany(Gaji::class, 'data_karyawan_id');
    }
}
