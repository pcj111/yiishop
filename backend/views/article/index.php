<table class="table table-bordered table-condensed">
    <tr>
        <td>id</td>
        <td>名称</td>
        <td>简介</td>
        <td>分类</td>
        <td>排序</td>
        <td>状态</td>
        <td>创建时间</td>
        <td width="240px">操作</td>
    </tr>
    <?php foreach($rows as $row):?>
        <tr>
            <td><?=$row->id?></td>
            <td><?=$row->name?></td>
            <td><?=$row->intro?></td>
            <td><?=$row->articleCatagory['name']?></td>
            <td><?=$row->sort?></td>
            <td><?=$row->is_deleted?'删除':'正常'?></td>
            <td><?=date('Y-m-d H:i:s',$row->create_time)?></td>
            <td>
                <a href="<?=\yii\helpers\Url::to(['article/edit','id'=>$row->id])?>" class="btn btn-info">修改</a>
                <a href="<?=\yii\helpers\Url::to(['article/delete','id'=>$row->id])?>" class="btn btn-danger">删除</a>
                <a href="<?=\yii\helpers\Url::to(['article/look','id'=>$row->id])?>" class="btn btn-warning">查看</a>
            </td>
        </tr>
    <?php endforeach;?>
    <a href="<?=\yii\helpers\Url::to(['article/add'])?>" class="btn btn-primary">添加</a>
</table>

<?php
//分页
echo \yii\widgets\LinkPager::widget([
    'pagination'=>$paper,
])
?>