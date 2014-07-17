<?php
$this->breadcrumbs=array(
	'Licenses'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'New License Form','url'=>array('create')),
);
Yii::app()->clientScript->registerCss('attch',"
.gamay{
  font-size: 12px;
}
");
Yii::app()->clientScript->registerScript('',"

",CClientScript::POS_READY);
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').slideToggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('license-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1 class="page-header">Manage Licenses</h1>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'license-grid',
  'type'=>'condensed',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
  'rowCssClassExpression'=>'$data->alert == "1" ? "alert alert-error" : ""',
	'columns'=>array(
		'id',
		array(
      'name'=>'emp_id',
      'value'=>'$data->emp->getFullName()',
    ),
		'name',
		'serial_number',
		array(
      'name'=>'date_of_expiration',
      'filter'=>false,
    ),
    array(
      'name'=>'date_issued',
      'filter'=>false,
    ),
		array(
      'name'=>'attachment',
      'type'=>'raw',
      'value'=>array($model,'printAttachments'),
      'filter'=>false,
      'htmlOptions'=>array('class'=>'gamay'),  
    ),
// 		array(
//       'name'=>'timestamp',
//       'filter'=>false,
//     ),
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>
