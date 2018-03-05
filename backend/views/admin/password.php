<?php
$form = \yii\bootstrap\ActiveForm::begin();

echo $form->field($model,'old_password')->textInput();

echo $form->field($model,'new_password')->passwordInput();

echo $form->field($model,'password')->passwordInput();

echo '<button type="submit" class="btn btn-primary">提交</button>';

\yii\bootstrap\ActiveForm::end();