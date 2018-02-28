<?php
$form = yii\bootstrap\ActiveForm::begin();
//名字
echo $form->field($model,'name')->textInput();
//简介
echo $form->field($model,'intro')->textarea();
//文章分类id
echo $form->field($model,'article_category_id')->dropDownList(\backend\models\Article::getName());
//排序
echo $form->field($model,'sort')->textInput();
//内容
echo $form->field($content,'content')->textarea();
//确认按钮
echo '<button type="submit" class="btn btn-primary">添加</button>';

yii\bootstrap\ActiveForm::end();