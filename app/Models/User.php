<?php

namespace App\Models;

use PHPFramework\Model;

class User extends Model
{

    protected array $fillable = ['name', 'email', 'password', 'repassword'];

    protected array $rules = [
        'name' => ['required' => true, 'min' => 2, 'max' => 100],
        'email' => ['email' => true, 'max' => 100, 'unique' => 'users:email'],
        'password' => ['min' => 6, 'max' => 100],
        'repassword' => ['match' => 'password'],
    ];
    protected array $labels = [
        'name' => 'Name',
        'email' => 'Email',
        'password' => 'Password',
        'repassword' => 'Confirm Password',
    ];


    protected static function tableName(): string
    {
        return 'users';
    }


    public function hashPassword(): void
    {
        $this->attributes['password'] = password_hash($this->attributes['password'], PASSWORD_DEFAULT);
        unset($this->attributes['repassword']);
    }

    public function auth(): bool
    {
        $user = db()->query("SELECT * FROM {$this->table} WHERE email =?", [$this->attributes['email']])->getOne();
        if (!$user) {
            return false;
        }
        $is_password_verify = !password_verify($this->attributes['password'], $user['password']);
        if ($is_password_verify) {
            return false;
        }
        //        вариант с паролем, сессия на сервере, но лучше без пароля
        //        session()->set('user',$user);
        $this->setAuthInSession($user);
        return true;

    }

    /**
     * @param array $user
     * @return void
     */
    public function setAuthInSession(array $user): void
    {
        $user_data = [];
        foreach ($user as $k => $v) {
            if ($k == "password") {
                continue;
            }
            $user_data[$k] = $v;
        }
        session()->set('user', $user_data);
    }

}