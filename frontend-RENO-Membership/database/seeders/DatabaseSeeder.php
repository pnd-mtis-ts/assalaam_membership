<?php

namespace Database\Seeders;

use App\Models\CardMember;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder {
    /**
     * Seed the application's database.
     */
    public function run(): void {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call([
            UserSeeder::class
        ]);

        CardMember::create([
            'nama' => 'tes',
            'no_member' => '0986576542',
            'tempat_lahir' => 'solo',
            'tanggal_lahir' => '11/06/2000',
            'no_identitas' => '626245462721',
            'jenis_kelamin' => 'laki-laki',
            'alamat' => 'palur',
            "rt_rw" => '1/17',
            "kelurahan" => 'palur',
            "kecamatan" => 'mojolaban',
            "kota" => 'sukoharjo',
            "kode_pos" => '57554',
            "no_hp" => '089666750860',
            "status" => 'lajang',
            "jumlah_tanggungan" => '1',
            "pendapatan" => '15000000',
            "npwp" => '6756744784533',
            "kewarganegaraan" => 'wni',
            "agama" => 'islam',
            "validation" => '1',
            "member_profile" => 'NULL',
            "user_id" => 2
        ]);
    }
}