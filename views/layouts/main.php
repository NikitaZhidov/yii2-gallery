<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\assets\AppAsset;
use yii\bootstrap4\Html;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>
<main role="main" class="flex-shrink-0">
    <header class="header">
        <div class="container">
            <div class="header__inner">
                <h1 class="gallery-title">
                    <?= Html::a('Image Gallery', ['gallery/index'])?>
                </h1>
                <?php if (Yii::$app->user->isGuest): ?>
                    <div>
                        <?= Html::a('Log in', ['auth/login'], ['class' => 'btn btn-success']); ?>
                        <?= Html::a('Registration', ['auth/registration'], ['class' => 'btn btn-primary']); ?>
                    </div>
                <?php else: ?>
                    <div class="d-flex align-items-center">
                        <h5 class="mr-3 mb-0">
                            #<?= Yii::$app->user->identity->id?>
                            <?= Yii::$app->user->identity->login?>
                        </h5>
                        <?= Html::a('Log out', ['auth/logout'], ['class' => 'btn btn-primary']); ?>
                    </div>
                <?php endif;?>
            </div>
        </div>
    </header>
    <div class="main-content container">
        <?= $content ?>
    </div>
</main>

<footer class="footer mt-auto py-3 text-muted">
    <div class="container">
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
