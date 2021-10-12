<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\LinkPager;

$this->title = 'Image Gallery';
?>
<div class="site-index">
    <div class="upload-image-wrapper">
        <h3 class="upload-image-title">Upload your image</h3>
        <?php $form = ActiveForm::begin(
            [
                'options' => ['enctype' => 'multipart/form-data'],
                'action' => Url::to(['gallery/upload'])
            ]) ?>

        <?= $form->field($addImageForm, 'imageFile')->fileInput(['class' => 'upload-image-input'])->label(false) ?>

        <?= Html::submitButton('Upload', ['class' => 'btn btn-primary']) ?>

        <?php ActiveForm::end()?>
    </div>


    <div class="gallery-wrapper">
        <?php foreach($images as $image): ?>
            <div class="image-item-wrapper">
                <div class="image-wrapper">
                    <?= Html::img("@web/$image->name") ?>
                </div>
                <h4 class="image-title">
                   #<?php echo $image->id ?>
                    <?php echo $image->caption ?>
                </h4>
                <div class="image-edit-btns">
                    <a class="btn btn-primary" href="<?= Url::to(['gallery/edit', 'id' => $image->id]); ?>">Edit</a>
                    <a class="btn btn-primary" href="<?= Url::to(['gallery/delete', 'id' => $image->id]); ?>">Delete</a>
                </div>
            </div>
        <?php endforeach;?>
    </div>
    <?= LinkPager::widget([
        'pagination' => $pages
    ])?>
</div>
