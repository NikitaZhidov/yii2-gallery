<?php

namespace app\controllers;

use app\models\LoginForm;
use app\models\RegistrationForm;
use app\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

class AuthController extends Controller {

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['login', 'logout', 'registration'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['login', 'registration'],
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['logout'],
                        'roles' => ['@'],
                    ],
                ],
                'denyCallback' => function ($rule, $action) {
                    return $this->redirect(['gallery/index']);
                }
            ],
        ];
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $loginForm = new LoginForm();

        if (Yii::$app->request->post('LoginForm')) {
            $loginForm->attributes = Yii::$app->request->post('LoginForm');

            if ($loginForm->validate()) {
                $user = $loginForm->getUser();
                Yii::$app->user->login($user);
                return $this->redirect(['gallery/index']);
            }
        }

        return $this->render('login', [
            'loginForm' => $loginForm
        ]);
    }


    public function actionLogout()
    {
        if (!Yii::$app->user->isGuest) {
            Yii::$app->user->logout();
        }

        $this->redirect(['auth/login']);
    }

    public function actionRegistration()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->redirect(['auth/login']);
        }

        $registrationForm = new RegistrationForm();


        if (Yii::$app->request->post('RegistrationForm')) {
            $registrationForm->attributes = Yii::$app->request->post('RegistrationForm');

            if ($registrationForm->validate()) {
                $user = new User();
                $user->login = $registrationForm->login;
                $user->password = sha1($registrationForm->password);

                try {
                    $user->save();
                } catch(\Exception $e) {
                    return $this->render('error', [
                        'error_message' => 'Registration error, try again later'
                    ]);
                }

                return $this->redirect(['auth/login']);
            }
        }

        return $this->render('registration', [
            'registrationForm' => $registrationForm
        ]);
    }
}