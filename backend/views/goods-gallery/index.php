<?php
/* @var $this yii\web\View */


?>
    <h1>相册</h1>
    <div id="uploader" class="wu-example">
        <!--用来存放文件信息-->
        <div id="thelist" class="uploader-list"></div>
        <div class="btns">
            <div id="picker"><span class="glyphicon glyphicon-picture"></span>添加图片</div>
        </div>
    </div>
    <table class="table table-bordered table-hover">
        <tr>
            <td>图片</td>
            <td>操作</td>

        </tr>

        <thead id="thead"></thead>
        <?php foreach ($imgs as $img): ?>
            <tr>
                <td><img src="<?= $img->path ?>" alt="" width="200px"></td>
                <td><?= \yii\bootstrap\Html::a('删除',['goods-gallery/delete','id'=>$img->id],['class'=>'btn btn-danger'])?></td>
            </tr>
        <?php endforeach; ?>

    </table>

<?php


//-----webuploader-----
$this->registerCssFile('@web/webuploader-0.1.5/webuploader.css');
$this->registerJsFile('@web/webuploader-0.1.5/webuploader.js',[
    'depends'=>\yii\web\JqueryAsset::className()
]);
//配置
$img_url = \yii\helpers\Url::to(['goods-gallery/img']);
$aurl = \yii\helpers\Url::to(['goods-gallery/add']);

$this->registerJs(
    <<<JS
// 初始化Web Uploader
var uploader = WebUploader.create({

    // 选完文件后，是否自动上传。
    auto: true,

    // swf文件路径
    swf: '/webuploader/Uploader.swf',

    // 文件接收服务端。
    server: "{$img_url}",

    // 选择文件的按钮。可选。
    // 内部根据当前运行是创建，可能是input元素，也可能是flash.
    pick: '#picker',

    // 只允许选择图片文件。
    accept: {
        title: 'Images',
        extensions: 'gif,jpg,jpeg,bmp,png',
        mimeTypes: 'image/*'
    }
});
// 文件上传成功，给item添加成功class, 用样式标记上传成功。
uploader.on( 'uploadSuccess', function( file ,response) {
    //发送地址
     var imgUrl = response.url;
        //Ajax发送Id
       $.post('{$aurl}',{'path':imgUrl,'goods_id':'{$id}'},function(data) {
           console.log(data);
         if (data.code == '1'){
             window.location.reload(true);
         }
          
       },'json') 
});


JS
);
//-----webuploader-----



