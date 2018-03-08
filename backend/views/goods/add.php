<?php
/**
 * @var $this \yii\web\View
 */
$form = \yii\bootstrap\ActiveForm::begin();
//名称
echo $form->field($model,'name')->textInput();
//logo
echo $form->field($model,'logo')->hiddenInput();
//加载css文件
//===========css=======
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
////=========js==========
$this->registerJsFile('@web/webuploader-0.1.5/webuploader.js',[
    'depends'=>\yii\web\JqueryAsset::className()
]);
$img_url = \yii\helpers\Url::to(['goods/img']);
//js代码
$this->registerJs(<<<JS
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
  $("#goods-logo").val(imgUrl);
  $("#logo_view").attr('src',imgUrl);
})
JS
);
echo '<img id="logo_view" width="120px" src="'.$model->logo.'">';
echo '<br>';
//商品分类id
echo $form->field($model,'goods_category_id')->hiddenInput();
//===加载css====
$this->registerCssFile('@web/ztree/css/zTreeStyle/zTreeStyle.css');
//===加载js文件===
$this->registerJsFile('@web/ztree/js/jquery.ztree.core.js',[
    'depends'=>\yii\web\JqueryAsset::className()
]);
$this->registerJs(<<<JS
var zTreeObj;
        // zTree 的参数配置，深入使用请参考 API 文档（setting 配置详解）
        var setting = {
            data: {
		       simpleData: {
			      enable: true,
			      idKey: "id",
			      pIdKey: "parent_id",
			      rootPId: 0
		}
		},
		//点击
		callback: {
		onClick:function(event, treeId, treeNode) {
		  //alert(treeNode.tId + ", " + treeNode.name);
		  //console.log(treeNode);
		  $('#goods-goods_category_id').val(treeNode.id);
		} 
	}
};
  // zTree 的数据属性，深入使用请参考 API 文档（zTreeNode 节点数据详解）
        var zNodes = {$nodes};
        //console.log(zNodes);
            zTreeObj = $.fn.zTree.init($("#treeDemo"), setting, zNodes);
            //展开所有的节点
            zTreeObj.expandAll(true);
            //回显选中节点
            zTreeObj.selectNode( zTreeObj.getNodeByParam("id", "{$model->id}", null));
      
JS
);
echo '<div>
    <ul id="treeDemo" class="ztree"></ul>
</div>';
//品牌分类
echo $form->field($model,'brand_id')->dropDownList(\backend\models\Goods::getName());
//市场价格
echo $form->field($model,'market_price')->textInput();
//商品价格
echo $form->field($model,'shop_price')->textInput();
//库存
echo $form->field($model,'stock')->textInput();
//是否在售(1在售 0下架)
echo $form->field($model,'is_on_sale')->inline()->radioList([1=>'在售',2=>'下架']);
//排序
echo $form->field($model,'sort')->textInput();
//付文本编辑
echo $form->field($intro,'content')->widget('kucha\ueditor\UEditor',[]);
//按钮
echo '<button type="submit" class="btn btn-primary">确认</button>';

\yii\bootstrap\ActiveForm::end();