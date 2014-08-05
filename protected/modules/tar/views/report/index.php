<?php
$this->breadcrumbs=array(
	'Tar Logs',
);

$this->menu=array(
	array('label'=>'Create TarLog','url'=>array('create')),
	array('label'=>'Manage TarLog','url'=>array('admin')),
);
?>

<h1 class="page-header">Tar Logs</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
