<?php
$this->breadcrumbs=array(
	'Employee Payrolls'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List EmployeePayroll','url'=>array('index')),
	array('label'=>'Manage EmployeePayroll','url'=>array('admin')),
);
?>

<h1>Create EmployeePayroll</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>