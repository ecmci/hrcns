<?php
$this->breadcrumbs=array(
	'Tar Logs'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List TarLog','url'=>array('index')),
	array('label'=>'Create TarLog','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('tar-log-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<div class="panel">
  <div class="panel-heading">
  Open Treatment Authorization Request Cases 
  </div>
  <div class="panel-body">
    <div class="row-fluid">
      <div class="span12">
      <?php $this->widget('bootstrap.widgets.TbGridView',array(
      	'id'=>'tar-log-grid',
        'summaryText'=>'Showing {start}-{end} of {count} Open Cases',
        'emptyText'=>'Good news! You have no open cases.',
        'htmlOptions'=>array('class'=>'table table-hover table-striped'),
      	'dataProvider'=>$model->getActiveCases(),
        'selectionChanged'=>'function(id){ location.href = "'.$this->createUrl('update').'/id/"+$.fn.yiiGridView.getSelection(id);}',
      	'filter'=>$model,
      	'columns'=>array(
      		
          array(
            'name'=>'case_id',
            'filter'=>CHtml::activeTextField($model,'case_id',array('class'=>'span12')),
          ),
          
          array(
            'name'=>'resident',
            'filter'=>CHtml::activeTextField($model,'resident',array('class'=>'span12')),
          ),
          
          array(
            'name'=>'control_num',
            'filter'=>CHtml::activeTextField($model,'control_num',array('class'=>'span12')),
          ),
          array(
            'name'=>'status_id',
            'value'=>'$data->status->name',
            'filter'=>CHtml::activeDropDownList($model,'status_id',TarStatus::getList(),array('empty'=>'All')),
          ),
          array(
            'name'=>'requested_dos_date_from',
            'filter'=>false
          ),
          array(
            'name'=>'age_in_days',
            'filter'=>false
          ),
          /*
      		'medical_num',
      		'dx_code',
      		'admit_date',
      		'type',
      		'requested_dos_date_thru',
      		'applied_date',
      		'denied_deferred_date',
      		'approved_modified_date',
      		'backbill_date',
      		'aging_amount',
      		'notes',
      		'is_closed',
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
      </div> 
    </div>
  </div>
</div> 
<?php
Yii::app()->clientScript->registerCss('tar-home-css',"
.table tbody:hover
{
        cursor: pointer;

}
"); 
?>
