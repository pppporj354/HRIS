<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    use HasFactory;

    protected $table = 'notifikasi';
    protected $primaryKey = 'id_notifikasi';

    protected $fillable = [
        'pesan',
        'jam',
        'tanggal',
        'user_id',
        'status_notifikasi',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
