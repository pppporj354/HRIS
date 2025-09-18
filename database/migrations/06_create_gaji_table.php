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
        Schema::create('gaji', function (Blueprint $table) {
            $table->id('id_gaji');
            $table->integer('gaji_pokok');
            $table->integer('potongan_ketidakhadiran');
            $table->integer('potongan_lain');
            $table->integer('total_potongan');
            $table->integer('total_tunjangan');
            $table->integer('total_gaji');
            $table->text('keterangan')->nullable();
            $table->string('tahun_bulan', 7); // memastikan 7 karakter contoh "yyyy-mm" / "2000-11"
            $table->enum('status_gaji', ['Terbayar', 'Kredit'])->default('Kredit');
            $table->foreignId('data_karyawan_id')->constrained('data_karyawan', 'id_data_karyawan')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gaji');
    }
};
