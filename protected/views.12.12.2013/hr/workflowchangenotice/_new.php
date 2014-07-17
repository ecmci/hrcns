<?
Yii::app()->clientScript->registerScript('noticetype222',"
$('#".CHtml::activeId($employment,'date_of_termination')."').hide();
",CClientScript::POS_READY);

Yii::app()->clientScript->registerScript('noticetype345',"
$('#WorkflowChangeNotice_notice_type').change(function(){
  alert(this.value);
  
  if(this.value == 'CHANGE'){
    $('#WorkflowChangeNotice_notice_sub_type').toggle();
    $('#WorkflowChangeNotice_notice_sub_type').attr('required','required');    
  }else{
    $('#WorkflowChangeNotice_notice_sub_type').hide();    
    $('#WorkflowChangeNotice_notice_sub_type').removeAttr('required');
    requireDocs(this.value, '');
  }
  
  if(this.value == 'TERMINATED'){
    $('#".CHtml::activeId($employment,'date_of_termination')."').show();
  }else{
    $('#".CHtml::activeId($employment,'date_of_termination')."').hide();
  }
});
$('#WorkflowChangeNotice_notice_sub_type').change(function(){
  
  var type = $('#WorkflowChangeNotice_notice_type').val();
  if(type == 'CHANGE'){
    requireDocs(type, this.value);    
  }
});

function requireDocs(type, subtype){
  $('#docs-loader').fadeIn('fast');
  $('#tab5').html('');
  var url = '".Yii::app()->createUrl('hr/workflowchangenotice/requiredocs')."' + '?t='+ type +'&s=' + subtype;
  $.get(url, function(response){
    var data = $.parseJSON(response);
    $('#attachment-section').html(data.form);
    $('#docs-loader').fadeOut('fast');
    for (i=0 ; i < data.doc_count ; i++){
      uploadifyFileField(data.doc[i]);
    }
  });
}
",CClientScript::POS_READY);
?>
<fieldset><legend>Change Type</legend>
 

<?php echo $form->dropDownListRow($model,'notice_type',WorkflowChangeNotice::getList(),array('empty'=>'- select -', 'class'=>'span5','maxlength'=>10)); ?>

<?php echo $form->dropDownListRow($model,'notice_sub_type',ZHtml::enumItem($model,'notice_sub_type'),array('empty'=>'- select -', 'class'=>'span5','maxlength'=>10)); ?>
</fieldset>
