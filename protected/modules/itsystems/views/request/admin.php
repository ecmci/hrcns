<?php
$this->breadcrumbs=array(
	'Requests'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'New Systems Account Request Form','url'=>array('create')),
  array('label'=>'Manage This Module','url'=>array('/itsystems/manage')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').slideToggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('request-grid', {
		data: $(this).serialize()
	});
	return false;
});
");

Yii::app()->clientScript->registerCss('admin-itsystems-style',"
.filters{
  display:none;
}
");
?>

<h1 class="page-header">Systems Account Requests</h1>

<?php echo CHtml::link('Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<div id="flash-message" style="display:none;">
 
</div>

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'request-grid',
  'type'=>'condensed',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
  'emptyText'=>'There are no active requests this time. Click the "Search" button above to research requests.',
  'rowCssClassExpression'=>'$data->requested >= Request::$FLAG_DAYS ? "alert alert-error" : ""',
  'summaryText'=>'Showing {start} - {end} of {count} Requests',
	'columns'=>array(
		array(
      'name'=>'id',
      'filter'=>false
    ),
    
		array(
      'name'=>'employee_id',
      'value'=>'$data->employee->getFullName()',
      'filter'=>false
    ),
    
    array(
      'name'=>'status',
      'filter'=>false
    ),
    
     array(
      'name'=>'type',
      'filter'=>false
    ),
    array(
      'name'=>'system_id',
      'value'=>'$data->system->name',
      'filter'=>false,
    ),		
// 		 array(
//       'name'=>'notes',
//       'filter'=>false
//     ),
     array(
      'name'=>'timestamp',
      'value'=>'$data->getDays()',
      'filter'=>false
    ),		
		array(
			'class'=>'RequestCButtonColumn',
      'header'=>'Actions'
		),
	),
)); ?>

