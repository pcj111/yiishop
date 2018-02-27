
<?php
/* @var $this yii\web\View */
?>
    <h2>文章分类列表</h2>
    <table class="table table-bordered ">
        <tr>
            <td>ID</td>
            <td>名称</td>
            <td>简介</td>
            <td>排序</td>
            <td>状态</td>
            <td>操作</td>
        </tr>
        <?php foreach($categories as $category): ?>
            <tr>
                <td><?=$category->id?></td>
                <td><?=$category->name?></td>
                <td><?=$category->intro?></td>
                <td><?=$category->sort?></td>
                <td><?=$category->is_deleted?'删除':'正常'?></td>
                <td>
                    <?=\yii\bootstrap\Html::a('修改',['article-category/edit','id'=>$category->id])?>
                    <?=\yii\bootstrap\Html::a('删除',['article-category/delete','id'=>$category->id])?>
                </td>
            </tr>
        <?php endforeach; ?>
        <tr>
            <td colspan="7"><?=\yii\bootstrap\Html::a('添加',['article-category/add'])?></td>
        </tr>
    </table>

    <!--分页工具条-->
<?php
echo \yii\widgets\LinkPager::widget(['pagination'=>$pager]);
//分页工具条