<?php
use yii\helpers\Html;
use yii\helpers\Url;

/** @var app\models\Literature $model */

?>
<div class="card h-100 shadow-sm rounded">
    <div class="card-body">
        <h5 class="card-title"><?= Html::encode($model->title) ?></h5>
        <p class="card-text"><?= Html::encode($model->description) ?></p>
        <p class="card-text"><small class="text-muted">Автор: <?= Html::encode($model->author->username) ?></small></p>
        <p class="card-text"><small class="text-muted">Просмотры: <?= $model->views ?></small></p>
        <p class="card-text"><small class="text-muted">Лайки: <?= $model->likes ?></small></p>
        <p class="card-text"><small class="text-muted">Закладки: <?= $model->bookmarks ?></small></p>
        <p class="card-text"><small class="text-muted">Комментарии: <?= $model->comments_enabled ? 'Включены' : 'Отключены' ?></small></p>
        
        <div class="btn-group" role="group" aria-label="Basic example">
            <?= Html::a('Просмотр', ['view', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-secondary']) ?>
            <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Вы уверены, что хотите удалить эту литературу?',
                    'method' => 'post',
                ], ]) ?>
            <?= Html::a('Детальніше', ['view', 'id' => $model->id], ['class' => 'btn btn-primary btn-block']) ?>
        </div>
    </div>
</div>


