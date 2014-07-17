<?php
$this->breadcrumbs=array(
	'Licenses'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'New License Form','url'=>array('create')),
	array('label'=>'Update','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Licenses','url'=>array('admin')),
);
?>

<h1 class="page-header">View License '<?php echo $model->name; ?>'</h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		//'id',
		array(
      'name'=>'emp_id',
      'value'=>$model->emp->getFullName(),
    ),
		//'name',
		'serial_number',
		'date_issued',
		'date_of_expiration',
		array(
      'name'=>'attachment',
      'type'=>'raw',
      'value'=>$model->printAttachments($model,0),
    ),
		'timestamp',
	),
)); ?>
