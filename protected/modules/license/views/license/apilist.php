<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'license-grid',
  'type'=>'condensed',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
  'rowCssClassExpression'=>'$data->alert == "1" ? "alert alert-error" : ""',
  'enableSorting'=>false,
  'summaryText'=>'',
	'columns'=>array(
    array(
      'name'=>'name',
      'filter'=>false,
    ),
    array(
      'name'=>'serial_number',
      'filter'=>false,
    ),
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
    ),
		array(
			'header'=>'',
      'type'=>'raw',
      'value'=>'CHtml::link("Update",Yii::app()->createUrl("/license/license/update/id/".$data->id) )',
		),
	),
)); ?>
