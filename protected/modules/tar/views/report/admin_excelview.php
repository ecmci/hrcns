<?php
$this->layout = "//layouts/column1";

Yii::import('ext.EExcelView.EExcelView'); 

?>

<?php $this->widget('EExcelView',array(
	'id'=>'tar-log-grid',
  'grid_mode'=>'export',
  'title'=>'TAR Report',
  'libPath'=>'ext.PHPExcel.Classes.PHPExcel',
	'dataProvider'=>$model->search(),
  'summaryText'=>'{start}-{end} of {count} TAR Cases',
	'itemsCssClass'=>'table table-condensed table-striped table-bordered',
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
    /*
    'case_id',
		'dx_code',
		'type',
		'applied_date',
		'is_closed',
		'reason_for_closing',
		'created_timestamp',
		'approved_care_id',
		'created_by_user_id',
		'facility_id',
		'resident_status',
		'condition',
		
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
    */
	),
)); ?>