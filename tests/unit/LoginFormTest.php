<?php

use app\models\LoginForm;
use app\tests\fixtures\UserFixture;

class LoginFormTest extends \Codeception\Test\Unit
{

    use \Codeception\Specify;

    /**
     * @var \UnitTester
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

    public function testValidation()
    {
        $this->loginForm = new LoginForm();

        $this->specify("login is required", function() {
            $this->loginForm->login = null;
            $validationResult = $this->loginForm->validate(['login']);
            $this->assertFalse($validationResult, 'Expected: false but got: ' . boolval($validationResult));
        });

        $this->specify("password is required", function() {
            $this->loginForm->password = null;
            $validationResult = $this->loginForm->validate(['password']);
            $this->assertFalse($validationResult, 'Expected: false but got: ' . boolval($validationResult));
        });

        $this->specify("login is too long", function() {
            $this->loginForm->login = 'toooooo long loooogin';
            $validationResult = $this->loginForm->validate(['login']);
            $this->assertFalse($validationResult, 'Expected: false but got: ' . boolval($validationResult));
        });
    }

    public function testCheckCredentials()
    {
        $this->loginForm = new LoginForm();

        $this->specify("Wrong login", function() {
            $this->loginForm->login = 'MockRoot';
            $this->loginForm->password = 'root';
            $validationResult = $this->loginForm->validate(['password']);
            $this->assertFalse($validationResult, 'Expected: false but got: ' . boolval($validationResult));
        });

        $this->specify("Wrong password", function() {
            $this->loginForm->login = 'root';
            $this->loginForm->password = 'MockRoot';
            $validationResult = $this->loginForm->validate(['password']);
            $this->assertFalse($validationResult, 'Expected: false but got: ' . boolval($validationResult));
        });

        $this->specify("Email and password is ok", function() {
            $this->loginForm->login = 'root';
            $this->loginForm->password = 'root';
            $validationResult = $this->loginForm->validate(['password']);
            $this->assertTrue($validationResult, 'Expected: true but got: ' . boolval($validationResult));
        });
    }
}