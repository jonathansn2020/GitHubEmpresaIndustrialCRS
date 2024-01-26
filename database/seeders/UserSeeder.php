<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name'      => 'Administrador',
            'email'     => 'admin@gmail.com',
            'password'  => bcrypt('123456789'),
            'profile_photo_path'  => 'storage/users/admin.png'
        ]);

        $user->assignRole('Administrador');

        $user = User::create([
            'name'      => 'Abel Valenzuela Zabarburu',
            'email'     => 'abel_valenzuela@gmail.com',
            'password'  => bcrypt('123456789')
        ]);

        $user->assignRole('Administrador');

        $user = User::create([
            'name'      => 'Jonathan Kevin Sandoval Nuñez',
            'email'     => 'jonakevin2018@gmail.com',
            'password'  => bcrypt('123456789'),
            'profile_photo_path'  => 'storage/users/sandoval.jpg'
        ]);

        $user->assignRole('Administrador');

        $user = User::create([
            'name'      => 'Doris Gamarra Huamantalla',
            'email'     => 'luzidori.19@gmail.com',
            'password'  => bcrypt('123456789'),
            'profile_photo_path'  => 'storage/users/gamarra.jpg'
        ]);

        $user->assignRole('Administrador');

        $user = User::create([
            'name'      => 'Asistente',
            'email'     => 'asistente@gmail.com',
            'password'  => bcrypt('123456789')
        ]);

        $user->assignRole('Asistente');

        $user = User::create([
            'name'      => 'Gino Octavio Peña Lucero',
            'email'     => 'gino_peña@gmail.com',
            'password'  => bcrypt('123456789')
        ]);

        $user->assignRole('Asistente');

        $user = User::create([
            'name'      => 'Industrias del Shanusi S.A.',
            'email'     => 'aportalesr@palmas.com.pe',
            'password'  => bcrypt('123456789')
        ]);

        $user->assignRole('Cliente');

        $user = User::create([
            'name'      => 'Arnao Services S.A.C',
            'email'     => 'arnao_s@gmail.com',
            'password'  => bcrypt('123456789')
        ]);

        $user->assignRole('Cliente');

        $user = User::create([
            'name'      => 'Pieriplast',
            'email'     => 'pieriplast@gmail.com',
            'password'  => bcrypt('123456789')
        ]);

        $user->assignRole('Cliente');
    }
}
