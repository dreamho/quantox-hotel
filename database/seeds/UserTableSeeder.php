<?php

use Illuminate\Database\Seeder;
use App\Model\User;
use App\Model\Role;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_guest = Role::where('name', 'guest')->first();
        $role_dj = Role::where('name', 'dj')->first();
        $role_admin = Role::where('name', 'admin')->first();


        $user = new User();
        $user->name = 'Peter Parker';
        $user->email = 'peterp@mail.com';
        $user->password = bcrypt('peter123');
        $user->save();
        $user->roles()->attach($role_guest);

        $user = new User();
        $user->name = 'Emily Warfield';
        $user->email = 'emilyw@mail.com';
        $user->password = bcrypt('emily123');
        $user->save();
        $user->roles()->attach($role_dj);

        $user = new User();
        $user->name = 'Milos Mosic';
        $user->email = 'milos.mosic@quantox.com';
        $user->password = bcrypt('milos123');
        $user->save();
        $user->roles()->attach($role_admin);
    }
}
