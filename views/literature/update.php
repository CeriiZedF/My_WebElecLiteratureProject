<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Literature $model */

$this->title = 'Update Literature: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Literatures', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="literature-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
