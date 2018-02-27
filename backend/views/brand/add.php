<?php
/**
 * @var $this \yii\web\View
 */
$form = \yii\bootstrap\ActiveForm::begin();
//姓名
echo $form->field($model,'name')->textInput();
//简介
echo $form->field($model,'intro')->textarea();
//logo
echo $form->field($model,'logo')->hiddenInput();
//引入css
$this->registerCssFile('@web/webuploader-0.1.5/webuploader.css');
echo <<<html
<div id="uploader" class="wu-example">
    <!--用来存放文件信息-->
    <div id="thelist" class="uploader-list"></div>
    <div class="btns">
        <div id="picker">选择文件</div>
    </div>
</div>
html;
//引入js
$this->registerJsFile('@web/webuploader-0.1.5/webuploader.js',[
    'depends'=>\yii\web\JqueryAsset::className()
]);
$img_url = \yii\helpers\Url::to(['brand/upload']);
$this->registerJs(
    <<<JS
    // 初始化Web Uploader
var uploader = WebUploader.create({

    // 选完文件后，是否自动上传。
    auto: true,

    // swf文件路径
    swf: '/webuploader/Uploader.swf',

    // 文件接收服务端。
    server: '{$img_url}',

    // 选择文件的按钮。可选。
    // 内部根据当前运行是创建，可能是input元素，也可能是flash.
    pick: '#picker',

    // 只允许选择图片文件。
    accept: {
        title: 'Images',
        extensions: 'gif,jpg,jpeg,bmp,png',
        //mimeTypes: 'image/*'
        mimeTypes: 'image/gif,image/jpeg,image/jpg,image/png'
    }
});
//文件上传成功显示页面
uploader.on('uploadSuccess',function(file,response) {
  var imgUrl = response.url;
  console.log(imgUrl);
  $("#brand-logo").val(imgUrl);
  $("#logo_view").attr('src',imgUrl);
})

JS
);
echo '<img id="logo_view" width="120px">';

echo'<br>';
echo '<button type="submit" class="btn btn-primary">添加</button>';

\yii\bootstrap\ActiveForm::end();