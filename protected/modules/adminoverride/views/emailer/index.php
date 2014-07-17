<?php
$this->breadcrumbs=array(
	'Emailers',
);

$this->menu=array(
	array('label'=>'Create Emailer','url'=>array('create')),
	array('label'=>'Manage Emailer','url'=>array('admin')),
);
?>

<h1 class="page-header">Emailers</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
