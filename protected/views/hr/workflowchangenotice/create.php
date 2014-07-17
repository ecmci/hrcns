<?php
$this->breadcrumbs=array(
	'Workflow Change Notices'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List WorkflowChangeNotice','url'=>array('index')),
	array('label'=>'Manage WorkflowChangeNotice','url'=>array('admin')),
);
?>

<h1 class="page-header">Create WorkflowChangeNotice</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>