<?php
$this->breadcrumbs=array(
	'Tar Users',
);

$this->menu=array(
	array('label'=>'Create TarUser','url'=>array('create')),
	array('label'=>'Manage TarUser','url'=>array('admin')),
);
?>

<h1 class="page-header">Tar Users</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
