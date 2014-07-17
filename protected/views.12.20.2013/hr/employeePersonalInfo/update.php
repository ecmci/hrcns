<?php
$this->breadcrumbs=array(
	'Employee Personal Infos'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List EmployeePersonalInfo','url'=>array('index')),
	array('label'=>'Create EmployeePersonalInfo','url'=>array('create')),
	array('label'=>'View EmployeePersonalInfo','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage EmployeePersonalInfo','url'=>array('admin')),
);
?>

<h1>Update EmployeePersonalInfo <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>