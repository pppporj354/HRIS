<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{

    protected $guarded = [];
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('users')->insert([[
            'username' => 'administrator_master',
            'email' => 'admin@indoglobalimpex.com',
            'email_verified_at' => now(),
            'password' => bcrypt('admin@igi'),
            'role' => 'Administrator',
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ], [
            'username' => 'employee_example',
            'email' => 'employee@indoglobalimpex.com',
            'email_verified_at' => now(),
            'password' => bcrypt('employee@igi'),
            'role' => 'Employee',
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]]);

        // Get the inserted users
        $adminUser = DB::table('users')->where('username', 'administrator_master')->first();
        $employeeUser = DB::table('users')->where('username', 'employee_example')->first();

        DB::table('data_karyawan')->insert([[
            'nama' => 'administrator_master',
            'alamat' => 'Jl. Ketintang no.156',
            'nomor_telepon' => '081345642135',
            'status_karyawan' => 'Karyawan Tetap',
            'keahlian' => 'Human Resource',
            'jabatan' => 'Human Resource',
            'rekrutmen_id' => null,
            'user_id' => $adminUser->id_user, // Assign the corresponding user_id
            'created_at' => now(),
            'updated_at' => now(),
        ], [
            'nama' => 'employee_example',
            'alamat' => 'Jl. Ketintang no.156',
            'nomor_telepon' => '081323553176',
            'status_karyawan' => 'Karyawan Tetap',
            'keahlian' => 'Web Programming, Desktop Programming, Mobile Programming',
            'jabatan' => 'Software Developer',
            'rekrutmen_id' => null,
            'user_id' => $employeeUser->id_user, // Assign the corresponding user_id
            'created_at' => now(),
            'updated_at' => now(),
        ]]);
    }
}
