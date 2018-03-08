<?php
$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'name')->textInput();
echo $form->field($model,'description')->textInput();
echo $form->field($model,'permission')->inline(true)->checkboxList(\backend\models\RoluForm::getName());
echo '<button type="submit" class="btn btn-primary">确认</button>';
\yii\bootstrap\ActiveForm::end();