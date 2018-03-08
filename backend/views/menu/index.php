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
            <th>名称</th>
            <th>路由</th>
            <th>排序</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        <a href="<?=\yii\helpers\Url::to(['menu/add'])?>" class="btn btn-primary">添加</a>
        <?php foreach($rows as $row ):?>
            <tr>
                <td><?=$row->name?></td>
                <td><?=$row->path?></td>
                <td><?=$row->sort?></td>
                <td>
                    <a href="<?=\yii\helpers\Url::to(['menu/edit','id'=>$row->id])?>" class="btn btn-warning">修改</a>
                    <a href="#" class="btn btn-danger" data_id ='<?=$row->id?>'>删除</a>
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

$path = \yii\helpers\Url::to(['menu/delete']);
$this->registerJs(<<<JS
$('.btn-danger').click(function() {
  if(confirm('是否确认删除?')){
     var a = $(this).attr('data_id');
      var tr =$(this).closest('tr');
      $.get('{$path}',{id:a},function(date){
        if (date.code==1){
            tr.remove();
        }
      },'json') 
  }
 return false;
})
JS
);
