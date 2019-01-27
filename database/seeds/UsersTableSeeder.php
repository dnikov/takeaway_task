<?php

use Illuminate\Database\Seeder;
use \Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $user = new App\User();
        $user->name = 'Takeaway';
        $user->password = Hash::make('1234qwer');
        $user->email = 'takeaway@example.com';
        $user->save();
    }
}
