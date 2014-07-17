<?php
$this->breadcrumbs=array(
	'Payrolls',
);

$this->menu=array(
	array('label'=>'Create Payroll','url'=>array('create')),
	array('label'=>'Manage Payroll','url'=>array('admin')),
);
?>

<h1 class="page-header">Payrolls</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
