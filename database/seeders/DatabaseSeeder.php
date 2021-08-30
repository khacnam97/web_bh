<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        //user admin , role admin
        $user =  User::create([
            'username' => 'admin',
            'password' => \Hash::make('admin'),
        ]);
        $role = Role::findByName('admin');

        $user->assignRole([$role->id]);
        //user distribution center , role distribution center
        $userDis =  User::create([
            'username' => 'distributionCenter',
            'password' => \Hash::make('123456'),
        ]);
        $roleDis = Role::findByName('distribution center');

        $userDis->assignRole([$roleDis->id]);
    }
}
