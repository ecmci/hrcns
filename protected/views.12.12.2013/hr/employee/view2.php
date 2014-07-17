<?php
$this->breadcrumbs=array(
	'Employees'=>array('index'),
	$model->emp_id,
);

Yii::app()->clientScript->registerScript('load-licenses',"
$('#licenses').load('".Yii::app()->createAbsoluteUrl('license/license/apilist?e=').$model->emp_id."');
",CClientScript::POS_READY);

$this->menu=array(
    array('label'=>'Change Notice'),
    array('label'=>'New Change Notice Form','url'=>array('hr/workflowchangenotice/new','id'=>$model->emp_id)),
    array('label'=>'Employee Management'),
    array('label'=>'List Employees','url'=>array('hr/employee/')),
);

?>

<?php
 $this->renderPartial('_view',array(
  'model'=>$model,
  
 ));
?>
                           
