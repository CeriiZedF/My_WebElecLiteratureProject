<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = 'Профиль';
?>

<div class="profile-form">
    <?php $form = ActiveForm::begin([
        'id' => 'profile-form',
        'options' => ['data-pjax' => true],
        'action' => ['profile'] 
    ]); ?>

    <?= $form->field($user, 'username')->textInput() ?>
    <?= $form->field($user, 'email')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

<script>
$(document).ready(function () {
    $('#profile-form').on('beforeSubmit', function (e) {
        e.preventDefault(); 

        var $form = $(this);

       
        return false; 
    });
});
</script>
