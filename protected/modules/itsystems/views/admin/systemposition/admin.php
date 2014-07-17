<?php
$this->breadcrumbs=array(
	'System Positions'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List SystemPosition','url'=>array('index')),
	array('label'=>'Create SystemPosition','url'=>array('create')),
  array('label'=>'Dashboard','url'=>array('/itsystems/manage')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('system-position-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1 class="page-header">Manage System Positions</h1>

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
	'id'=>'system-position-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(		
		array(
      'name'=>'position_id',
      'value'=>'$data->position->name'
    ),
    array(
      'name'=>'system_id',
      'type'=>'raw',
      'value'=>'$data->getSystemNames()'
    ),		
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>
