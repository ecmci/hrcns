<?php
$this->breadcrumbs=array(
	'Workflow Change Notices',
);

$this->menu=array(
	array('label'=>'Create WorkflowChangeNotice','url'=>array('create')),
	array('label'=>'Manage WorkflowChangeNotice','url'=>array('admin')),
);
?>

<h1 class="page-header">Workflow Change Notices</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
