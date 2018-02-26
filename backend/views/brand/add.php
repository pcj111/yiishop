<?php
$form = \yii\bootstrap\ActiveForm::begin();
//姓名
echo $form->field($model,'name')->textInput();
//简介
echo $form->field($model,'intro')->textarea();
//logo
echo $form->field($model,'imgFile')->fileInput();

echo '<button type="submit" class="btn btn-primary">添加</button>';

\yii\bootstrap\ActiveForm::end();