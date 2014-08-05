<?php

?>
<div class="row-fluid">
  <div class="span12">
    <p class="alert alert-error"><strong>
     The following documents are required to be attached along with this notice.
    </strong></p>
    <ol id="requiredAttachments">
      
    </ol>
    <div class="">
	<?php $this->widget('ext.dropzone.EDropzone', array(
		'model' => $notice,
		'attribute' => 'attachments',
		'url' => $this->createUrl('/v2/notice/upload'),
		'mimeTypes' => array('application/pdf', 'image/png','image/jpg'),
		'onSuccess' => 'dropzoneUploadComplete(file,response);',
		'options' => array(),
	)); ?>
	</div>
    <p><strong>
     You attached:
    </strong></p> 
    <ol id="uploadedAttachments">
      <?php 
      //$notice->attachments = array('TEST.pdf'=>'dfdsfdfsd.pdf'); 
      $aa = is_array($notice->attachments) ? $notice->attachments : array(); 
      $c = 0;
      foreach($aa as $k=>$a): ?>
      <li id="upload-<?php echo $c; ?>"><?php echo $k.' '.CHtml::activeHiddenField($notice,'attachments['.$k.']',array('value'=>$a)); ?> <small><a onclick="removeAttachment( 'upload-<?php echo $c; ?>','<?php echo $a; ?>' )" href="#upload-<?php echo $c; ?>">Remove</a></small></li>
      <?php $c++; endforeach; ?> 
    </ol>
  </div>
</div>
<?php
Yii::app()->clientScript->registerScript('attachments-js-ready',"
getRequiredAttachments();
$('#".CHtml::activeId($notice,'notice_type')."').on('change',getRequiredAttachments);
$('#".CHtml::activeId($notice,'notice_sub_type')."').on('change',getRequiredAttachments);

",CClientScript::POS_READY);
Yii::app()->clientScript->registerScript('attachments-js-begin',"
var countUploaded = ".$c.";
function getRequiredAttachments(){
  var a = $('#".CHtml::activeId($notice,'notice_type')."');
  var b = $('#".CHtml::activeId($notice,'notice_sub_type')."');
  var c = $('#requiredAttachments');
  var url = '".Yii::app()->createUrl('v2/notice/getrequiredattachments')."';
  var params = 'a='+ a.val() +'&b=' + b.val();
  $.get(url,params,function(res){
    c.html(res);        
  });
}
function dropzoneUploadComplete(file,response){
	var uploadedAttachments = $('#uploadedAttachments');
	var r = $.parseJSON(response);
	var linkId = 'uploaded-' + countUploaded;
	if(r.error == '0'){
		uploadedAttachments.append('<li id=\"'+ linkId +'\"><input name=\"Notice[attachments]['+ file.name +']\" value=\"'+ r.maldita +' \" type=\"hidden\" />'+ file.name +' <small> <a onclick=\"removeAttachment( \'' + linkId + '\',\'' + r.maldita + '\' )\" href=\"#'+ linkId +'\">Remove</a> </small></li>');
	}else{
		uploadedAttachments.append('<li>'+ file.name +' failed to attach: '+ r.error +'</li>');
	}
	countUploaded = countUploaded + 1;
}

function removeAttachment(id,file){
	if(confirm('Are you sure?')){
		$('#'+id).remove();
		var url = '".Yii::app()->baseUrl."/uploads/delete.php';
		$.post(url,'f='+file);
	}
}

",CClientScript::POS_BEGIN);
?>
