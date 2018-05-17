<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OauthClientsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('oauth_clients')->insert([
            'name' => 'App Front End',
            'secret' => 'v3aFn6P6NpEEd18sLxBU6AHzWwaCgBsG9iRqVEvz',
            'redirect' => 'http://192.168.99.100',
            'personal_access_client' => 0,
            'password_client' => 1,
            'revoked' => 0,
        ]);
    }
}
