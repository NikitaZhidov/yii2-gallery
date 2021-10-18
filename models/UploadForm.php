<?php

namespace app\models;

use Yii;
use yii\base\Model;

class UploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $imageFile;

    public function rules()
    {
        return [
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg', 'maxSize' => 2 * 1024 * 1024],
        ];
    }

    public function upload()
    {
        if ($this->validate()) {

            $imageName = Yii::$app->getSecurity()->generateRandomString(10). '.' . $this->imageFile->extension;
            $imageFullPath = Yii::getAlias('@app') . '/upload/' . $imageName;

            $this->imageFile->saveAs($imageFullPath);

            return $imageName;
        } else {
            return NULL;
        }
    }
}