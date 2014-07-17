<?php
$this->breadcrumbs=array(
	'Emailers'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Emailer','url'=>array('index')),
	array('label'=>'Create Emailer','url'=>array('create')),
	array('label'=>'Update Emailer','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete Emailer','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Emailer','url'=>array('admin')),
);
?>

<h1 class="page-header">View Emailer #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'from',
		'to',
		'subject',
		'message',
		'sent',
		'sent_timestamp',
		'queued_timestamp',
	),
)); ?>
