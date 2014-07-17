<?php
class Helper{
    public static function printEnumValue($value=''){
      return ucwords(strtolower(str_replace(array('_'),' ',$value)));  
    }
    
    public static function numberFormat($value,$currency='$'){
      return $currency.' '.$value;
    }
    
    public static function importUploadifyAssets(){
      $baseUrl = Yii::app()->baseUrl;
      Yii::app()->clientScript->registerCssFile($baseUrl.'/js/uploadify/uploadify.css');
      Yii::app()->clientScript->registerScriptFile($baseUrl.'/js/uploadify/jquery.uploadify.min.js');
  
    }                                                                
    
    public static function dateDiff($date1, $date2){
  		$diff = abs(strtotime($date1) - strtotime($date2));
  		$result['years'] = floor($diff / (365*60*60*24)); 
  		$result['months'] = floor(($diff - $result['years'] * 365*60*60*24) / (30*60*60*24)); 
  		$result['days'] = floor(($diff - $result['years'] * 365*60*60*24 - $result['months']*30*60*60*24)/ (60*60*24));
  		$result['hours'] = floor($diff/3600);
  		$result['mins'] = floor(($diff - $result['years'] * 365*60*60*24 - $result['months']*30*60*60*24 - $result['days']*60*60*24 - $result['hours']*60*60)/ 60);
  		return $result;
  	}
    
    public static function queueMail($to,$subject,$message){
      $queue = new EmailQueue;
      $queue->from = Yii::app()->params['mailerFrom'];  
      $queue->to = $to;
      $support_spiel = "<p></p><p>Need help? We'll be glad to assist you:</p>
                        <p>HR Phone:  ".Yii::app()->params['hrPhone']."</p>
                        <p>HR Email: ".Yii::app()->params['hrEmail']."</p>
                        <p>IT Phone:  ".Yii::app()->params['adminPhone']."</p>
                        <p>IT Email: ".Yii::app()->params['adminEmail']."</p>
                        <p></p><p>Regards,</p>
                        <p>".Yii::app()->name.'</p>';
      $queue->subject = $subject;
      $queue->message = $message.$support_spiel;
      $queue->save(false);  
    }  
    
    
    public static function displayErrorMessage($model){
      $form = new CActiveForm;
      echo $form->errorSummary($model,'Please review the following errors:','',array('class'=>'alert alert-error'));
    }
    
    public static function getDummyDataTable(){
      echo '<table class="table table-striped">';
        echo '<thead><tr><th>Col1</th><th>Col2</th><th>Col3</th></tr></thead>';
        echo '<tboady>';
        for($i=0 ; $i < 10 ; $i++) 
          echo "<tr><td>$i</td><td>$i</td><td>$i</td></tr>";
        echo '</tboady>';
      echo '</table>';  
    }
    
    public static function includeJui(){
      Yii::app()->clientScript->registerCoreScript('jquery.ui');
      Yii::app()->clientScript->registerCssFile(Yii::app()->clientScript->getCoreScriptUrl().'/jui/css/base/jquery-ui.css');
    }
    
    public static function renderDatepickers(){
      Yii::app()->clientScript->registerScript('datepickers',"
      $('.datepicker').datepicker({
        'dateFormat' : 'yy-mm-dd'
      });
            
      ",CClientScript::POS_READY);
    }
    
    public static function arrayToString($array=array()){
      return str_replace(array("{","}"), array("[","]"), json_encode($array));  
    }
    
    public static function compareAttributeDiff($array1, $array2)
    {
      $differences=array();
    
      foreach ($array1 as $key => $value)
      {
        if ($array2[$key] != $value)
        {
          $differences[$key] = $value;
        }
      }
    
      return $differences;
    }
    
    public static function cleanFilename($rawfilename){
      $illegal_chars = array(' ','#','`','~','!','@','#','$','%','^','&','*','(',')','+','\\',']','[','{','}',';',':','\"','\/','>','?');
      return str_replace($illegal_chars,'_',$rawfilename);
    }
    
    public static function generateFilename($emp_id, $rawfilename=''){
      $fname = self::cleanFilename($rawfilename);
      $salt = time();
      return "$emp_id-$salt-$fname";
    }
    
    public static function getUploadsDir(){
      return $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'hrcns/uploads';      
    }
    
    public static function getBaseUploadsUrl(){
      return Yii::app()->baseUrl.DIRECTORY_SEPARATOR.Yii::app()->params['uploads_url'].DIRECTORY_SEPARATOR;
    }
    
    public static function uploadifyFileFields(){
      $baseUrl = Yii::app()->baseUrl;
      $uploadsDir = Helper::getUploadsDir();
      Yii::app()->clientScript->registerScriptFile($baseUrl.'/js/uploadify/jquery.uploadify.js');
      Yii::app()->clientScript->registerScript('uploadify',"
         uploadifyFileFields();  
      ",CClientScript::POS_READY);
      
      Yii::app()->clientScript->registerScript('rem-file',"
        function removeFile(file,elemId){
          var url = '".$baseUrl."/uploads/delete.php';
          var params = 'f=' + file;
          $.post(url,params,function(response){
            console.log(response)
          });
          $('#'+elemId+'-remove').html('');
          $('#'+elemId).val('');
        }
        function uploadifyFileFields(){
          $('.uploadify').each(function(){          
          var elemId = this.id;
          $('#'+elemId).fileUpload({
              'uploader': '".$baseUrl."/images/uploadify/uploader.swf',
              'script': '".$baseUrl."/uploads/upload.php',
              'cancelImg': '".$baseUrl."/images/uploadify/cancel.png',
              'folder': '".self::getUploadsDir()."',
              'scriptData': {'appendToFilename':this.id},
              'auto' : true,
              'removeCompleted': true,
              'fileSizeLimit' : '100KB',
              'multi' : false,
              'onComplete': function(evnt, queueID, fileObj, response, data){
                var r = $.parseJSON(response);
                $('#' + r.elemId).val(r.newFilename);
                $('#'+r.elemId+'-remove').html('<a onclick=\"removeFile(\''+r.newFilename+'\',\''+r.elemId+'\')\" href=\"#\"><i class=\"icon-remove\"></i>Remove</a>');  
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
        }
        function uploadifyFileField(elemId){
          console.log('Uploadifying ' + elemId);
          $('#'+elemId).fileUpload({
              'uploader': '".$baseUrl."/images/uploadify/uploader.swf',
              'script': '".$baseUrl."/uploads/upload.php',
              'cancelImg': '".$baseUrl."/images/uploadify/cancel.png',
              'folder': '".$uploadsDir."',
              'scriptData': {'appendToFilename':elemId},
              'auto' : true,
              'removeCompleted': true,
              'fileSizeLimit' : '100KB',
              'multi' : false,
              'onComplete': function(evnt, queueID, fileObj, response, data){
                var r = $.parseJSON(response);
                
                $('#' + r.elemId).val(r.newFilename);
                $('#'+r.elemId+'-remove').html('<a onclick=\"removeFile(\''+r.newFilename+'\',\''+r.elemId+'\')\" href=\"#\"><i class=\"icon-remove\"></i>Remove</a>');  
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
        }
      ",CClientScript::POS_BEGIN);
    }
}
?>