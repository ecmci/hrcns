<?php
$this->breadcrumbs=array(
	'System Positions',
);

$this->menu=array(
	array('label'=>'Create SystemPosition','url'=>array('create')),
	array('label'=>'Manage SystemPosition','url'=>array('admin')),
);
?>

<h1 class="page-header">System Positions</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
