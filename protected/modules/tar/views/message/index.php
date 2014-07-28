<?php
$this->breadcrumbs=array(
	'Tar Messagings',
);

$this->menu=array(
	array('label'=>'Create TarMessaging','url'=>array('create')),
	array('label'=>'Manage TarMessaging','url'=>array('admin')),
);
?>

<h1 class="page-header">Tar Messagings</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
