<?php
$this->breadcrumbs=array(
	'Employee Personal Infos',
);

$this->menu=array(
	array('label'=>'Create EmployeePersonalInfo','url'=>array('create')),
	array('label'=>'Manage EmployeePersonalInfo','url'=>array('admin')),
);
?>

<h1>Employee Personal Infos</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
