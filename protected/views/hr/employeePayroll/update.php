<?php
$this->breadcrumbs=array(
	'Employee Payrolls'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List EmployeePayroll','url'=>array('index')),
	array('label'=>'Create EmployeePayroll','url'=>array('create')),
	array('label'=>'View EmployeePayroll','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage EmployeePayroll','url'=>array('admin')),
);
?>

<h1>Update EmployeePayroll <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>