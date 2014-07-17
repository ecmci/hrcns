<style type="text/css">
.anim-saving-bkgrnd{
	background: url('/images/saving.gif') 50% 50% no-repeat;	
}
</style>

<?php
Yii::app()->clientScript->registerScript('',"
function saveNote(id,stage){
  var url = '".Yii::app()->createUrl('/requisition/requisition/postsavenote')."';
  var params = 'id='+id+'&stage='+stage+'&note='+$('#'+stage+'note').val();
  $('#'+stage+'note').addClass('anim-saving-bkgrnd');
	$('#'+stage+'note').attr('disabled','disabled');
	$.post(url,params,function(data){
		var jsonObj = $.parseJSON(data);			
		if(jsonObj.error == '1'){
			$('#'+stage+'note').removeClass('anim-saving-bkgrnd');
			$('#'+stage+'note').removeAttr('disabled','disabled');
			alert(jsonObj.msg);			
		}else{
			$('#'+stage+'note').removeClass('anim-saving-bkgrnd');
			$('#'+stage+'note').val(jsonObj.msg);
			$('#'+stage+'note').removeAttr('disabled','disabled');
			alert('Note saved.');
			location.reload();
		}
	});
}
",CClientScript::POS_HEAD);
?>