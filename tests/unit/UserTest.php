<?php

use app\models\User;
use app\tests\fixtures\UserFixture;
use Codeception\Test\Unit;

class UserTest extends Unit
{
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

    public function testValidatePassword()
    {
        $expectedPassword = 'root';

        $user = $this->tester->grabFixture('users')['user1'];
        $registeredUser = User::findOne($user['id']);

        $this->assertTrue($registeredUser->validatePassword($expectedPassword), 'validatePassword method is not valid');
    }

    public function testGetId()
    {
        $user = $this->tester->grabFixture('users')['user1'];
        $expectedId = $user['id'];

        $registeredUser = User::findOne($expectedId);
        $idForTest = $registeredUser->getId();


        $this->assertTrue($expectedId == $idForTest, 'Expected id: ' . $expectedId . ' but got: ' . $idForTest);
    }

    public function testFindIdentity()
    {
        $user = $this->tester->grabFixture('users')['user1'];
        $userId = $user['id'];

        $expectedUserIdentity = User::findOne($userId);
        $userIdentity = User::findIdentity($userId);

        $this->assertTrue($expectedUserIdentity == $userIdentity, 'Expected userId: ' . $expectedUserIdentity->id . ' but got: ' . $userIdentity->id);
    }
}