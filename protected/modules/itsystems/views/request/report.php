<?php
 $this->layout = '//layouts/print_preview';
 $this->pageTitle = 'IT Systems Requests Report';
 Yii::app()->clientScript->registerCss('itsystems-report-style',"
 .filters{ display:none; }
 .table { font-size:8pt; } 
 ");  
?>

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'request-grid',
  'type'=>'condensed bordered',
  'enableSorting'=>false,
  'enablePagination'=>false,
	'dataProvider'=>$model->search(10000),
	'filter'=>$model,
  'summaryText'=>'Showing {start} - {end} of {count} Requests',
	'columns'=>array(
		array(
      'name'=>'id',
      'filter'=>false
    ),
    'active:boolean',
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
		 array(
      'name'=>'notes',
      'type'=>'raw',
      'value'=>'$data->printNotes()',
      'filter'=>false
    ),
    array(
      'name'=>'activated_by',
      'value'=>'($data->activatedBy) ? $data->activatedBy->getFullName() : ""',
      'filter'=>false
    ),
    array(
      'name'=>'activated_timestamp',
      'filter'=>false
    ),
    array(
      'name'=>'deactivated_by',
      'value'=>'($data->deactivatedBy) ? $data->deactivatedBy->getFullName() : ""',
      'filter'=>false
    ),
    array(
      'name'=>'deactivated_timestamp',
      'filter'=>false
    ),
     array(
      'name'=>'timestamp',
      'filter'=>false
    ),	

	),
)); ?>