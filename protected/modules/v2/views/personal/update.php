<?php
$this->breadcrumbs=array(
	'Personals'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Personal','url'=>array('index')),
	array('label'=>'Create Personal','url'=>array('create')),
	array('label'=>'View Personal','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage Personal','url'=>array('admin')),
);
?>

<h1 class="page-header">Update Personal <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>