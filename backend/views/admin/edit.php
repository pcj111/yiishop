<?php

$form = \yii\bootstrap\ActiveForm::begin();

echo $form->field($model,'username')->textInput();

echo $form->field($model,'email')->textInput();

echo $form->field($model,'roles')->inline(true)->checkboxList(\backend\models\Admin::getName());

echo $form->field($model,'status')->radioList([1=>'启用',0=>'禁用']);

echo '<button type="submit" class="btn btn-primary">提交</button>';

\yii\bootstrap\ActiveForm::end();