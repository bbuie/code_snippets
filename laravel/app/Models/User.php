<?php

namespace App\Models;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $guarded = [
        'email',
        'password',
        'remember_token',
        'created_at',
        'updated_at'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $appends = [
        'current_account',
        'current_account_user'
    ];

    protected $currentAccount;
    protected $currentAccountUser;

    public function accounts(){
        return $this->belongsToMany('App\Models\Account');
    }

    public function accountUsers(){
        return $this->hasMany('App\Models\AccountUser');
    }

    public function getCurrentAccountAttribute(){
        $user = $this;
        if (empty($user->currentAccount)) {
            $request = request() ?? null;
            $accountId = (int)$request->header('current-account-id') ?? null;

            $user->setCurrentAccount($accountId);
        }

        return $user->currentAccount;
    }

    public function getCurrentAccountUserAttribute()
    {
        $user = $this;
        if (empty($user->currentAccountUser)) {
            $request = request() ?? null;
            $accountId = (int)$request->header('current-account-id') ?? null;

            $user->setCurrentAccount($accountId);
        }
        return $user->currentAccountUser;
    }

    public function setPasswordAttribute($password)
    {
        $user = $this;
        $user->attributes['password'] = bcrypt($password);
    }

    public static function mergeOrCreate($payload)
    {

        if (isset($payload['id'])) {
            $user = User::findOrFail($payload['id']);
        } else {
            $user = new User;
        }

        $user->name = $payload['name'];

        return $user;
    }

    public function setCurrentAccount($accountId)
    {
        $user = $this;
        $userAccountHasChanged = empty($user->currentAccount) ||
            empty($user->currentAccountUser) ||
            $user->current_account->id !== $accountId ||
            $user->current_account_user->account_id !== $accountId;

        if ($userAccountHasChanged) {
            if ($accountId) {
                $user->currentAccount = $user->accounts()->findOrFail($accountId);
                $user->currentAccountUser = $user->accountUsers()->where('account_id', $accountId)->firstOrFail();
            } else {
                $user->currentAccount = $user->accounts()->first();
                $user->currentAccountUser = $user->currentAccount ? $user->accountUsers()->where('account_id', $user->currentAccount->id)->firstOrFail() : $user->accountUsers()->first();
            }
        }

        return $user;
    }

    public function changeEmail($payload)
    {
        $user = $this;

        if ($user->isCurrentPassword($payload['current_password'])) {
            $user->email = $payload['email'] ;
        } else {
            throw new \Exception("Permission denied.");
        }
    }

    public function changePassword($payload)
    {
        $user = $this;

        if ($user->isCurrentPassword($payload['current_password'])) {
            $user->password = $payload['password'];
        } else {
            throw new \Exception("Permission denied.");
        }
    }

    public function isCurrentPassword($password)
    {
        $user = $this;

        return password_verify($password, $user->password);
    }

}
