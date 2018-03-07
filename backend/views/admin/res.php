<?php
$form = \yii\bootstrap\ActiveForm::begin();

echo $form->field($model,'password_hash')->passwordInput();

echo '<button type="submit" class="btn btn-primary">提交</button>';

\yii\bootstrap\ActiveForm::end();