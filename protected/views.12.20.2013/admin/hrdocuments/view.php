<?php
$this->breadcrumbs=array(
	'HR Notice Documents'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'Create HR Notice Required Document','url'=>array('create')),
	array('label'=>'Update HR Notice Required Document','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete HR Notice Required Document','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage HR Notice Required Documents','url'=>array('admin')),
);
?>

<h1 class="page-header">View HR Notice Required Document #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'notice_type',
		'document',
	),
)); ?>
