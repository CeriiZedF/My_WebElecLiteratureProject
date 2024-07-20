<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\Literature $model */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Literature', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="literature-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('Create Chapter', ['chapter/create', 'literature_id' => $model->id], ['class' => 'btn btn-success']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'description:ntext',
            [
                'attribute' => 'author_id',
                'value' => function ($model) {
                    return $model->author ? Html::encode($model->author->username) : 'Unknown';
                },
                'format' => 'text',
            ],
            'views',
            'likes',
            'bookmarks',
            'comments_enabled:boolean',
            'created_at',
            'updated_at',
        ],
    ]) ?>

    <h2>Chapters</h2>
    <?= GridView::widget([
        'dataProvider' => new yii\data\ActiveDataProvider([
            'query' => $model->getChapters(),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]),
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'title',
            'description:ntext',
            [
                'attribute' => 'author_id',
                'value' => function ($model) {
                    return $model->author ? Html::encode($model->author->username) : 'Unknown';
                },
                'format' => 'text',
            ],
            'views',
            'likes',
            'bookmarks',
            'comments_enabled:boolean',
            'created_at',
            'updated_at',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('View', ['chapter/view', 'id' => $model->id], ['class' => 'btn btn-primary']);
                    },
                    'update' => function ($url, $model) {
                        return Html::a('Update', ['chapter/update', 'id' => $model->id], ['class' => 'btn btn-secondary']);
                    },
                    'delete' => function ($url, $model) {
                        return Html::a('Delete', ['chapter/delete', 'id' => $model->id], [
                            'class' => 'btn btn-danger',
                            'data' => [
                                'confirm' => 'Are you sure you want to delete this item?',
                                'method' => 'post',
                            ],
                        ]);
                    },
                ],
            ],
        ],
    ]) ?>

</div>
