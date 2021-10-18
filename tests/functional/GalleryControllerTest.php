<?php

use app\tests\fixtures\ImageFixture;
use app\tests\fixtures\UserFixture;

class GalleryControllerTest extends \Codeception\Test\Unit
{
    /**
     * @var \FunctionalTester
     */
    protected $tester;

    public function _fixtures()
    {
        return [
            'images' => [
                'class' => ImageFixture::class,
                'dataFile' => codecept_data_dir() . 'image.php'
            ],
            'users' => [
                'class' => UserFixture::class,
                'dataFile' => codecept_data_dir() . 'user.php'
            ]
        ];
    }

    protected function _before()
    {
        $this->loginInSystem('root', 'root');
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

    public function testShowGallery()
    {
        $this->tester->amOnPage(['gallery/index']);

        $this->tester->see('#1 Angular');
        $this->tester->see('Upload your image');
    }

    public function testEdit()
    {
        $this->tester->amOnPage(['gallery/index']);

        $this->tester->click('Edit');
        $this->tester->fillField('Caption', 'Angular_test');
        $this->tester->click('Save');

        $this->tester->see('#1 Angular_test');
    }

    public function testDelete()
    {
        $this->tester->amOnPage(['gallery/index']);
        $this->tester->click('Delete');
        $this->tester->see('Are you sure want to delete the image Angular?');

        $this->tester->click('Delete');

        $this->tester->see('No images');
    }

    public function testUploadImage()
    {
        $this->tester->amOnPage(['gallery/index']);

        $this->tester->attachFile('input[id=uploadform-imagefile]', 'cpp.png');
        $this->tester->click('Upload');

        $this->tester->see('Write a caption to the picture', 'h1');
        $this->tester->fillField('Caption', 'cpp_test');
        $this->tester->click('Save');

        $this->tester->see('#2 cpp_test');
    }

    public function testTryUseIncorrectUploadAction()
    {
        $this->tester->amOnPage(['gallery/upload']);

        $this->tester->see('Upload the photo on gallery page');
    }

    public function test404ErrorPage()
    {
        $this->tester->amOnPage(['gallery/error']);

        $this->tester->see('404 not found');
    }

    public function testIncorrectDeleteImageId()
    {
        $this->tester->amOnPage(['gallery/delete', 'id' => 'abc']);

        $this->tester->see('Image with id abc not found');
    }

    public function testIncorrectEditImageId()
    {
        $this->tester->amOnPage(['gallery/edit', 'id' => 'abc']);

        $this->tester->see('Image with id abc not found');
    }
}