<?php
$this->breadcrumbs=array(
	'Hr Users'=>array('index'),
	$model->user_id=>array('view','id'=>$model->user_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List HrUser','url'=>array('index')),
	array('label'=>'Create HrUser','url'=>array('create')),
	array('label'=>'View HrUser','url'=>array('view','id'=>$model->user_id)),
	array('label'=>'Manage HrUser','url'=>array('admin')),
);
?>

<h1>Update HrUser <?php echo $model->user_id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>