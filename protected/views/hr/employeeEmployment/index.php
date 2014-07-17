<?php
$this->breadcrumbs=array(
	'Employee Employments',
);

$this->menu=array(
	array('label'=>'Create EmployeeEmployment','url'=>array('create')),
	array('label'=>'Manage EmployeeEmployment','url'=>array('admin')),
);
?>

<h1>Employee Employments</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
