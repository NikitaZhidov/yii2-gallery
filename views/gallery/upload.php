<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
$this->title = 'Upload image';

?>

<h1>Write a caption to the picture</h1>

<div class="edit-image-container mt-4 mb-3">
    <?= Html::img(Url::to("@web/$imageName")) ?>
</div>

<?php
    $form = ActiveForm::begin(
        [
            'action' => Url::to(['gallery/index'])
        ]) ?>


    <?= Html::img("@app/$imageName") ?>

    <?= $form->field($imageItemForm, 'name')->hiddenInput(['value' => $imageName])->label(false) ?>
    <?= $form->field($imageItemForm, 'caption')->textInput() ?>

    <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>

    <?php ActiveForm::end()?>