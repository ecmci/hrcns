<?php
$this->breadcrumbs=array(
	'Payrolls'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Payroll','url'=>array('index')),
	array('label'=>'Create Payroll','url'=>array('create')),
	array('label'=>'View Payroll','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage Payroll','url'=>array('admin')),
);
?>

<h1 class="page-header">Update Payroll <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>