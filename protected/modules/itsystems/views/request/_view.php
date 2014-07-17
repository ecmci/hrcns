<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
    'type',
		array(
      'name'=>'employee_id',
      'value'=>$model->employee->getFullName(),
    ),
		
    array(
      'name'=>'system_id',
      'value'=>$model->system->name,
    ),
		
    array(
      'name'=>'configurations',
      'type'=>'raw',
      'value'=>$model->printConfiguration(),
    ),
		'active:boolean',
		
    array(
      'name'=>'activated_by',
      'value'=>($model->activatedBy) ? $model->activatedBy->getFullName() : '',
    ),
		array(
      'name'=>'deactivated_by',
      'value'=>($model->deactivatedBy) ? $model->deactivatedBy->getFullName() : '',
    ),
		'activated_timestamp',
		'deactivated_timestamp',
		array(
      'name'=>'notes',
      'type'=>'raw',
      'value'=>$model->printNotes(),
    ),
    'timestamp'
	),
)); ?>