<table class="table table-bordered table-condensed">
    <tr>
        <td>id</td>
        <td>名称</td>
        <td>简介</td>
        <td width="160px">操作</td>
    </tr>
    <?php foreach($rows as $row):?>
        <tr>
            <td><?=$row->id?></td>
            <td><?=$row->name?></td>
            <td><?=$row->intro?></td>
            <td>
                <a href="<?=\yii\helpers\Url::to(['goods-category/edit','id'=>$row->id])?>" class="btn btn-info">修改</a>
                <a href="<?=\yii\helpers\Url::to(['goods-category/delete','id'=>$row->id])?>" class="btn btn-danger">删除</a>
            </td>
        </tr>
    <?php endforeach;?>
    <a href="<?=\yii\helpers\Url::to(['goods-category/add'])?>" class="btn btn-primary">添加</a>
</table>

<?php
//分页
echo \yii\widgets\LinkPager::widget([
    'pagination'=>$paper,
])
?>