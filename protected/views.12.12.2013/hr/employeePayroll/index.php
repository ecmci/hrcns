<?php
$this->breadcrumbs=array(
	'Employee Payrolls',
);

$this->menu=array(
	array('label'=>'Create EmployeePayroll','url'=>array('create')),
	array('label'=>'Manage EmployeePayroll','url'=>array('admin')),
);
?>

<h1>Employee Payrolls</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
