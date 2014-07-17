<?php
$this->breadcrumbs=array(
	'Employee Personal Infos'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List EmployeePersonalInfo','url'=>array('index')),
	array('label'=>'Manage EmployeePersonalInfo','url'=>array('admin')),
);
?>

<h1>Create EmployeePersonalInfo</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>