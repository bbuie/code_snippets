<?php

use Illuminate\Database\Seeder;
use App\Models\Account;
use App\Models\User;
use App\Models\AccountUser;

class AccountsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Account::truncate();
        AccountUser::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $user = User::where('email', "testApp@buink.biz")->get()->first();

        $account = new Account;
        $user->accounts()->save($account);
    }
}
