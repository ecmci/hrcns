<?php
$this->breadcrumbs=array(
	'Tar Users'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List TarUser','url'=>array('index')),
	array('label'=>'Create TarUser','url'=>array('create')),
	array('label'=>'Update TarUser','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete TarUser','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage TarUser','url'=>array('admin')),
);
?>

<h1 class="page-header">View TarUser #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'is_active',
		'group_id',
	),
)); ?>
