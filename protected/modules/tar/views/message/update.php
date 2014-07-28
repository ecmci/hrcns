<?php
$this->breadcrumbs=array(
	'Tar Messagings'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List TarMessaging','url'=>array('index')),
	array('label'=>'Create TarMessaging','url'=>array('create')),
	array('label'=>'View TarMessaging','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage TarMessaging','url'=>array('admin')),
);
?>

<h1 class="page-header">Update TarMessaging <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>