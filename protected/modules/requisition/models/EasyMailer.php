<?php


class EasyMailer extends CFormModel {
  public static $from = array('email'=>"payroll_inc@evacare.com",'name'=>'Pay Slip AutoMailer');
  public static $subject = "Pay Slip";
  public static $body = 
                  "Hello, \n\n
                  Please see attached pay slip file. Have a great day!\n\n                  
                  Eva Care Group Pay Slip Automailer\n
                  (Please do not reply to this email. Call 310-889-9929 for support)\n"
                  ;
  public static $smtp_servers = array(
      'evacare.com'=>array(
          'host'=>'smtp.1and1.com',
          'port'=>'25',
          'username'=>'itmanila@evacare.com',
          'password'=>'apZdtKym',
          'from'=>'steven.l@evacare.com',
          'to'=>'itmanila@evacare.com',
          'subject'=>'SMTP Healthcheck | Good | evacare.com',
          'body'=>'If you received this test email, it means smtp.1and1.com sending capability is good. This monitor runs every 1 hour.',
      ),
      'ecmci.com'=>array(
          'host'=>'mail.ecmci.com',
          'port'=>'587',
          'username'=>'itmanila@ecmci.com',
          'password'=>'qrxTdE4f',
          'from'=>'steven.l@ecmci.com',
          'to'=>'itmanila@evacare.com',
          'subject'=>'SMTP Healthcheck | Good | ecmci.com',
          'body'=>'If you received this test email, it means mail.ecmci.com sending capability is good. This monitor runs every 1 hour.',
      ),
      'eigshop.com'=>array(
          'host'=>'smtpout.secureserver.net',
          'port'=>'25',
          'username'=>'steven.l@eigshop.com',
          'password'=>'UwjM4x8S',
          'from'=>'steven.l@eigshop.com',
          'to'=>'itmanila@evacare.com',
          'subject'=>'SMTP Healthcheck | Good | eigshop.com',
          'body'=>'If you received this test email, it means smtpout.secureserver.net sending capability is good. This monitor runs every 1 hour.',
      ),
    );  
  
  private $folder = "/easymailer";
  private $basePath = "/kunden/homepages/11/d405480197/htdocs";
  
  
 
  public function run($args='') {
    $this->logError("Executing...");
    try{
      $files = $this->getFileList();
      //echo '<pre>';print_r($files);echo '</pre>';     
      $files = $this->parseFileList($files);
      //echo '<pre>';print_r($files);echo '</pre>';
	  //print_r($files);exit();	  
      foreach($files as $file){
        $this->sendFile($file);
      }      
    }catch(Exception $e){
      $msg = 'WatchFolderEmailerCommand Error: '.$e->getMessage();
      echo $msg."\n";
      $this->logError($msg);
    }
    $this->logError("Done.");
  }
  
  private function sendFile($file){
    try{
      $mailer = $this->getMailerObject();
      $mailer->AddAddress($file['email']);
      $path = $this->basePath.$this->folder.'/'; 

      //echo $path.$file['rawfilename'].'<br>';

       if(!$mailer->AddAttachment($path.$file['rawfilename'],$file['filename'].'.'.$file['extension'])){
         throw new Exception("Cannot attach file '".$file['rawfilename']."'");         
       }else{
         //$this->logError("Attached!");
       }
      if($mailer->Send()){
        $this->logError("Successfully emailed ".$file['rawfilename']." to ".$file['email']);
        $this->deleteFile($path.$file['rawfilename']);  
      }else{
        throw new Exception("Failed to email payslip to ".$file['email']);
      }
    }catch(Exception $e){
      $msg = 'WatchFolderEmailerCommand Error: '.$e->getMessage();
      echo $msg."\n";
      $this->logError($msg);
    }
  }
  
  private function deleteFile($file){
    try{
      unlink($file);
      return true;
    }catch(Exception $e){
      $msg = 'WatchFolderEmailerCommand Error: '.$e->getMessage();
      echo $msg."\n";
      $this->logError($msg);
      return false;
    }          
  }

