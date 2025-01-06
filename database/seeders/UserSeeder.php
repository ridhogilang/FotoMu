<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Fotografer;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    private $permissions = [
        'update-user'
    ];

    public function run(): void
    {
        $default_user_value = [
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'remember_token' => Str::random(10),
        ];

        foreach ($this->permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        $admin = User::create(array_merge([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'nowa' => '08123456789',
            'is_admin' => true,
        ], $default_user_value));

        $role = Role::create([
            'name' => 'admin',
            'guard_name' => 'web'
        ]);

        $role->syncPermissions($this->permissions);
        $admin->assignRole([$role->id]);

        Fotografer::create([
            'user_id' => $admin->id,
            'nama' => 'Nama Fotografer',
            'alamat' => 'Alamat Fotografer',
            'nowa' => '08123456789',
            'foto_ktp' => 'path/to/ktp.jpg',
        ]);

        Role::create([
            'name' => 'foto',
            'guard_name' => 'web'
        ]);

        Role::create([
            'name' => 'user',
            'guard_name' => 'web'
        ]);

        $foto = User::create(array_merge([
            'name' => 'Fotografer',
            'email' => 'fotografer@gmail.com',
            'nowa' => '08123456789',
            'is_foto' => true,
        ], $default_user_value));

        $foto->assignRole('foto');

        $user = User::create(array_merge([
            'name' => 'User',
            'email' => 'user@gmail.com',
            'nowa' => '08123456789',
            'is_user' => true,
        ], $default_user_value));

        $user->assignRole('user');

        $users = [
            ['name' => 'Ridho', 'email' => 'ridho@gmail.com', 'nowa' => '08123456781', 'is_user' => true, 'foto_depan' => 'foto_user/ridho.jpg'],
            ['name' => 'Fathur', 'email' => 'fathur@gmail.com', 'nowa' => '08123456782', 'is_user' => true, 'foto_depan' => 'foto_user/fathur.jpg'],
            ['name' => 'Restu', 'email' => 'restu@gmail.com', 'nowa' => '08123456783', 'is_user' => true, 'foto_depan' => 'foto_user/restu.jpg'],
            ['name' => 'Bagus', 'email' => 'bagus@gmail.com', 'nowa' => '08123456784', 'is_user' => true, 'foto_depan' => 'foto_user/bagus.jpg'],
            ['name' => 'Seto', 'email' => 'seto@gmail.com', 'nowa' => '08123456785', 'is_user' => true, 'foto_depan' => 'foto_user/seto.jpg'],
            ['name' => 'Viki', 'email' => 'viki@gmail.com', 'nowa' => '08123456786', 'is_user' => true, 'foto_depan' => 'foto_user/viki.jpg'],
            ['name' => 'Adi', 'email' => 'adi@gmail.com', 'nowa' => '08123456787', 'is_user' => true, 'foto_depan' => 'foto_user/adi.jpg'],
            ['name' => 'Yanu', 'email' => 'yanu@gmail.com', 'nowa' => '08123456788', 'is_user' => true, 'foto_depan' => 'foto_user/yanu.jpg'],
            ['name' => 'Yosi', 'email' => 'yosi@gmail.com', 'nowa' => '08123456789', 'is_user' => true, 'foto_depan' => 'foto_user/yosi.jpg'],
            ['name' => 'Moko', 'email' => 'moko@gmail.com', 'nowa' => '08123456780', 'is_user' => true, 'foto_depan' => 'foto_user/moko.jpg'],
            ['name' => 'Regina', 'email' => 'regina@gmail.com', 'nowa' => '08123456790', 'is_user' => true, 'foto_depan' => 'foto_user/regina.jpg'],
        ];       

        foreach ($users as $user_data) {
            $user = User::create(array_merge($user_data, $default_user_value));
            $user->assignRole('user');
        }
    }
}
