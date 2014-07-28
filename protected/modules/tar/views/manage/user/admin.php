<?php
$this->breadcrumbs=array(
	'Tar Users'=>array('index'),
	'Manage',
);

$this->menu=array(
	//array('label'=>'List TarUser','url'=>array('index')),
	array('label'=>'New TAR User','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('tar-user-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1 class="page-header">Manage TAR Users</h1>

<?php //echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'tar-user-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array(
      'name'=>'id',
      'value'=>'$data->getFullName()',
      'filter'=>CHtml::activeDropDownList($model,'id',User::getList(),array('empty'=>''))
    ),
    array(
      'name'=>'is_active',
      'value'=>'$data->is_active=="1" ? "Yes" : "No"',
      'filter'=>CHtml::activeDropDownList($model,'is_active',array('1'=>'Yes','0'=>'No'),array('empty'=>''))
    ),
		array(
      'name'=>'group_id',
      'value'=>'$data->group->name',
      'filter'=>CHtml::activeDropDownList($model,'group_id',TarGroup::getList(),array('empty'=>''))
    ),
    array(
      'name'=>'facilities_handled',
      'value'=>'$data->getHandledFacilities()',
      //'filter'=>CHtml::activeDropDownList($model,'facilities_handled',Facility::getList(),array('empty'=>''))
      'filter'=>false,
    ),
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
      //'template'=>"{view}{update}",
		),
	),
)); ?>