  private function parseFileList2($theFiles){
    $parsedFiles = array();
    foreach($theFiles as $i=>$file){
      try{
        if($file != 'errors.txt'){
            if($this->isValidFile($file)){
              $parsedFiles[$i]['rawfilename'] = $file;
              $tmp = explode('-',$file);
              $parsedFiles[$i]['email'] = $tmp[0];
			  
              $parsedFiles[$i]['file'] = $tmp[1]; 
            }else{
              throw new Exception("Invalid filenaming convention for file '".$file."'");
            }             
        }     
      }catch(Exception $e){
        $msg = 'WatchFolderEmailerCommand Error: '.$e->getMessage();
        echo $msg."\n";
        $this->logError($msg);
      }
    }
    return $parsedFiles;  
  }
  
    /*
  * File must follow the convention: person@example.com-theactualfile.ext
  *
  */
  private function isValidFile($file){
     $valid = true;
    // check convention
    $tmp = explode('-',$file);
    $hasEmail = isset($tmp[0]) ? true : false;
    $hasFilename = isset($tmp[1]) ? true : false;
    
    //check email
    $validEmail = ($hasEmail and filter_var($tmp[0], FILTER_VALIDATE_EMAIL)) ? true : false;
    
    return $hasEmail and $hasFilename and $validEmail;
  }
  
  private function parseFileList($theFiles){
    $parsedFiles = array();
    foreach($theFiles as $i=>$file){
      try{
        if($file[$i] != 'errors'){
			$rawfilename = $file[0].'.'.$file[1];
            if($this->isValidFile($rawfilename)){
              $parsedFiles[$i]['filename'] = $file[0];
			  $parsedFiles[$i]['extension'] = $file[1];
			  $parsedFiles[$i]['rawfilename'] = $rawfilename;
              $tmp = explode('-',$rawfilename);
              $parsedFiles[$i]['email'] = $tmp[0];			  
              $parsedFiles[$i]['file'] = $tmp[1]; 
            }else{
              throw new Exception("Invalid filenaming convention for file '".$file."'");
            }             
        }     
      }catch(Exception $e){
        $msg = 'WatchFolderEmailerCommand Error: '.$e->getMessage();
        echo $msg."\n";
        $this->logError($msg);
      }
    }
    return $parsedFiles;  
  }
  
  private function getFileList(){
    $files = array();
    try{
      $path = $this->basePath.$this->folder.'/';
      //echo $path; exit();
      $files = CFileHelper::findFiles($path);
      foreach($files as $i=>$file){      
        //$filename = pathinfo($file, PATHINFO_FILENAME);
        //$extension = pathinfo($file, PATHINFO_EXTENSION);
        //$files[$i] = $filename.'.'.$extension;
		//$files[$i]['filename'] = $filename;
		//$files[$i]['extension'] = $extension;
		$data[0] = pathinfo($file, PATHINFO_FILENAME);
		$data[1] = pathinfo($file, PATHINFO_EXTENSION);
		$files[$i] = $data;
      } 
    }catch(Exception $e){
      $msg = 'WatchFolderEmailerCommand Error: '.$e->getMessage();
      echo $msg."\n";
      $this->logError($msg);
    }
    return $files;
  }
  
  private static function getMailerObject(){
      Yii::import('ext.jphpmailer.JPhpMailer');
      $mail = new JPhpMailer;
      $mail->IsSMTP();
      $mail->Mailer = "smtp";
      $mail->Host = self::$smtp_servers['evacare.com']['host'];
      $mail->Port = self::$smtp_servers['evacare.com']['port'];
      $mail->SMTPAuth = true;
      $mail->Username = self::$smtp_servers['evacare.com']['username'];
      $mail->Password = self::$smtp_servers['evacare.com']['password'];
      $mail->SetFrom(self::$from['email'], self::$from['name']);
      //$mail->AddAddress($server['to']);
      $mail->Subject = self::$subject;
      //$mail->IsHTML(true);
      $mail->Body = self::$body;
      $mail->Priority = '1';
      return $mail;
  }
  
  private function logError($msg){       
    //Yii::log($msg,'error','easymailer');
    $timestamp = date("r",time());
    //$timestamp = date(time());
    error_log($timestamp." ".$msg."\n", 3, $this->basePath.$this->folder.'/errors.txt');
  }
}

?>