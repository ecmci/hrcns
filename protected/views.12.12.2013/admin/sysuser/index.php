<?php
$this->breadcrumbs=array(
	'Sys Users',
);

$this->menu=array(
	array('label'=>'Create SysUser','url'=>array('create')),
	array('label'=>'Manage SysUser','url'=>array('admin')),
);
?>

<h1 class="page-header">Sys Users</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
