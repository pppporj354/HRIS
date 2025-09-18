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
        Schema::create('data_karyawan', function (Blueprint $table) {
            $table->id('id_data_karyawan');
            $table->string('nama');
            $table->string('alamat');
            $table->string('nomor_telepon');
            $table->enum('status_karyawan', ['Karyawan Tetap', 'Karyawan Kontrak']);
            $table->string('keahlian');
            $table->string('jabatan');
            $table->foreignId('rekrutmen_id')->nullable()->constrained('rekrutmen', 'id_rekrutmen');
            $table->foreignId('user_id')->constrained('users', 'id_user')->onDelete('cascade');
            // use this $table->foreignId('user_id')->constrained();
            // or use this to constrained to users table with spesific user id name $table->foreignId('user_id')->constrained('users', 'id_user');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_karyawan');
    }
};
