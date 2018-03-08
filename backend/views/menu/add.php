<?php
$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'name')->textInput();
echo $form->field($model,'parent_id')->dropDownList(\backend\models\Menu::getName());
echo $form->field($model,'path')->dropDownList(\backend\models\Menu::getPath());
echo $form->field($model,'sort')->textInput();
echo '<button type="submit" class="btn btn-primary">确认</button>';
\yii\bootstrap\ActiveForm::end();