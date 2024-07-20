<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>

<div class="avatar-form">
    <?php $form = ActiveForm::begin([
        'id' => 'avatar-form',
        'options' => ['data-pjax' => true]
    ]); ?>

    <?= $form->field($user, 'avatar')->fileInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
