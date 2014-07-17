<?php
Yii::import('application.models.hr._base.WorkflowChangeNotice0');

class WorkflowChangeNotice extends WorkflowChangeNotice0 {
 
  public function getStatus(){
	  if($this->status != 'WAITING') return $this->status;
	  $status = '';
	  $group = '';
	  switch($this->processing_group){
		case 'BOM':  
			$status = ucfirst(strtolower($this->status));
			$group = 'Business Office Manager';
		break;
		case 'FAC_ADM':  
			$status = ucfirst(strtolower($this->status));
			$group = 'Facility Administrator';
		break;
		case 'MNL':  
			$status = ucfirst(strtolower($this->status));
			$group = 'AR Manila';
		break;
		case 'CORP':  
			$status = ucfirst(strtolower($this->status));
			$group = 'HR Corporate';
		break;
	  }
	  return '<p class="alert alert-info">'.$status.' on '.$group.'</p>';
  }
  
  public function retrieveComment(){
    $comment = '';
    switch($this->processing_group){
      case 'BOM' : 
        $comment = $this->comment_bom;     
      break;
      case 'FAC_ADM' : 
        $comment = $this->comment_fac_adm;
      break;
      case 'MNL' : 
        $comment = $this->comment_mnl;
      break;
      case 'CORP' : 
        $comment = $this->comment_corp;
      break;
    } 
    $comment = explode('|',$comment); 
    return isset($comment[0]) ? $comment[0] : '';
  }
  
  public static function getLastRates($emp_id){
    $data = EmployeePayroll::model()->find(array(
      'select'=>'rate_proposed, rate_recommended, rate_approved, timestamp',
      'condition'=>"emp_id='$emp_id' AND is_approved = '1'",
      'order'=>'timestamp desc',
    ));
    return $data;
  }
  
  public static function model($className=__CLASS__) {
		return parent::model($className);
	}
  
  public function setAttachments(){
    if(empty($this->docs)) return true;
    foreach($this->docs as $key=>$docname){
      $this->docs[$key] = $_POST['WorkflowChangeNotice']['docs'][$key];     
    }
  }
  
  public function returnToBOM(){
    return $this->status == WorkflowChangeNotice::$WAITING and $this->processing_group == 'BOM'; 
  }
  
  public function saveAttachments(){
    if(empty($this->docs)) return true; 
    $documents = array();
    foreach($this->docs as $key=>$doc){      
      $documents[$key] = $doc;
    }
    $attach = ($this->processing_group == 'CORP') ? unserialize($this->attachments) : array();
    $this->attachments = serialize(array_merge($documents,$attach));
    //echo '<pre>'; print_r($this->attachments); echo '</pre>'; exit(); 
  }
  
  public function retrieveAttachments(){
    $data = WorkflowChangeNotice::parseAttachments($this->attachments);
    foreach($data as $datum){
      $name = $datum['pretty'];
      $doc = $datum['raw'];
      $this->docs[$name]=$doc;
    }
  }
  
