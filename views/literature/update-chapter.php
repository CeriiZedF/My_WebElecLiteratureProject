<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Chapter $model */
/** @var yii\widgets\ActiveForm $form */

$this->title = 'Update Chapter: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Literature', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->literature->title, 'url' => ['view', 'id' => $model->literature_id]];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view-chapter', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="chapter-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="chapter-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

        <?= $form->field($model, 'author_id')->textInput() ?>

        <?= $form->field($model, 'views')->textInput() ?>

        <?= $form->field($model, 'likes')->textInput() ?>

        <?= $form->field($model, 'bookmarks')->textInput() ?>

        <?= $form->field($model, 'comments_enabled')->checkbox() ?>

        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
