<?php
$this->breadcrumbs=array(
	'Tar Users'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	//array('label'=>'List TarUser','url'=>array('index')),
	array('label'=>'New TAR User','url'=>array('create')),
	//array('label'=>'View TarUser','url'=>array('view','id'=>$model->id)),
	array('label'=>'Back to User List','url'=>array('admin')),
);
?>

<h1 class="page-header">Update TarUser <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>