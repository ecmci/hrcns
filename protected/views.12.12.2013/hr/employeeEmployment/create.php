<?php
$this->breadcrumbs=array(
	'Employee Employments'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List EmployeeEmployment','url'=>array('index')),
	array('label'=>'Manage EmployeeEmployment','url'=>array('admin')),
);
?>

<h1>Create EmployeeEmployment</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>