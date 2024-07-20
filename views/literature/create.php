<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Literature $model */
/** @var yii\widgets\ActiveForm $form */

$this->title = 'Update Literature: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Literature', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="literature-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="literature-form">

        

        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
