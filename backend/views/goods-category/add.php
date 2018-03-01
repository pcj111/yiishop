<?php
/**
 * @var $this \yii\web\View
 */
$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'name')->textInput();
echo $form->field($model,'parent_id')->hiddenInput();
//==============ztree==========
//加载css文件
$this->registerCssFile('@web/ztree/css/zTreeStyle/zTreeStyle.css');
//加载js文件
$this->registerJsFile('@web/ztree/js/jquery.ztree.core.js',[
    'depends'=>\yii\web\JqueryAsset::className()
]);
//写js代码
$this->registerJs(
    <<<JS
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
		  $('#goodscategory-parent_id').val(treeNode.id);
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
            zTreeObj.selectNode( zTreeObj.getNodeByParam("id", "{$model->parent_id}", null));
JS
);
//写html代码
echo '<div>
    <ul id="treeDemo" class="ztree"></ul>
</div>';
//==============ztree==========
echo $form->field($model,'intro')->textarea();
echo '<button type="submit" class="btn btn-primary">添加</button>';
\yii\bootstrap\ActiveForm::end();