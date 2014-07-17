<?php
$this->breadcrumbs=array(
	'Carbon Copies',
);

$this->menu=array(
	array('label'=>'Create CarbonCopy','url'=>array('create')),
	array('label'=>'Manage CarbonCopy','url'=>array('admin')),
);
?>

<h1 class="page-header">Carbon Copies</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
