<?php
$this->breadcrumbs=array(
	'Workflow Change Notices'=>array('index'),
	'Manage',
);

$this->menu=array(
// 	array('label'=>'List WorkflowChangeNotice','url'=>array('index')),
// 	array('label'=>'Create WorkflowChangeNotice','url'=>array('create')),
    array('label'=>'New Change Notice Form','url'=>array('newforemployee'),'icon'=>'icon-plus'),
    //array('label'=>'Print Preview','url'=>'#','icon'=>'icon-print','linkOptions'=>array('id'=>'print-preview')),  
);

Yii::app()->clientScript->registerScript('search-gien', "
$('.search-form').show();
", CClientScript::POS_READY);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('workflow-change-notice-grid', {
		data: $(this).serialize()
	});
  window.location = '#result';
	return false;
});
$('#btn-print-preview').click(function(){
   var params = $('#search-change-notice').serialize();
   window.open('".Yii::app()->createAbsoluteUrl('hr/workflowchangenotice/printreport/')."?' + params);
   return false;
});
");
?>

<h1 class="page-header">Research Change Notice Requests</h1>

<?php //echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search_less',array(
	'model'=>$model,
)); ?>  
</div><!-- search-form -->

<div id="result">
<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'workflow-change-notice-grid',
	'dataProvider'=>$model->getActiveRequests(),
	'filter'=>$model,
  'type'=>array('condensed','hover'),
	'columns'=>array(
		'id',
    array(
      'name'=>'facility',
      'filter'=>CHtml::activeDropDownList($model,'facility',Facility::getList(),array('empty'=>'ALL')),
    ),
//     array(
//       'name'=>'employee',
//       'filter'=>CHtml::activeDropDownList($model,'employee',Employee::getList(),array('empty'=>'ALL')),      
//     ),                                                              
//     array(
//       'name'=>'position',
//       'filter'=>CHtml::activeDropDownList($model,'position',Position::getList(),array('empty'=>'ALL')),
//     ),
    array(
      'name'=>'status',
      'value'=>'Helper::printEnumValue($data->status)',
      'filter'=>CHtml::activeDropDownList($model,'status',ZHtml::enumItem($model,'status'),array('name'=>'WorkflowChangeNotice[status][]', 'empty'=>'ALL')),
    ),
    array(
      'name'=>'notice_type',
      'value'=>'Helper::printEnumValue($data->notice_type)',
      'filter'=>CHtml::activeDropDownList($model,'notice_type',ZHtml::enumItem($model,'notice_type'),array('empty'=>'ALL')),
    ),
    array(
      'name'=>'notice_sub_type',
      'value'=>'Helper::printEnumValue($data->notice_sub_type)',
      'filter'=>CHtml::activeDropDownList($model,'notice_sub_type',ZHtml::enumItem($model,'notice_sub_type'),array('empty'=>'ALL')),
    ),
    array(
      'name'=>'processing_group',
      'value'=>'Helper::printEnumValue($data->processing_group)',
      'filter'=>CHtml::activeDropDownList($model,'processing_group',ZHtml::enumItem($model,'processing_group'),array('empty'=>'ALL')),
    ),
    array(
      'name'=>'effective_date',
      'filter'=>false,
    ),
    /*
    array(
      'name'=>'comments',
      //'type'=>'raw',
      'filter'=>false,
    ),
    */
    array(
			'header'=>'Actions',
      'value'=>array($this,'renderActionColumn'),
		),
	),
)); ?>

</div>
