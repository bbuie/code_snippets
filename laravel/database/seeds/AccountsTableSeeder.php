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

        $seedAccounts = [
            [
                'user' => User::where('email', "testApp@buink.biz")->get()->first(),
                'status' => 'free_trial'
            ],
        ];

        foreach ($seedAccounts as $seedAccount) {
            $account = new Account;

            $dt = new \DateTime();
            $dt->add(new \DateInterval('P1M'));
            $account->expire_date = $dt;

            $seedAccount['user']->accounts()->save($account);

            if ($seedAccount['user']->email === "testAdmin@buink.biz") {
                $seedAccount['user']->current_account_user->assignRole('super-admin');
            }
        }

    }
}
