<?php

use app\tests\fixtures\UserFixture;

class AuthControllerTest extends \Codeception\Test\Unit
{
    /**
     * @var \FunctionalTester
     */
    protected $tester;

    public function _fixtures()
    {
        return [
            'users' => [
                'class' => UserFixture::class,
                'dataFile' => codecept_data_dir() . 'user.php'
            ]
        ];
    }

    protected function _before()
    {

    }

    protected function _after()
    {
    }

    private function loginInSystem($login, $password)
    {
        $this->tester->amOnPage(['auth/login']);
        $this->tester->see('Login', 'h1');

        $this->tester->fillField('Login', $login);
        $this->tester->fillField('Password', $password);
        $this->tester->click('Sign in');
    }

    public function testLogin()
    {
        $this->loginInSystem('root', 'root');
        $this->tester->see('Log out', 'a');
    }

    public function testWrongLogin()
    {
        $this->loginInSystem('root123', 'root');
        $this->tester->see('Wrong email or password');
        $this->tester->see('Login', 'h1');
    }

    public function testWrongPassword()
    {
        $this->loginInSystem('root', 'root123');
        $this->tester->see('Wrong email or password');
        $this->tester->see('Login', 'h1');
    }

    public function testLogout()
    {
        $this->loginInSystem('root', 'root');
        $this->tester->click('Log out');
        $this->tester->see('Login', 'h1');
        $this->tester->amOnPage(['gallery/index']);
        $this->tester->see('Login', 'h1');
    }

    public function testRegistration()
    {
        $this->tester->amOnPage(['auth/registration']);
        $this->tester->see('Registration', 'h1');

        $this->tester->fillField('Login', 'root1');
        $this->tester->fillField('Password', 'root');
        $this->tester->fillField('Confirm Password', 'root');
        $this->tester->click('Sign up');
        $this->tester->see('Login', 'h1');

        $this->loginInSystem('root1', 'root');
        $this->tester->see('Log out', 'a');
    }

    public function testRegistrationWhenUserAlreadyExists()
    {
        $this->tester->amOnPage(['auth/registration']);
        $this->tester->see('Registration', 'h1');

        $this->tester->fillField('Login', 'root');
        $this->tester->fillField('Password', 'root');
        $this->tester->fillField('Confirm Password', 'root');
        $this->tester->click('Sign up');
        $this->tester->see('Login "root" already exists');
    }
}