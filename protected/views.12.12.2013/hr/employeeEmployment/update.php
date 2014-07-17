<?php
$this->breadcrumbs=array(
	'Employee Employments'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List EmployeeEmployment','url'=>array('index')),
	array('label'=>'Create EmployeeEmployment','url'=>array('create')),
	array('label'=>'View EmployeeEmployment','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage EmployeeEmployment','url'=>array('admin')),
);
?>

<h1>Update EmployeeEmployment <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>