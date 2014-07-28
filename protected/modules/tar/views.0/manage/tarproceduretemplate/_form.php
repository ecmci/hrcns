<?php
 $mode = (isset($edit)) ? 'PUT' : 'POST';
 Yii::app()->clientScript->registerCss('tar-procedure-tpl-form-css',"
 textarea{
  min-height:150px !important;
 }
 ");
 Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/tar-manage-procedure-tpl.js');
 Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/client.restful.js');
 Yii::app()->clientScript->registerScript('tar-procedure-tpl-form-ready-js',"
 $( 'form#tar-procedure-tpl-form' ).submit(function( event ) {
    var url = '".(($mode==='POST') ? Yii::app()->createUrl('tar/manage/tarproceduretemplate/rest') : Yii::app()->createUrl('tar/manage/tarproceduretemplate/rest',array('id'=>$model->id)))."';
    var data = $(this).serialize();
    restConduit('$mode',url,data,
    function(data, textStatus, jqXHR){
      var id = data;
      if(textStatus === 'success'){
        alert('Saved.');
        window.location = '".Yii::app()->createUrl('tar/manage/tarproceduretemplate/view?id=')."' + id;
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
	'id'=>'tar-procedure-tpl-form',
	'enableAjaxValidation'=>true,
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'name',array('class'=>'span5','maxlength'=>45)); ?>
  
  <table class="table" id="table-procedure">
    <tr>
      <th>Name</th>
      <th>Instruction</th>
      <th>Checklists</th>
      <th></th>
    </tr>
    <?php if(!empty($model->data_struct)): ?>
    <?php foreach($model->data_struct as $key=>$proc): //print_r($proc); exit(); ?>
    <tr id="proc<?php echo $key; ?>">
      <td><input value="<?php echo $proc['name']; ?>" type="text" class="span12" name="TarProcedureTemplate[data_struct][<?php echo $key; ?>][name]"></td>
      <td><textarea class="span12" name="TarProcedureTemplate[data_struct][<?php echo $key; ?>][instruction]"><?php echo $proc['instruction']; ?></textarea></td>
      <td id="checklist<?php echo $key; ?>">
        <small>Define the things to be done for this procedure.</small><br/><br/>
        <ol id="data_struct_<?php echo $key; ?>_checklist">
          <?php foreach($proc['checklists'] as $c): ?>
          <li><input value="<?php echo $c; ?>" name="TarProcedureTemplate[data_struct][<?php echo $key; ?>][checklists][]" class="span10" type="text"><a class="btn btn-danger btn-mini" href="#" onclick="$(this).closest('li').remove();"><span class="icon-remove"></span></a></li>        
          <?php endforeach; ?>
        </ol>
        <a onclick="addChecklist(<?php echo $key; ?>);" href="#" class="btn btn-mini btn-info"><span class="icon-plus"></span> Add Checklist</a>
      </td>
      <td><a class="btn btn-danger btn-mini" href="#" onclick="$(this).closest('tr').remove();"><span class="icon-remove"></span> Remove Procedure</a></td>
    </tr>
    <?php endforeach; ?>
    <?php else: ?>
    <tr id="proc0">
      <td><input type="text" class="span12" name="TarProcedureTemplate[data_struct][0][name]"></td>
      <td><textarea class="span12" name="TarProcedureTemplate[data_struct][0][instruction]"></textarea></td>
      <td id="checklist0">
        <small>Define the things to be done for this procedure.</small><br/><br/>
        <ol id="data_struct_0_checklist">
          <li><input name="TarProcedureTemplate[data_struct][0][checklists][]" class="span10" type="text"><a class="btn btn-danger btn-mini" href="#" onclick="$(this).closest('li').remove();"><span class="icon-remove"></span></a></li>        
        </ol>
        <a onclick="addChecklist(0);" href="#" class="btn btn-mini btn-info"><span class="icon-plus"></span> Add Checklist</a>
      </td>
      <td></td>
    </tr>
    <?php endif; ?>
    
  </table>
  <a onclick="addProcedure()" href="#" class="btn btn-mini"><span class="icon-plus"></span> Add Procedure</a>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
      'htmlOptions'=>array(
        'class'=>'btn btn-primary btn-large',
      ),
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
    <?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'link',
			'type'=>'',
      'htmlOptions'=>array(
        'class'=>'btn btn-mini',
        'href'=>Yii::app()->createUrl('tar/manage/tarproceduretemplate/admin'),
      ),
			'label'=>'Cancel',
		)); ?>
	</div>

<?php $this->endWidget(); ?>


