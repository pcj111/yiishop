<table class="table table-bordered table-condensed">

    <tr>
        <td>id</td>
        <td>用户名</td>
        <td>邮箱</td>
        <td>状态</td>
        <td width="280px">操作</td>
    </tr>
    <?php foreach($rows as $row):?>
        <tr>
            <td><?=$row->id?></td>
            <td><?=$row->username?></td>
            <td><?=$row->email?></td>
            <td><?=$row->status?'启用':'禁用'?></td>
            <td>
                <a href="<?=\yii\helpers\Url::to(['admin/edit','id'=>$row->id])?>" class="btn btn-info">修改</a>
                <a href="<?=\yii\helpers\Url::to(['admin/delete',])?>" class="btn btn-danger" id="<?=$row->id?>">删除</a>
                <a href="<?=\yii\helpers\Url::to(['admin/res','id'=>$row->id])?>" class="btn btn-warning">重置密码</a>
            </td>
        </tr>
    <?php endforeach;?>
    <a href="<?=\yii\helpers\Url::to(['admin/add'])?>" class="btn btn-primary">添加</a>
</table>

<?php
//分页
echo \yii\widgets\LinkPager::widget([
    'pagination'=>$paper,
]);

$ajax_url=\yii\helpers\Url::to(['admin/delete']);
$this->registerJs(
    <<<JS
        $('.table').on('click','.btn-danger',function() {
            //如果确定
            if(confirm('是否确认删除?')){
                var tr=$(this).closest('tr');
                var id=$(this).attr('id');
             $.get('{$ajax_url}',{'id':id},function(res) {
                if(res.code){
                   tr.fadeOut();
                 }
              },'json');
            };
            return false;
        });


JS
);
