<?php
$form = \yii\bootstrap\ActiveForm::begin();

echo $form->field($model,'username')->textInput();
echo $form->field($model,'password')->passwordInput();
echo $form->field($model,'code')->widget(\yii\captcha\Captcha::className(),
    ['captchaAction'=>'login/captcha',
        'template'=>'<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-2">{input}</div></div>'
    ]);
echo $form->field($model,'member')->checkbox();
echo '<button type="submit" class="btn btn-primary">登录</button>';
\yii\bootstrap\ActiveForm::end();