<?php

namespace app\models;

use yii\base\Model;

class RegistrationForm extends Model
{
    public $login;
    public $password;
    public $confirmPassword;

    public function rules() {
        return [
            [['login', 'password', 'confirmPassword'], 'required'],
            [['password', 'login'], 'string', 'min' => 2, 'max' => 16],
            ['login', 'filter', 'filter' => 'strtolower'],
            ['confirmPassword', 'compare', 'compareAttribute' => 'password', 'message' => "Passwords don't match"],
            ['login', 'checkLogin']
        ];
    }

    public function checkLogin($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = User::findOne(['login' => $this->login]);

            if ($user != NULL) {
                $this->addError($attribute, "Login \"" . $this->login . "\" already exists");
            }
        }
    }
}