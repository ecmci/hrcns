<?php
$this->breadcrumbs=array(
	'Tar Messagings'=>array('index'),
	'Manage',
);

$this->menu=array(
	//array('label'=>'List TarMessaging','url'=>array('index')),
	array('label'=>'New Message','url'=>array('create')),
);

Yii::app()->clientScript->registerCss('message-center-css',"
tr:hover{
  cursor:pointer;
}
");

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('tar-messaging-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1 class="page-header">Messaging Center</h1>

<?php //echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'tar-messaging-grid',
	'dataProvider'=>$model->getMessages(),
  'summaryText'=>'Displaying {start}-{end} of {count} messages.',
  'rowCssClassExpression'=>'$data->is_seen == "0" ? "warning" : "" ',
  'selectionChanged'=>'function(id){ location.href = "'.$this->createUrl('view').'/id/"+$.fn.yiiGridView.getSelection(id);}',
	'filter'=>$model,
	'columns'=>array(
		//'id',
		
    array(
      'name'=>'from_user_id',
      'value'=>'$data->sender->f_name',
      'filter'=>CHtml::activeDropDownList($model,'from_user_id',User::getList(),array('empty'=>''))
    ),
    /*
    array(
      'name'=>'message',
      'filter'=>false
    ),
    */
		array(
      'name'=>'seen_datetime',
      'value'=>'strtotime($data->seen_datetime) ? date("m/d/y h:i A",strtotime($data->seen_datetime)) : ""',
      'filter'=>false
    ),		
    array(
      'name'=>'timestamp',
      'value'=>'strtotime($data->timestamp) ? date("m/d/y h:i A",strtotime($data->timestamp)) : ""',
      'filter'=>false
    ),		
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
      'template'=>'{view} {reply}',
      'buttons'=>array(
        'reply'=>array(
          'label'=>'<span class="icon-share-alt"></span>',
          'url'=>'Yii::app()->createUrl("tar/message/create",array("t"=>$data->to_user_id))', 
        )
      ),
		),
	),
)); ?>
