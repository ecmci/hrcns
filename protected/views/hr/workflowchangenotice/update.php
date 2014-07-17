<?php
$this->breadcrumbs=array(
	'Workflow Change Notices'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List WorkflowChangeNotice','url'=>array('index')),
	array('label'=>'Create WorkflowChangeNotice','url'=>array('create')),
	array('label'=>'View WorkflowChangeNotice','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage WorkflowChangeNotice','url'=>array('admin')),
);
?>

<h1 class="page-header">Update WorkflowChangeNotice <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>