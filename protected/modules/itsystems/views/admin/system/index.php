<?php
$this->breadcrumbs=array(
	'Systems',
);

$this->menu=array(
	array('label'=>'Create System','url'=>array('create')),
	array('label'=>'Manage System','url'=>array('admin')),
);
?>

<h1 class="page-header">Systems</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
