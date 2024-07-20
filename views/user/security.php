<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>

<div class="security-form">
    <?php $form = ActiveForm::begin([
        'id' => 'security-form',
        'options' => ['data-pjax' => true]
    ]); ?>

    <?= $form->field($user, 'password')->passwordInput() ?>
    <?= $form->field($user, 'password_repeat')->passwordInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
    </div>

    <div class="form-group">
        <label>Роль пользователя:</label>
        <p><?= implode(', ', $roleNames) ?></p>
    </div>

    <?php ActiveForm::end(); ?>
</div>
