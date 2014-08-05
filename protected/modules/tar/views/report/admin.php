<?php

$this->layout = "//layouts/column1";

$this->breadcrumbs=array(
	'Tar Logs'=>array('/tar/log'),
	'Manage',
);

$this->menu=array(
	//array('label'=>'List TarLog','url'=>array('index')),
	array('label'=>'<span class="icon-download-alt"></span> Download','url'=>array('#')),
);

Yii::app()->clientScript->registerCss('search-css', "
table.table{
  font-size:0.85em;
}
.table tr td{
  cursor:pointer;
}
");
Yii::app()->clientScript->registerCoreScript('jquery.ui');
Yii::app()->clientScript->registerCssFile(Yii::app()->clientScript->getCoreScriptUrl().'/jui/css/base/jquery-ui.css');
Yii::app()->clientScript->registerScript('search-ready-js', "
$('.search-form').show();
$('.datepicker').datepicker({
  changeYear:true,
  changeMonth:true,
});
",CClientScript::POS_READY);
Yii::app()->clientScript->registerScript('search-js', "
$('.download-button').on('click',function() {
  window.location = '".$this->createUrl('export')."?' + $('.search-form form').serialize();
});
$('.search-button').click(function(){
	$('.search-form').slideToggle();
	return false;
});
$('.search-form form').submit(function(){
  $('.search-form').slideToggle();
  $.fn.yiiGridView.update('tar-log-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1 class="page-header">TAR Report</h1>

<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php echo CHtml::link('Report Maker','#',array('class'=>'search-button btn')); ?>&nbsp;
<?php echo CHtml::link('Export To Excel','#',array('class'=>'download-button btn')); ?>

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'tar-log-grid',
	'dataProvider'=>$model->search(),
  'summaryText'=>'{start}-{end} of {count} TAR Cases',
	'itemsCssClass'=>'table table-condensed table-hover',
  'selectionChanged'=>'function(id){ window.open("'.$this->createUrl('/tar/log/update?id=').'" + $.fn.yiiGridView.getSelection(id));}',
	'columns'=>array(
		'resident',
    'admit_date',
    'medical_num',
    'control_num',
    'requested_dos_date_from',
    'requested_dos_date_thru',
    'applied_date',
    array(
      'name'=>'status_id',
      'value'=>'$data->status->name',
    ),
    'approved_modified_date',
    'denied_deferred_date',
    'backbill_date',
    'aging_amount',
    array(
      'name'=>'facility_id',
      'value'=>'$data->facility->acronym',
    ),
    'notes',
    'is_closed:boolean',
    'condition',
    'age_in_days'
    /*
    'case_id',
		'dx_code',
		'type',
		'applied_date',
		
		'reason_for_closing',
		'created_timestamp',
		'approved_care_id',
		'created_by_user_id',
		'facility_id',
		'resident_status',
		
		
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
    */
	),
)); ?>
<div class="clear">&nbsp;</div>
<div class="clear">&nbsp;</div>
