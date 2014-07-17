<?php
$this->breadcrumbs=array(
	'Positions',
);

$this->menu=array(
	array('label'=>'Create Position','url'=>array('create')),
	array('label'=>'Manage Position','url'=>array('admin')),
);
?>

<h1 class="page-header">Positions</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
