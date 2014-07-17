<?php
$this->breadcrumbs=array(
	'Carbon Copies'=>array('index'),
	$model->id,
);

$this->menu=array(
	//array('label'=>'List CarbonCopy','url'=>array('index')),
	array('label'=>'Create CarbonCopy','url'=>array('create')),
	array('label'=>'Update CarbonCopy','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete CarbonCopy','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Carbon Copies','url'=>array('admin')),
);
?>

<h1 class="page-header">View CarbonCopy #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'workflow_notice_status',
		'recipient_email',
	),
)); ?>
