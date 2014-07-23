<?php
$this->breadcrumbs=array(
	'Tar Alerts',
);

$this->menu=array(
	array('label'=>'Create TarAlerts','url'=>array('create')),
	array('label'=>'Manage TarAlerts','url'=>array('admin')),
);
?>

<h1 class="page-header">Tar Alerts</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
