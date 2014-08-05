<?php
$this->breadcrumbs=array(
	'Tar Messagings'=>array('index'),
	$model->id,
);

$this->menu=array(
	//array('label'=>'List TarMessaging','url'=>array('index')),
	array('label'=>'New Message','url'=>array('create')),
	array('label'=>'Reply','url'=>array('create','t'=>$model->to_user_id)),
	array('label'=>'Delete','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Back to Message Center','url'=>array('admin')),
);
?>

<h1 class="page-header">View TarMessaging #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		//'id',
		
    array(
      'name'=>'from_user_id',
      'value'=>$model->sender->f_name.' '.$model->sender->l_name,
      'filter'=>false,
    ),    

		
    array(
      'name'=>'message',
      'value'=>$model->message,
      'type'=>'raw',
    ),
		'is_seen:boolean',
		
    array(
      'name'=>'seen_datetime',
      'value'=>strtotime($model->seen_datetime) ? date("m/d/y h:i A",strtotime($model->seen_datetime)) : "",
    ),
		    
    array(
      'name'=>'timestamp',
      'value'=>strtotime($model->timestamp) ? date("m/d/y h:i A",strtotime($model->timestamp)) : "",
    ),
	),
)); ?>
