<script type="text/javascript">
$(document).ready(function(){
  var notice_type = $('#<?php echo CHtml::activeId($model,'notice_type')?>');
  var notice_sub_type = $('#<?php echo CHtml::activeId($model,'notice_sub_type')?>');
  notice_type.change(function(){
    if(notice_type.val() == 'CHANGE'){
      notice_sub_type.show();  
    }else{
      notice_sub_type.hide();   
    }
    requireDocs(notice_type.val(), '');   
  });
  notice_sub_type.change(function(){
    requireDocs(notice_type.val(), notice_sub_type.val());   
  });
  
   
});
function requireDocs(type, subtype){  
  var url = '<?php echo Yii::app()->createUrl("hr/workflowchangenotice/requiredocs?"); ?>' + 't='+ type + '&s=' + subtype; 
  $.get(url, function(response){
    var data = $.parseJSON(response);
    $('#attachment-section').html(data.form);
    for (i=0 ; i < data.doc_count ; i++){
      uploadifyFileField(data.doc[i]);
    }
  }); 
}     
</script>
<fieldset><legend>Change Type</legend>
 

<?php echo $form->dropDownListRow($model,'notice_type',WorkflowChangeNotice::getList(),array('empty'=>'- select -', 'class'=>'span5','maxlength'=>10)); ?>

<?php echo $form->dropDownListRow($model,'notice_sub_type',ZHtml::enumItem($model,'notice_sub_type'),array('empty'=>'- select -', 'class'=>'span5','maxlength'=>10)); ?>
</fieldset>
