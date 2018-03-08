<?php
/**
* @var $this \yii\web\View;
*/
//===css===//
$this->registerCssFile('@web/DataTables-1.10.15/media/css/jquery.dataTables.css');
//加载js文件
$this->registerJsFile('@web/DataTables-1.10.15/media/js/jquery.dataTables.js',[
        'depends'=>\yii\web\JqueryAsset::class
]);

?>
<table id="table_id_example" class="table table-bordered table-condensed">
    <thead>
    <tr>
        <th>权限</th>
        <th>描述</th>
        <th>操作</th>
    </tr>
    </thead>
    <tbody>
    <a href="<?=\yii\helpers\Url::to(['rbac/add'])?>" class="btn btn-primary">添加</a>
    <?php foreach($authManagers as $authManager ):?>
    <tr>
        <td><?=$authManager->name?></td>
        <td><?=$authManager->description?></td>
        <td>
            <a href="<?=\yii\helpers\Url::to(['rbac/edit','name'=>$authManager->name])?>" class="btn btn-warning">修改</a>
            <a href="<?=\yii\helpers\Url::to(['rbac/delete','name'=>$authManager->name])?>" class="btn btn-danger">删除</a>
        </td>
    </tr>
    <?php endforeach;?>
    </tbody>
</table>

<?php
$this->registerJs(<<<JS
$(document).ready( function () {
    $('#table_id_example').DataTable({
    });
} );
JS
);
