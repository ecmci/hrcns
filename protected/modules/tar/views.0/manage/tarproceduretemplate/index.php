<?php
$this->breadcrumbs=array(
	'Tar Procedure Templates',
);

$this->menu=array(
	array('label'=>'Create TarProcedureTemplate','url'=>array('create')),
	array('label'=>'Manage TarProcedureTemplate','url'=>array('admin')),
);
?>

<h1 class="page-header">Tar Procedure Templates</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
