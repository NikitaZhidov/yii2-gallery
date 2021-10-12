<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title = 'Registration';
?>

<h1>Registration</h1>

<?php
    $form = ActiveForm::begin()
?>

<?= $form->field($registrationForm, 'login')->textInput()?>
<?= $form->field($registrationForm, 'password')->passwordInput()?>
<?= $form->field($registrationForm, 'confirmPassword')->passwordInput()?>

<?= Html::submitButton('Sign up', ['class' => 'btn btn-primary'])?>

<?php
    ActiveForm::end()
?>
