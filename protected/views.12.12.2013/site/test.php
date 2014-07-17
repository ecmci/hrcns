<?php 
$baseUrl = Yii::app()->baseUrl;
$uploadsDir = Helper::getUploadsDir();
Yii::app()->clientScript->registerScriptFile($baseUrl.'/js/uploadify/jquery.uploadify.js');
Yii::app()->clientScript->registerScript('uploadify',"
$(document).ready(function(){
  $('.uploadify').each(function(){
    var elemId = this.id;
    $('#'+elemId).fileUpload({
      'uploader': '".$baseUrl."/images/uploadify/uploader.swf',
      'script': '".$baseUrl."/uploads/upload.php',
      'cancelImg': '".$baseUrl."/images/uploadify/cancel.png',
      'folder': '".$uploadsDir."',
      'scriptData': {'appendToFilename':this.id},
      'auto' : true,
      'onComplete': function(evnt, queueID, fileObj, response, data){
        var r = $.parseJSON(response);
        var elem = '#' + elemId + '_show';
        $(elem).val(r.newFilename);  
      },
      'onError' : function (a, b, c, d) {
              if (d.status == 404)
                  alert('Could not find upload script. Use a path relative to: '+'".(getcwd())."');
              else if (d.type === 'HTTP')
                 alert('error '+d.type+': '+d.status);
              else if (d.type ==='File Size')
                 alert(c.name+' '+d.type+' Limit: '+Math.round(d.sizeLimit/1024)+'KB');
              else
                 alert('error '+d.type+': '+d.text);
            },
    });   
  });  
});
",CClientScript::POS_READY); 
?>

<div>
  <input type="text" id="up1" class="uploadify"><input type="text" id="up1_show" ><br/>
  <input type="text" id="up2" class="uploadify"><input type="text" id="up2_show" ><br/>
  <input type="text" id="up3" class="uploadify"><input type="text" id="up3_show" ><br/>
</div>

<div>
  
</div>
