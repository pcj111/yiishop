<?php

$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'name')->textInput(['placeholder'=>'路由']);
echo $form->field($model,'description')->textInput();
echo '<button type="submit" class="btn btn-primary">确认</button>';
\yii\bootstrap\ActiveForm::end();