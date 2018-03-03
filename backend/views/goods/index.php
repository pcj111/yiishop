
<table class="table table-bordered table-condensed">
    <?php
     $form =\yii\bootstrap\ActiveForm::begin(['layout'=>'inline','method'=>'get']);
        echo$form->field($model,'name')->textInput(['placeholder'=>'商品名','style'=>'width:100px']);
        echo$form->field($model,'sn')->textInput(['placeholder'=>'货号','style'=>'width:100px']);
        echo$form->field($model,'start')->textInput(['placeholder'=>'￥','style'=>'width:100px']);
        echo $form->field($model,'end')->textInput(['placeholder'=>'￥','style'=>'width:100px']);
        echo '<button type="submit" class="btn btn-default" >搜索</button>';
        \yii\bootstrap\ActiveForm::end();
       ?>

    <tr>
        <td>id</td>
        <td>名称</td>
        <td>货号</td>
        <td>logo图片</td>
        <td>商品分类</td>
        <td>品牌分类</td>
        <td>市场价格</td>
        <td>商品价格</td>
        <td>库存</td>
        <td>是否在售</td>
        <td>状态</td>
        <td>排序</td>
        <td>添加时间</td>
        <td>浏览次数</td>
        <td width="280px">操作</td>
    </tr>
    <?php foreach($rows as $row):?>
    <tr>
        <td><?=$row->id?></td>
        <td><?=$row->name?></td>
        <td><?=$row->sn?></td>
        <td><img src="<?=$row->logo?>" width="60"></td>
        <td><?=$row->goods_category_id==0?'顶级分类':$row->goodsCategory->name?></td>
        <td><?=$row->brand->name?></td>
        <td><?=$row->market_price?></td>
        <td><?=$row->shop_price?></td>
        <td><?=$row->stock?></td>
        <td><?=$row->is_on_sale?'在售':'下架'?></td>
        <td><?=$row->status?'正常':'回收站'?></td>
        <td><?=$row->sort?></td>
        <td><?=date('Y-m-d H:i:s',$row->create_time)?></td>
        <td><?=$row->view_times?></td>
        <td>
            <a href="<?=\yii\helpers\Url::to(['goods/edit','id'=>$row->id])?>" class="btn btn-info">修改</a>
            <a href="<?=\yii\helpers\Url::to(['goods/delete','id'=>$row->id])?>" class="btn btn-danger">删除</a>
            <a href="<?=\yii\helpers\Url::to(['goods/look','id'=>$row->id])?>" class="btn btn-warning">预览</a>
            <a href="<?=\yii\helpers\Url::to(['goods-gallery/index','id'=>$row->id])?>" class="btn btn-primary">图片</a>
        </td>
    </tr>
<?php endforeach;?>
<a href="<?=\yii\helpers\Url::to(['goods/add'])?>" class="btn btn-primary">添加</a>
</table>

<?php
//分页
echo \yii\widgets\LinkPager::widget([
    'pagination'=>$paper,
])
?>

