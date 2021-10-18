<?php

use app\models\UploadForm;
use yii\web\UploadedFile;

class UploadFormItemTest extends \Codeception\Test\Unit
{
    use \Codeception\Specify;

    /**
     * @var \UnitTester
     */
    protected $tester;

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    public function testUploadImage()
    {
        $this->uploadForm = new UploadForm();

        $this->specify("File is too big", function() {
            $uploadedFile = new UploadedFile();
            $uploadedFile->name = "123.png";
            $uploadedFile->tempName = __DIR__."/../help-data/cpp.png";
            $uploadedFile->type = "image/jpg";
            $uploadedFile->size = 1024 * 1024 * 3;

            $this->uploadForm->imageFile = $uploadedFile;

            $this->assertFalse($this->uploadForm->validate());
        });

        $this->specify("invalid extension", function() {
            $uploadedFile = new UploadedFile();
            $uploadedFile->name = "123.txt";
            $uploadedFile->tempName = __DIR__."/../help-data/text.txt";
            $uploadedFile->type = "text/plain";
            $uploadedFile->size = 1024 * 1024 * 1;

            $this->uploadForm->imageFile = $uploadedFile;

            $this->assertFalse($this->uploadForm->validate());
        });

        $this->specify("file is ok", function() {
            $uploadedFile = new UploadedFile();
            $uploadedFile->name = "cpp.png";
            $uploadedFile->tempName = __DIR__."/../help-data/cpp.png";
            $uploadedFile->type = "text/plain";
            $uploadedFile->size = 1024 * 68.8;

            $this->uploadForm->imageFile = $uploadedFile;

            $this->assertTrue($this->uploadForm->validate());
        });
    }
}