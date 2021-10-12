<?php

use yii\helpers\Url;

$this->title = 'Error page';
?>
<p><?= $error_message ?></p>
<a href="<?= Url::to(['gallery/index']) ?>">Back to main</a>