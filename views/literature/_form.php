<?php

use dosamigos\ckeditor\CKEditor;

echo $form->field($model, 'description')->widget(CKEditor::className(), [
    'options' => ['rows' => 6],
    'preset' => 'basic'
]);
