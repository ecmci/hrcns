<?php
$this->breadcrumbs=array(
	'Hr Users'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List HrUser','url'=>array('index')),
	array('label'=>'Create HrUser','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('hr-user-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage HR Users</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'hr-user-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'user_id',
		array(
      'name'=>'user_id',
      'header'=>'User',
      'value'=>'$data->user->getFullName()',
      'filter'=>CHtml::activeDropDownList($model,'user_id',User::getList(),array('empty'=>'-ALL-')),
    ),
     array(
      'name'=>'group',
      'filter'=>CHtml::activeDropDownList($model,'group',ZHtml::enumItem($model,'group'),array('empty'=>'-ALL-')),
    ),
//     array(
//       'name'=>'facility_handled',
//       'type'=>'raw',
//       'filter'=>CHtml::activeDropDownList($model,'facility_handled_ids',Facility::getList(),array('empty'=>'-ALL-')),
//     ),
    array(
      'name'=>'can_override_routing',
      'value'=>'$data->can_override_routing == "1" ? "Yes" : "No"',
      'filter'=>CHtml::activeDropDownList($model,'can_override_routing',array('1'=>'Yes','0'=>'No'),array('empty'=>'-ALL-')),
    ),
    array(
      'name'=>'facility_handled',
      'type'=>'raw',
      'filter'=>false,
    ),
    array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>
