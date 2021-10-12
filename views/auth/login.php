<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title = 'Login';
?>

<h1>Login</h1>

<?php
    $form = ActiveForm::begin()
?>

<?= $form->field($loginForm, 'login')->textInput()?>
<?= $form->field($loginForm, 'password')->passwordInput()?>

<?= Html::submitButton('Sign in', ['class' => 'btn btn-success'])?>

<?php
    ActiveForm::end()
?>
