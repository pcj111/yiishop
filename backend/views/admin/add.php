<?php

$form = \yii\bootstrap\ActiveForm::begin();

echo $form->field($model,'username')->textInput();
echo $form->field($model,'password_hash')->passwordInput();
echo $form->field($model,'email')->textInput();
echo $form->field($model,'roles')->inline(true)->checkboxList(\backend\models\Admin::getName());
echo '<button type="submit" class="btn btn-primary">提交</button>';

\yii\bootstrap\ActiveForm::end();