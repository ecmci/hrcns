<?php
$this->breadcrumbs=array(
	'Requests'=>array('index'),
	'Process',
  ' / '.$model->id
);

$this->menu=array(
	array('label'=>'Manage Requests','url'=>array('admin')),
);

$cfgs = $model->parseConfiguration();

Yii::app()->clientScript->registerScript('dona',"
var cfgs_count = ".sizeof($cfgs).";
$('#data').hide();
$('#show-details').click(function(){
  $('#data').slideToggle('fast');
});
$('#add-cfg').click(function(){
  var row = '<tr id=\'row'+ cfgs_count +'\'><td><input name=\'Request[cfgs]['+ cfgs_count +'][property]\' type=\'text\' /></td><td><input name=\'Request[cfgs]['+ cfgs_count +'][value]\' type=\'text\' /></td><td><a onclick=\'removeCfg('+cfgs_count+')\' href=\'#\'>Remove</a></td></tr>';
  $('#cfgs  > tbody:last').append(row);
  cfgs_count++;  
});



",CClientScript::POS_READY);
Yii::app()->clientScript->registerScript('donako',"
function removeCfg(row){
  $('#row'+row).remove();
}
",CClientScript::POS_BEGIN);
?>

<h1 class="page-header">Process Account Request For: <small><?php echo $model->system->name; ?></small></h1>

<div id="data">
 <?php $this->renderPartial('_view',array('model'=>$model)); ?>
</div>

<?php echo CHtml::link('Details','#',array('id'=>'show-details')); ?>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'request-form',
  'type'=>'horizontal',
	'enableAjaxValidation'=>true,
  'clientOptions'=>array(
    'validateOnSubmit'=>true,
  ),
)); ?>
<?php echo $form->labelEx($model,'cfgs'); ?>
<table id="cfgs" class="table">
 <thead><tr><th>Property / Setting</th><th>Value</th></tr></thead>
 <tbody>  
  <?php $i = 0; foreach($cfgs as $key=>$cfg){ ?>
  <tr id="row<?php echo $i; ?>">
    <td><?php echo $form->textField($model,"cfgs[$i][property]",array('value'=>$key,'required'=>'required') ); ?></td><td><?php echo $form->textField($model,"cfgs[$i][value]",array('value'=>$cfg,'required'=>'required')); ?></td><td><a onclick='removeCfg(<?php echo $i; ?>)' href='#'>Remove</a><td></td>
  </tr>
  <?php $i++; } ?>
 </tbody>
</table>

<?php echo CHtml::link('Add Configuration','#',array('id'=>'add-cfg')); ?>
	<?php echo $form->textAreaRow($model,'note',array('rows'=>6, 'cols'=>25, 'class'=>'span8')); ?>

	<div class="form-actions">
		<?php echo $form->errorSummary($model); ?>
    <?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
      'size'=>'large',
			'label'=>$model->isNewRecord ? 'Submit' : 'Save',
		)); ?>
    <?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'link',
      'url'=>array('admin'),
			'label'=>'Cancel',
		)); ?>
	</div>

<?php $this->endWidget(); ?>