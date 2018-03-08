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
$('#example').DataTable({
    language: {
        "sProcessing": "处理中...",
        "sLengthMenu": "显示 _MENU_ 项结果",
        "sZeroRecords": "没有匹配结果",
        "sInfo": "显示第 _START_ 至 _END_ 项结果，共 _TOTAL_ 项",
        "sInfoEmpty": "显示第 0 至 0 项结果，共 0 项",
        "sInfoFiltered": "(由 _MAX_ 项结果过滤)",
        "sInfoPostFix": "",
        "sSearch": "搜索:",
        "sUrl": "",
        "sEmptyTable": "表中数据为空",
        "sLoadingRecords": "载入中...",
        "sInfoThousands": ",",
        "oPaginate": {
            "sFirst": "首页",
            "sPrevious": "上页",
            "sNext": "下页",
            "sLast": "末页"
        },
        "oAria": {
            "sSortAscending": ": 以升序排列此列",
            "sSortDescending": ": 以降序排列此列"
        }
    }
});
JS
);
