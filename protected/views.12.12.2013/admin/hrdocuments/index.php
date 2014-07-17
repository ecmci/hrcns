<?php
$this->breadcrumbs=array(
	'Hr Documents',
);

$this->menu=array(
	array('label'=>'Create HrDocuments','url'=>array('create')),
	array('label'=>'Manage HrDocuments','url'=>array('admin')),
);
?>

<h1 class="page-header">Hr Documents</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
