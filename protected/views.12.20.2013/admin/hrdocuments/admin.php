<?php
$this->breadcrumbs=array(
	'HR Notice Documents'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'Create HR Notice Required Document','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('hr-documents-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1 class="page-header">Manage HR Notice Required Documents</h1>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'hr-documents-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
    array(
      'name'=> 'notice_type',
      'filter'=>ZHtml::enumItem(new WorkflowChangeNotice,'notice_type'),
    ),
    array(
      'name'=> 'notice_sub_type',
      'filter'=>ZHtml::enumItem(new WorkflowChangeNotice,'notice_sub_type'),
    ),
		'document',
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>
