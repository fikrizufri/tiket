<?php

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $superadmin = new Role();
        $superadmin->nama = 'Superadmin';
        $superadmin->slug = 'superadmin';
        $superadmin->save();

        $adminRole = new Role();
        $adminRole->nama = 'Admin';
        $adminRole->slug = 'admin';
        $adminRole->save();

        $superadmin = Role::where('slug', 'superadmin')->first();
        $adminRole = Role::where('slug', 'admin')->first();

        $superadminUser = new User();
        $superadminUser->nama = 'Superadmin';
        $superadminUser->username = 'superadmin';
        $superadminUser->slug = Str::slug('Superadmin');
        $superadminUser->email = 'superadmin@admin.com';
        $superadminUser->password = bcrypt('secret');
        $superadminUser->telp = '017397137';
        // $superadminUser->icon = 'default-icon.png';
        $superadminUser->save();

        $superadminUser->role()->attach($superadmin);
    }
}
