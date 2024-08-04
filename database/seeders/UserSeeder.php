<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    private $permissions = [

        //Stok Barang
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
            'is_admin' => true,
        ], $default_user_value));
        
        $role = Role::create([
            'name' => 'admin',
            'guard_name' => 'web'
        ]);

        $role->syncPermissions($this->permissions);
        $admin->assignRole([$role->id]);

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
            'is_foto' => true,
        ], $default_user_value));

        $foto->assignRole('foto');

        $user = User::create(array_merge([
            'name' => 'User',
            'email' => 'user@gmail.com',
            'is_user' => true,
        ], $default_user_value));

        $user->assignRole('user');
       
    }
}
