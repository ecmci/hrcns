<?php
$this->breadcrumbs=array(
	'Tar Alerts Templates',
);

$this->menu=array(
	array('label'=>'Create TarAlertsTemplate','url'=>array('create')),
	array('label'=>'Manage TarAlertsTemplate','url'=>array('admin')),
);
?>

<h1 class="page-header">Tar Alerts Templates</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
