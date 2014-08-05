<?php
$this->breadcrumbs=array(
	'Notices',
);

$this->menu=array(
	array('label'=>'Create Notice','url'=>array('create')),
	array('label'=>'Manage Notice','url'=>array('admin')),
);
?>

<h1 class="page-header">Notices</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
