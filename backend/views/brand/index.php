<table class="table table-bordered table-condensed">
    <tr>
        <td>id</td>
        <td>名称</td>
        <td>简介</td>
        <td>logo图片</td>
        <td>排序</td>
        <td>状态</td>
        <td width="160px">操作</td>
    </tr>
    <?php foreach($rows as $row):?>
    <tr>
        <td><?=$row->id?></td>
        <td><?=$row->name?></td>
        <td><?=$row->intro?></td>
        <td><img src="<?=$row->logo?>" width="60"></td>
        <td><?=$row->sort?></td>
        <td><?=$row->is_deleted?'删除':'正常'?></td>
        <td>
            <a href="<?=\yii\helpers\Url::to(['brand/edit','id'=>$row->id])?>" class="btn btn-info">修改</a>
            <a href="<?=\yii\helpers\Url::to(['brand/delete','id'=>$row->id])?>" class="btn btn-danger">删除</a>
        </td>
    </tr>
    <?php endforeach;?>
    <a href="<?=\yii\helpers\Url::to(['brand/add'])?>" class="btn btn-primary">添加</a>
</table>

<?php
//分页
echo \yii\widgets\LinkPager::widget([
    'pagination'=>$paper,
])
?>