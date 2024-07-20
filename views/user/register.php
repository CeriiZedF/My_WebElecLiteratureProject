<?php
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Register';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-register">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to register:</p>

    <div class="row">
        <div class="col-lg-5">

            <?php $form = ActiveForm::begin([
                'id' => 'register-form',
                'fieldConfig' => [
                    'template' => "{label}\n{input}\n{error}",
                    'labelOptions' => ['class' => 'form-label'],
                    'inputOptions' => ['class' => 'form-control'],
                    'errorOptions' => ['class' => 'invalid-feedback'],
                ],
            ]); ?>

            <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

            <?= $form->field($model, 'email')->textInput(['type' => 'email']) ?>

            <?= $form->field($model, 'password')->passwordInput() ?>

            <?= $form->field($model, 'password_repeat')->passwordInput()->label('Confirm Password') ?>

            <?= $form->field($model, 'avatar')->textInput(['maxlength' => true])->label('Avatar URL') ?>

            <?= $form->field($model, 'avatarFile')->fileInput()->label('Upload Avatar') ?>

            <?= $form->field($model, 'avatarOption')->dropDownList([
                'file' => 'Upload File',
                'url' => 'Use URL',
            ], ['prompt' => 'Select Avatar Option']) ?>

            <?= $form->errorSummary($model) ?>

            <div class="form-group mt-3">
                <?= Html::submitButton('Register', ['class' => 'btn btn-primary', 'name' => 'register-button']) ?>
            </div>

            <div class="mt-3">
                <?= Html::a('Login', ['login'], ['class' => 'btn btn-link']) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>
