<?php
$this->breadcrumbs=array(
	'Sys Users'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Manage Users','url'=>array('admin')),
);
?>

<h1 class="page-header">Create User</h1>

<?php $this->renderPartial('_form',array(
  'model'=>$model,
  'model_req'=>$model_req,
  'model_hr'=>$model_hr,
) ); ?>
