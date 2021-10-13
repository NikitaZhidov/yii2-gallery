<?php

namespace app\models;

use yii\base\Model;

class LoginForm extends Model
{
    public $login;
    public $password;

    public function rules()
    {
        return [
            [['login', 'password'], 'required'],
            [['password', 'login'], 'string', 'min' => 2, 'max' => 16],
            ['login', 'filter', 'filter' => 'strtolower'],
            ['password', 'validatePassword']
        ];
    }

    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Wrong email or password');
            }
        }
    }

    public function getUser()
    {
        return User::findOne(['login' => $this->login]);
    }
}