<?php
$mode = (isset($edit)) ? 'PUT' : 'POST';
$days = array();
for($i=1 ; $i <= 45; $i++){
  $days[$i] = $i;
}
Yii::app()->clientScript->registerCssFile(
	Yii::app()->clientScript->getCoreScriptUrl().
	'/jui/css/base/jquery-ui.css'
);
Yii::app()->clientScript->registerCoreScript('jquery.ui');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/tar-manage-alert-tpl.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/client.restful.js');
Yii::app()->clientScript->registerScript('tar-alert-tpl-form-ready-js',"
$('form#tar-alerts-tpl-form').submit(function(event){
  var url = '".(($mode==='POST') ? Yii::app()->createUrl('tar/manage/alerttemplates/rest') : Yii::app()->createUrl('tar/manage/alerttemplates/rest',array('id'=>$model->id)))."';
  var data = $(this).serialize();
  restConduit('$mode',url,data,
    function(data, textStatus, jqXHR){
      var id = data;
      if(textStatus === 'success'){
        alert('Saved.');
        window.location = '".Yii::app()->createUrl('tar/manage/alerttemplates/view?id=')."' + id;
      }  
    },
    function(jqXHR, textStatus, errorThrown){
      alert('Error ' + jqXHR.status + ': ' + errorThrown + '. ' + jqXHR.responseText); 
    });
  event.preventDefault();
});
",CClientScript::POS_READY);
?>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'tar-alerts-tpl-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'name',array('class'=>'span5','maxlength'=>45)); ?>
  
  <p>While the case is open...</p>
  
  <table class="table" id="table-alert">
    <tr>
      <th>When case is...</th>
      <th>And status is still...</th>
      <th>Send email to the following:</th>
      <th></th>
    </tr>
    <?php if(!empty($model->data_struct)): ?>
      <?php foreach($model->data_struct as $i=>$struct): ?> 
      <tr>
        <td><?php echo CHtml::dropDownList('TarAlertsTemplate[data_struct]['.$i.'][age]',$struct['age'],$days,array('class'=>'span6 datepicker'),$form); ?> day(s) old or more</td>
        <td><?php echo CHtml::dropDownList('TarAlertsTemplate[data_struct]['.$i.'][status]',$struct['status'],TarStatus::getList(),array('class'=>'span12'),$form); ?></td>
        <td>
          <ul id="data_struct_<?php echo $i; ?>_emails">
            <?php foreach($struct['email'] as $email): ?> 
            <li><input value="<?php echo $email;?>" name="TarAlertsTemplate[data_struct][<?php echo $i; ?>][email][]" type="text" class="span10"><a onclick="$(this).closest('li').remove();" href="#" class="btn btn-danger btn-mini"><span class="icon-remove"></span></a></li>
            <?php endforeach; ?>
          </ul>
          <p><a onclick="addEmail(<?php echo $i; ?>);" href="#" class="btn btn-info btn-mini"><span class="icon-plus"></span> Add Email</a></p>
        </td>
        <td><a onclick="$(this).closest('tr').remove();" href="#" class="btn btn-danger btn-mini"><span class="icon-remove"></span> Remove Alert</a></td>
      </tr>
      <?php endforeach; ?>
    <?php else: ?>
    <tr>
      <td><?php echo CHtml::dropDownList('TarAlertsTemplate[data_struct][0][age]','',$days,array('class'=>'span6 datepicker'),$form); ?> day(s) old or more</td>
      <td><?php echo CHtml::dropDownList('TarAlertsTemplate[data_struct][0][status]','',TarStatus::getList(),array('class'=>'span12'),$form); ?></td>
      <td>
        <ul id="data_struct_0_emails">
          <li><input name="TarAlertsTemplate[data_struct][0][email][]" type="text" class="span10"><a onclick="$(this).closest('li').remove();" href="#" class="btn btn-danger btn-mini"><span class="icon-remove"></span></a></li>
        </ul>
        <p><a onclick="addEmail(0);" href="#" class="btn btn-info btn-mini"><span class="icon-plus"></span> Add Email</a></p>
      </td>
      <td><a onclick="$(this).closest('tr').remove();" href="#" class="btn btn-danger btn-mini"><span class="icon-remove"></span> Remove Alert</a></td>
    </tr>
    <?php endif; ?>
  </table>

  <p><a onclick="addAlert();" href="#" class="btn btn-mini"><span class="icon-plus"></span> Add Alert</a></p>  

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'Save',
      'htmlOptions'=>array('class'=>'btn btn-primary btn-large'),
		)); ?>
    <?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'link',
			'label'=>'Cancel',
      'htmlOptions'=>array('class'=>'btn btn-mini','href'=>Yii::app()->createUrl('tar/manage/alerttemplates/admin')),
		)); ?>
	</div>

<?php $this->endWidget(); ?>
