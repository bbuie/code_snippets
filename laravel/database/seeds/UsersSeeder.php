<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        User::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $admin = [
            'email' => 'testUserGirona@buink.biz',
            'password' => bcrypt('girona'),
            'name' => 'Test User',
        ];

        User::create($admin);
    }
}
