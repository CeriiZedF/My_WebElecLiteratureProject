<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Literature $model */
/** @var yii\widgets\ActiveForm $form */

$this->title = 'Create Literature';
$this->params['breadcrumbs'][] = ['label' => 'Literature', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Create';
?>
<div class="literature-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="literature-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

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
