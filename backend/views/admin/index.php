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
                <a href="<?=\yii\helpers\Url::to(['admin/delete','id'=>$row->id])?>" class="btn btn-danger">删除</a>
            </td>
        </tr>
    <?php endforeach;?>
    <a href="<?=\yii\helpers\Url::to(['admin/add'])?>" class="btn btn-primary">添加</a>
</table>

<?php
//分页
echo \yii\widgets\LinkPager::widget([
    'pagination'=>$paper,
])
?>