<?php

use app\models\RegistrationForm;
use app\tests\fixtures\UserFixture;

class RegistrationFormTest extends \Codeception\Test\Unit
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
        $this->registrationForm = new RegistrationForm();

        $this->specify("login is required", function() {
            $this->registrationForm->login = null;
            $validationResult = $this->registrationForm->validate(['login']);
            $this->assertFalse($validationResult, 'Expected: false but got: ' . boolval($validationResult));
        });

        $this->specify("password is required", function() {
            $this->registrationForm->password = null;
            $validationResult = $this->registrationForm->validate(['password']);
            $this->assertFalse($validationResult, 'Expected: false but got: ' . boolval($validationResult));
        });

        $this->specify("login is too long", function() {
            $this->registrationForm->login = 'toooooo long loooogin';
            $validationResult = $this->registrationForm->validate(['login']);
            $this->assertFalse($validationResult, 'Expected: false but got: ' . boolval($validationResult));
        });

        $this->specify("login is ok", function() {
            $this->registrationForm->login = 'SomeLogin123';
            $validationResult = $this->registrationForm->validate(['login']);
            $this->assertTrue($validationResult, 'Expected: true but got: ' . boolval($validationResult));
        });

        $this->specify("confirmPassword shoude be equal password", function() {
            $this->registrationForm->password = 'root';
            $this->registrationForm->confirmPassword = 'root123';
            $validationResult = $this->registrationForm->validate(['confirmPassword']);
            $this->assertFalse($validationResult, 'Expected: false but got: ' . boolval($validationResult));
        });
    }

    public function testCheckLogin()
    {
        $registrationForm = new RegistrationForm();

        $existingLogin = $this->tester->grabFixture('users')['user1']['login'];

        $registrationForm->login = $existingLogin;

        $validationResult = $registrationForm->validate(['login']);
        $this->assertFalse($validationResult, 'Expected: false but got: ' . boolval($validationResult));
    }
}