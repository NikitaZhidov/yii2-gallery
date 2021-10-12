<?php

namespace app\models;

use yii\base\Model;

class ImageItemForm extends Model
{
    public $caption;
    public $name;

    public function rules()
    {
        return [];
    }
}