<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cuti', function (Blueprint $table) {
            $table->id('id_cuti');
            $table->date('mulai_cuti');
            $table->date('selesai_cuti');
            $table->text('keterangan');
            $table->enum('status_cuti', ['Disetujui', 'Pending', 'Ditolak'])->default('Pending');
            $table->foreignId('data_karyawan_id')->constrained('data_karyawan', 'id_data_karyawan')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cuti');
    }
};
