<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = 'Edit image';
?>

<div class="edit-image-container mt-4 mb-3">
    <?= Html::img("@web/$image->name") ?>
</div>
<?php
    $form = ActiveForm::begin([
        'id' => 'editForm',
        'options' => ['class' => 'edit-image-form']
    ]) ?>

<?= $form->field($image, 'caption')?>

<div class="edit-button-row-wrapper">
    <a class="btn btn-primary" href="<?= Url::to(['gallery/index'])?>">Back</a>
    <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
</div>


<?php ActiveForm::end()?>

