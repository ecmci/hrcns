<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'notice-sign-form',
  //'type'=>'horizontal',
  'action'=>Yii::app()->createUrl('v2/notice/sign'),
  'method'=>'post',
  'htmlOptions' => array(
    'enctype' => 'multipart/form-data',
    'class'=>'well'
  ),
)); ?>
  <h3>What would you like to do?</h3>
	<div id="sign-error"></div>
  <div id="sign-form-section">
  <?php echo $form->hiddenField($notice,'decision',array('class'=>'span12')); ?>
  <?php if(Yii::app()->user->getState('hr_group') != 'BOM') echo $form->textAreaRow($notice,'comments',array('class'=>'span12')); ?>
  
  <?php if(Yii::app()->user->getState('hr_group') == 'BOM'): ?>
  <a id="" href="<?php echo Yii::app()->createUrl('v2/notice/edit',array('id'=>$notice->id)); ?>" class="btn btn-success btn-large btn-block">Review, Modify and Submit</a>
  <?php elseif(Yii::app()->user->getState('hr_group') == 'BOM'): ?>
  
  <?php else: ?>  
  <a id="btn-approve" href="#workflow-sign-form" class="btn btn-success btn-large btn-block">Approve</a>
  <a id="btn-route-back" href="#workflow-sign-form" class="btn btn-warning btn-large btn-block">Decline But Route Back To BOM</a>
  <?php endif; ?>
 

  <a id="btn-decline" href="#workflow-sign-form" class="btn btn-danger btn-large btn-block">Decline Completely</a>
  
  </div>
<?php $this->endWidget(); ?>

<?php  
Yii::app()->clientScript->registerScript('sign2-js-begin',"
function submitSignForm(){         
  var url = '".Yii::app()->createUrl('/v2/notice/sign/id/'.$notice->id)."';
  var form = $('#notice-sign-form');
  var params = $(form).serialize();
  $.post(url,params,function(response){
    var r = $.parseJSON(response);
    if(r.e == '0'){
      $('#sign-error').html('<p class=\"alert alert-success\">Signed</p>');
      $('#sign-form-section').fadeOut();
      alert('Signed');
      /* window.location = '".Yii::app()->createUrl('/v2/notice/review/id/'.$notice->id)."'; */
      window.location = '".Yii::app()->createUrl('/v2/notice')."'; 
    }else{
      $('#sign-error').html('<p class=\"alert alert-error\">Failed to sign the notice. Error: '+r.e+'</p>');
    }  
  });
  return false;  
}
",CClientScript::POS_BEGIN); 

Yii::app()->clientScript->registerScript('sign-js-ready',"
var comment = $('#".CHtml::activeId($notice,'comments')."');
var decision = $('#".CHtml::activeId($notice,'decision')."');
var sign_error = $('#sign-error');
$('#btn-approve').on('click',function(){
  if(confirm('You are about to approve this notice. Make sure all the information and attachments are correct. Are you sure?') ){
    $(decision).val('1');
    submitSignForm();
  }
});
$('#btn-route-back').on('click',function(){
  if(confirm('You are about to decline and route this notice back to BOM to correct the errors. Are you sure?') ){
    if($(comment).val().length == 0){
      $(sign_error).html('<p class=\"alert alert-error\">Comment is required.</p>');
    }else{
      $(decision).val('2');
      submitSignForm(); 
    }
  }
});
$('#btn-decline').on('click',function(){
  if(confirm('You are about to completely decline this notice. The review and approval process stops here. Are you sure?') ){
    if($(comment).val().length == 0){
      $(sign_error).html('<p class=\"alert alert-error\">Comment is required.</p>');
    }else{
      $(decision).val('0');
      submitSignForm(); 
    }
  }
});
",CClientScript::POS_READY); 
?>
