<?php
$this->breadcrumbs=array(
	'Hr Users',
);

$this->menu=array(
	array('label'=>'Create HrUser','url'=>array('create')),
	array('label'=>'Manage HrUser','url'=>array('admin')),
);
?>

<h1>Hr Users</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
