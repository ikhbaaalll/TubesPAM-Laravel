<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create(
            [
                'nama'      => 'Muhammad Ikhbal',
                'email'     => 'ikhbal@ikhbal.com',
                'password'  => bcrypt('123'),
                'role'      => 1,
                'kelas'     => 6
            ]
        );

        User::create(
            [
                'nama'      => 'Fikri Halim',
                'email'     => 'fikri@fikri.com',
                'password'  => bcrypt('123'),
                'role'      => 2,
                'kelas'     => 6
            ]
        );

        User::create(
            [
                'nama'      => 'Annisa Dwi Atika',
                'email'     => 'annisa@annisa.com',
                'password'  => bcrypt('123'),
                'role'      => 2,
                'kelas'     => 6
            ]
        );

        User::create(
            [
                'nama'      => 'Citra Amel',
                'email'     => 'amel@amel.com',
                'password'  => bcrypt('123'),
                'role'      => 2,
                'kelas'     => 5
            ]
        );
    }
}
