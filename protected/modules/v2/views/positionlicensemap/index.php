<?php
$this->breadcrumbs=array(
	'Position License Maps',
);

$this->menu=array(
	array('label'=>'Create PositionLicenseMap','url'=>array('create')),
	array('label'=>'Manage PositionLicenseMap','url'=>array('admin')),
);
?>

<h1 class="page-header">Position License Maps</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