  public static function parseAttachments($attachments){   
    if(empty($attachments))  return array();
    $files = unserialize($attachments); 
    $data = array();
    $i = 0;
    foreach($files as $key=>$file){
      $data[$i]['raw'] = $file;
      $data[$i]['pretty'] = $key;
      $i++; 
    } 
    return $data;  
  }
  
              
  public function rules()
	{
		return array(
			array('comment','required','on'=>'override2'),
			//array('status','validateOverride2','on'=>'override2'),
			
			array('effective_date','required','on'=>'attach, new'),
      
      //corp
      array('docs','validateCorp'),    
      
      //create
      array('initiated_by, profile_id, personal_profile_id, employment_profile_id , payroll_profile_id, notice_type, status, processing_group','required','on'=>'create'),
         
      //sign
      array('comment, decision, attachment','safe','on'=>'sign'), 
      array('decision', 'validateDecision', 'on'=>'sign'),
      array('comment','validateComment', 'on'=>'sign'),
      

      //new
      array('notice_type','required','on'=>'new'),
      array('reason','required','on'=>'new'),
      array('reason','validateReason','on'=>'new'),
      array('notice_sub_type','validateSubType','on'=>'new'),  

      // ovveride
      array('status, processing_group, decision, comment','required','on'=>'override'),
      array('status, processing_group, decision, comment','safe','on'=>'override'),
      array('status', 'validateStatus', 'on'=>'override'),
      
      //attach
      array('docs', 'validateDocs', 'on'=>'attach, new'),
                                     
			//array('initiated_by, processing_user, profile_id, personal_profile_id, employment_profile_id, payroll_profile_id, bom_id, fac_adm_id, mnl_id, corp_id, decision_bom, decision_fac_adm, decision_mnl, decision_corp', 'numerical', 'integerOnly'=>true),
			//array('notice_type', 'length', 'max'=>10),
			//array('status', 'length', 'max'=>10),
			//array('processing_group', 'length', 'max'=>7),
			//array('attachment_bom, attachment_fac_adm, attachment_mnl, attachment_corp', 'length', 'max'=>128),
			array('comment, reason_other, docs', 'safe'),

			array('effective_from, effective_to, facility, position, employee, id, initiated_by, notice_type, notice_sub_type, reason ,status, processing_group, processing_user, profile_id, personal_profile_id, employment_profile_id, payroll_profile_id, bom_id, fac_adm_id, mnl_id, corp_id, timestamp_bom_signed, timestamp_fac_adm_signed, timestamp_mnl_signed, timestamp_corp_signed, decision_bom, decision_fac_adm, decision_mnl, decision_corp, comment_bom, comment_fac_adm, comment_mnl, comment_corp, attachment_bom, attachment_fac_adm, attachment_mnl, attachment_corp, timestamp', 'safe', 'on'=>'search'),
		);
	}
	
  public function validateOverride2(){
      if($this->processing_group == 'BOM' and $this->status != 'WAITING'){
          $this->addError('status','Status must be set to WAITING.');
      }
  }
  
  public function validateCorp(){
    if($this->processing_group == 'CORP' and empty($this->docs['E-Verify'])){
      $this->addError('docs','E-Verify is required.');  
    }

  }
  
  public function validateDocs(){
    $c = new CDbCriteria;
    $c->compare('notice_type',$this->notice_type);
    if(!empty($this->notice_sub_type)){
      $c->compare('notice_sub_type',$this->notice_sub_type);
    }
    $docs_required = HrDocuments::model()->findAll($c);
    foreach($docs_required as $doc){
      
      if(empty($this->docs[$doc->document])){
        $this->addError($this->docs[$doc->document],$doc->document.' is required.');
      }
      $this->validExtension($this->docs[$doc->document],$doc->document);
    }
    
                                    
  }
  
  private function validExtension($filename,$attribute){
    
    $ext = trim(substr($filename, -3));
    $allowed = array('pdf','doc','docx');
    if(!in_array($ext,$allowed)){
      $this->addError($attribute,'Document '.$attribute.' is unacceptable. Allowed extensions are '.implode(', ',$allowed).' only.');    
    }  
  }
  
  public function validateStatus(){
    switch($this->status){
      case self::$NEW:
        if($this->processing_group != 'BOM'){
          $this->addError('status','When status is NEW, this notice should be routed to the facility BOM.');
          $this->addError('processing_group','This notice should be routed to the facility BOM.');
        }
      break;
      case self::$PROCESSING:

      break;
      case self::$WAITING:

      break;
      case self::$APPROVED:
        if($this->processing_group != 'CORP'){
          $this->addError('status','When status is APPROVED, this notice should route to CORP.');
          $this->addError('processing_group','This notice should be routed to CORP.');
        }
        if($this->decision != 'approve'){
          $this->addError('decision','Inconsistent decision.');
        }
      break;
      case self::$DECLINED:
        if($this->processing_group != 'CORP'){
          $this->addError('status','When status is DECLINED, this notice should route to CORP.');
          $this->addError('processing_group','This notice should be routed to CORP.');
        }
        if($this->decision != 'decline'){
          $this->addError('decision','Inconsistent decision.');
        }
      break;
      case self::$CANCELLED:
        
      break;
    }  
  } 
}
?>
