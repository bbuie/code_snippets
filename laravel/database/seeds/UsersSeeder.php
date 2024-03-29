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

        $testUser = [
            'email' => 'testApp@buink.biz',
            'password' => bcrypt('buinkinc'),
            'name' => 'Test User',
        ];

        $testAdminUser = [
            'email' => 'testAdmin@buink.biz',
            'password' => 'buinkinc',
            'name' => 'Test Admin User',
        ];

        User::create($testUser);
        User::create($testAdminUser);
    }
}
