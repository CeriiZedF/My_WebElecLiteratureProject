<?php
use yii\helpers\Html;
use yii\widgets\Pjax;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Your site description here">
    <meta name="keywords" content="keyword1, keyword2, keyword3">
    <title>Каталог</title>
    <link href="/vendor/twbs/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <?php $this->head() ?>
    <link href="/assets/css/styles.css" rel="stylesheet">
</head>
<body>
<?php $this->beginBody() ?>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <div class="collapse navbar-collapse justify-content-end">
            <ul class="navbar-nav ml-auto">
                <?php if (!Yii::$app->user->isGuest): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="<?= Yii::$app->user->identity->getAvatarUrl() ?>" class="rounded-circle" alt="Avatar" width="30" height="30">
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li><?= Html::a('Мой аккаунт', ['user/account'], ['class' => 'dropdown-item']) ?></li>
                            <li><?= Html::a('Настройки', ['user/settings'], ['class' => 'dropdown-item']) ?></li>
                            <li>
                                <?= Html::beginForm(['/user/logout'], 'post')
                                    . Html::submitButton('Выход', ['class' => 'dropdown-item'])
                                    . Html::endForm()
                                ?>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<div id="sidebar" class="sidebar">
    <div class="sidebar-header">
        <h3>Меню</h3>
    </div>
    <ul class="nav flex-column">
        <?= Html::a('Каталог', ['literature/index'], ['class' => 'nav-link', 'data-pjax' => true]) ?>
        <?= Html::a('Добавить книгу', ['literature/create'], ['class' => 'nav-link', 'data-pjax' => true]) ?>
        <?php if (Yii::$app->user->isGuest): ?>
            <?= Html::a('Вход', ['user/login'], ['class' => 'nav-link', 'data-pjax' => true]) ?>
        <?php else: ?>
            <?= Html::a('Мой аккаунт', ['user/account'], ['class' => 'nav-link', 'data-pjax' => true]) ?>
            <?= Html::a('Настройки', ['user/settings'], ['class' => 'nav-link', 'data-pjax' => true]) ?>
        <?php endif; ?>
    </ul>
</div>

<main id="content">
    <?php Pjax::begin(['id' => 'main-content', 'timeout' => false, 'enablePushState' => false]) ?>
    <?= $content ?>
    <?php Pjax::end() ?>
</main>

<?php $this->endBody() ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<?= Html::jsFile('/vendor/twbs/bootstrap/dist/js/bootstrap.bundle.min.js') ?>
<script>
    $(document).ready(function () {
        $(document).pjax('a[data-pjax]', '#main-content');
        
        // Toggle sidebar
        $('#sidebarCollapse').on('click', function () {
            $('#sidebar').toggleClass('active');
            $(this).toggleClass('active');
        });

        // Show sidebar on hover
        $('#sidebarCollapse').mouseenter(function () {
            $('#sidebar').addClass('active');
        });

        // Hide sidebar on hover out
        $('#sidebar').mouseleave(function () {
            $('#sidebar').removeClass('active');
        });
    });
</script>
</body>
</html>
