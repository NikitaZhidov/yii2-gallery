<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = 'Delete image';
?>

<div class="edit-image-container mt-4 mb-3">
    <?= Html::img("@web/$image->name") ?>
</div>

<p class="text-center">Are you sure want to delete the image <b><?= $image->caption ?></b>?</p>

<div class="edit-button-row-wrapper text-center d-flex justify-content-center">

    <a class="btn btn-primary mr-2" href="<?= Url::to(['gallery/index'])?>">Back</a>

    <?php $form = ActiveForm::begin([
        'action' => Url::to(['gallery/index']),
        'options' => ['class' => 'd-flex']
    ]) ?>
        <?= $form->field($deleteImageForm, 'id')->hiddenInput(['value' => $image->id])->label(false)?>
        <?= Html::submitButton('Delete', ['class' => 'btn btn-danger']) ?>
    <?php ActiveForm::end()?>
</div>