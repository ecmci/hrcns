<?php
$this->breadcrumbs=array(
	'Tar Logs'=>array('index'),
	$model->case_id=>array('view','id'=>$model->case_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List TarLog','url'=>array('index')),
	array('label'=>'Create TarLog','url'=>array('create')),
	array('label'=>'View TarLog','url'=>array('view','id'=>$model->case_id)),
	array('label'=>'Manage TarLog','url'=>array('admin')),
);
?>

<h1 class="page-header">Update TarLog <?php echo $model->case_id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>