<?php
$this->breadcrumbs=array(
	'Licenses',
);

$this->menu=array(
	array('label'=>'Create License','url'=>array('create')),
	array('label'=>'Manage License','url'=>array('admin')),
);
?>

<h1 class="page-header">Licenses</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
