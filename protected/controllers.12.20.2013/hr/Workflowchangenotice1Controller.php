<?php
Yii::import('application.controllers.hr.Workflowchangenotice0Controller');

class Workflowchangenotice1Controller extends Workflowchangenotice0Controller{
  public function actionEndorse($id){
    $notice = $this->loadModel($id);
    $basic = $notice->getProposedBasic(); // gets either from Employee or Employee Archive depending on the value of $notice->profile_id
    $personal = EmployeePersonalInfo::model()->findByPk($notice->personal_profile_id); // gets 1 record thru fk.active_personal_id 
    $employment = EmployeeEmployment::model()->findByPk($notice->employment_profile_id); // gets 1 record thru fk.active_employment_id
    $payroll = EmployeePayroll::model()->findByPk($notice->payroll_profile_id); // gets 1 record thru fk.active_payroll_id

    // force records as retrieves
    $notice->isNewRecord = false;
    $basic->isNewRecord = false;
    $personal->isNewRecord = false;
    $employment->isNewRecord = false;
    $payroll->isNewRecord = false;
    
    // set scenario same as 'create' new employee by staff
    $basic->scenario = $personal->scenario = $employment->scenario = 'create';
    $payroll->scenario = 'endorse'; 
    $notice->scenario = 'sign';

    $this->performAjaxValidationMany(array($notice,$basic,$personal,$employment,$payroll),'workflow-endorse-new-employee-form');
    
    if(isset($_POST['WorkflowChangeNotice'])){
      // get post data
      $basic->setAttributes($_POST['Employee']);
      $personal->setAttributes($_POST['EmployeePersonalInfo']);
      $employment->setAttributes($_POST['EmployeeEmployment']);
      $payroll->setAttributes($_POST['EmployeePayroll']);
      $notice->setAttributes($_POST['WorkflowChangeNotice']);
      
      //workflow attachment
      $workflowUpload = CUploadedFile::getInstance($notice,'attachment');
      
      // force settings in workflow
      $notice->decision = 'approve';
      $notice->is_approved = '1';
      $notice->setDecision();
      
      // validate
      $vBasic = $basic->validate();
      $vPersonal = $personal->validate();
      $vEmployment = $employment->validate();
      $vPayroll = $payroll->validate();
      $vNotice = $notice->validate();
      
      // validate cross entities
      $vPayrollEmployment = $payroll->validatePtoEligibility($employment->status);
      
      if($vBasic and $vPersonal and $vEmployment and $vPayroll and $vPayrollEmployment and $vNotice){
        // save attachments
        $salt = time();
        if(!empty($workflowUpload)){
          $fileName = "{$basic->emp_id}-{$salt}-{$workflowUpload}";
          $fileName = Helper::cleanFilename($fileName);
          $workflowUpload->saveAs(Yii::app()->basePath.'/../'.Yii::app()->params['uploads_dir'].'/'.$fileName);
          $notice->attachment = $fileName;
        }
        
        // save profiles
        $basic->save(false);
        $personal->save(false);
        $employment->save(false);
        $payroll->save(false);

        //save workflow
        // update record
        $on_record = $this->loadModel($notice->id); 
        $on_record->scenario = 'sign';
        $data = $_POST['WorkflowChangeNotice'];
        $on_record->comment = $data['comment'];
        $on_record->attachment = $notice->attachment;
        $on_record->decision = 'approve';
        $on_record->setDecision();
        $on_record->effective_date = $employment->date_of_hire;
        
        if($on_record->save(false)){
          $on_record->notifyGroup();
          $this->redirect(array('view','id'=>$on_record->id));  
        }  
      }
    }
    
    $this->render('endorse',array(
      'notice'=>$notice,
      'model'=>$basic,
      'model_personal'=>$personal,
      'model_employment'=>$employment,
      'model_payroll'=>$payroll,
    ));  
  }
  
  public function actionView($id){
    $notice = WorkflowChangeNotice::model()->findByPk($id);
    
    //restrict when viewing admin and don    
    switch($notice->employmentProfile->position_code){
		case '25': case '6':
			if( !AccessRules::canSee('rate_approved')){
				throw new CHttpException(400,'You are not authorized to view this resource.');
			}
		break;
	}
    
    
    if($notice->returnToBom()){
      $this->redirect(array('/hr/employee/modify','id'=>$notice->id));
    }else{
      parent::actionView($id);
    }
  }
  
  
  public function actionNew($id){
    // do not proceed if there is still an active change notice
//     if(WorkflowChangeNotice::hasActiveNotice($id)){
//       throw new CHttpException(403,'<strong>Cannot proceed with your request.</strong><br/>This employee has an active notice. Please wait until that notice has been officially decided. Otherwise, contact HR to cancel it.');
//       Yii::app()->end();
//     }
    
    $model = new WorkflowChangeNotice('new'); 
    $model->notice_type = 'CHANGE';
    $model->notice_sub_type = 'WAGE_CHANGE';
    $emp_basic = Employee::model()->findByPk($id);
    $emp_personal = EmployeePersonalInfo::getInfo($emp_basic);
    $emp_employment = EmployeeEmployment::getInfo($emp_basic);
    $emp_payroll = EmployeePayroll::getInfo($emp_basic);
    
    //restrict when viewing admin and don    
    switch($emp_employment->position_code){
		case '25': case '6':
			if( !AccessRules::canSee('rate_approved')){
				throw new CHttpException(400,'You are not authorized to view this resource.');
			}
		break;
	}
    
    // set scenario
    $emp_basic->scenario = 'workflow_new'; 
    $emp_personal->scenario = 'workflow_new';   
    $emp_employment->scenario = 'workflow_new';
    $emp_payroll->scenario = 'workflow_new';
    
    // ajax validation
    $this->performAjaxValidationMany(array($model,$emp_basic,$emp_personal,$emp_employment,$emp_payroll),'workflow-change-notice-form');

    if(isset($_POST['WorkflowChangeNotice'])){
      // get post data
      $model->attributes = $_POST['WorkflowChangeNotice'];
      $emp_basic->attributes = $_POST['Employee'];
      $emp_personal->attributes = $_POST['EmployeePersonalInfo'];
      $emp_employment->attributes = $_POST['EmployeeEmployment'];
      $emp_payroll->attributes = $_POST['EmployeePayroll'];
      $model->setAttachments();
      
      // force profiles for appproval
      $emp_personal->is_approved = '0';
      $emp_employment->is_approved = '0';
      $emp_payroll->is_approved = '0';
      
      // force profiles as new records
      $emp_personal->isNewRecord = true;
      $emp_employment->isNewRecord = true;
      $emp_payroll->isNewRecord = true;
                                     
      // validate models
      $valid_basic = $emp_basic->validate();
      $valid_personal = $emp_personal->validate();
      $valid_employment = $emp_employment->validate();
      $valid_payroll = $emp_payroll->validate();
      $valid_model = $model->validate();
	  
      // validate cross entities
      $vPayrollEmployment = $emp_payroll->validatePtoEligibility($emp_employment->status); 
      
      if($valid_basic and $valid_personal and $valid_employment and $valid_payroll and $vPayrollEmployment and $valid_model){
        
        
        // get the originals for comparison
        $orig_basic = Employee::model()->findByPk($id);
        $orig_personal = EmployeePersonalInfo::getInfo($orig_basic);
        $orig_employment = EmployeeEmployment::getInfo($orig_basic);
        $orig_payroll = EmployeePayroll::getInfo($orig_basic);
        
        // see which model has changes
        $basic_changed = array_diff($emp_basic->attributes, $orig_basic->attributes);
        $personal_changed = array_diff($emp_personal->attributes, $orig_personal->attributes);
        $employment_changed = array_diff($emp_employment->attributes, $orig_employment->attributes);
        $payroll_changed = array_diff($emp_payroll->attributes, $orig_payroll->attributes);
        
        // only save new record for those with changes
        $isSomethingChanged = false;               
        if(!empty($personal_changed)){
          $emp_personal->isNewRecord = true;
          unset($emp_personal->id);         
          $emp_personal->save(false);
          $emp_basic->active_personal_id = $emp_personal->id;
          $model->comment .= ' | Employee Personal Info Changes: '.Helper::arrayToString($personal_changed);
          $isSomethingChanged = true;
          $model->summarizeChanges($emp_personal, $orig_personal);
        }

        if(!empty($employment_changed)){
          $emp_employment->isNewRecord = true;
          unset($emp_employment->id);
          $emp_employment->save(false);
          $emp_basic->active_employment_id = $emp_employment->id;
          $model->comment .= ' | Employee Employment Info Changes: '.Helper::arrayToString($employment_changed);
          $isSomethingChanged = true;
          $model->summarizeChanges($emp_employment, $orig_employment);
        }
        
        if(!empty($payroll_changed)){
          $emp_payroll->isNewRecord = true;
          unset($emp_payroll->id);
          $emp_payroll->save(false);
          $emp_basic->active_payroll_id = $emp_payroll->id;
          $model->comment .= ' | Employee Payroll Info Changes: '.Helper::arrayToString($payroll_changed);
          $isSomethingChanged = true;
          $model->summarizeChanges($emp_payroll, $orig_payroll);
        }
        
        if(!empty($basic_changed)){
          $emp_basic_archive = new EmployeeBasicInfoArchive;
          $emp_basic_archive->attributes = $emp_basic->attributes;
          $emp_basic_archive->active_employment_id = $emp_basic->active_employment_id; // save the new employment profile id to archive
          $emp_basic_archive->active_personal_id = $emp_basic->active_personal_id; // save the new personal profile id to archive
          $emp_basic_archive->active_payroll_id = $emp_basic->active_payroll_id; // save the new payroll profile id to archive
          $emp_basic_archive->emp_id = $emp_basic->emp_id;
          $model->comment .= ' | Employee Basic Info Changes: '.Helper::arrayToString($basic_changed);
          $emp_basic_archive->photo = $emp_basic->photo; 
          $emp_basic_archive->save(false);
          $emp_basic->emp_id = '0';
          $isSomethingChanged = true;
          $model->summarizeChanges($emp_basic, $orig_basic);  
        }
        
        if($isSomethingChanged){
          $model->profile_id = $emp_basic->emp_id; 
          $model->personal_profile_id = $emp_basic->active_personal_id;
          $model->employment_profile_id = $emp_basic->active_employment_id;
          $model->payroll_profile_id = $emp_basic->active_payroll_id;
          $model->is_approved = '1'; // approve and sign directly
          
          $initiator = Yii::app()->user->getState('id');
          $model->initiated_by = empty($initiator) ? '0' : $initiator;
          $model->setStatus();
          $model->routeToGroup();
          $model->setSignee();          
          $model->setEffectiveDate($emp_employment,$emp_payroll,$employment_changed,$payroll_changed);
          $model->saveAttachments();
          
          if($model->save(false)){        
            //echo 'good!';exit();
            $model->notifyGroup();
            WorkflowChangeNotice::log($emp_basic->emp_id, $model->notice_type, 'Created ID '.$model->id ,$model->status, $model->processing_group, '', $model->comment);
          }else{
            //echo 'not good!';exit();
            $frm = new CActiveForm;
            WorkflowChangeNotice::log($emp_basic->emp_id, $model->notice_type, 'Failed to create: '.print_r($frm->errorSummary($model),true) ,$model->status, $model->processing_group, '', $model->$comment);   
          }
          
          // redirect
          $this->redirect(array('view','id'=>$model->id));  
       }else{
          $model->addError('','Nothing is changed.');
       }
      } 
    }

    $this->render('new3',array(
      'model'=>$model,
      'emp_basic'=>$emp_basic,
      'emp_personal'=>$emp_personal,
      'emp_employment'=>$emp_employment,
      'emp_payroll'=>$emp_payroll,
    ));

  }
  
  public function actionNew2($id){
    // do not proceed if there is still an active change notice
    if(WorkflowChangeNotice::hasActiveNotice($id)){
      throw new CHttpException(403,'<strong>Cannot proceed with your request.</strong><br/>This employee has an active notice. Please wait until that notice has been officially decided. Otherwise, contact HR to cancel it.');
      Yii::app()->end();
    }
    
    $model = new WorkflowChangeNotice('new'); 
    $model->notice_sub_type = 'WAGE_CHANGE';
    $emp_basic = Employee::model()->findByPk($id);
    $emp_personal = EmployeePersonalInfo::getInfo($emp_basic);
    $emp_employment = EmployeeEmployment::getInfo($emp_basic);
    $emp_payroll = EmployeePayroll::getInfo($emp_basic);
    
    // set scenario
    $emp_basic->scenario = 'workflow_new'; 
    $emp_personal->scenario = 'workflow_new';   
    $emp_employment->scenario = 'workflow_new';
    $emp_payroll->scenario = 'workflow_new';

    // ajax validation
    $this->performAjaxValidationMany(array($model,$emp_basic,$emp_personal,$emp_employment,$emp_payroll),'workflow-change-notice-form');

    //post data
    if(isset($_POST['Employee'])){
      // get post data
      $model->attributes = $_POST['WorkflowChangeNotice'];
      $emp_basic->attributes = $_POST['Employee'];
      $emp_personal->attributes = $_POST['EmployeePersonalInfo'];
      $emp_employment->attributes = $_POST['EmployeeEmployment'];
      $emp_payroll->attributes = $_POST['EmployeePayroll'];
      $model->setAttachments();
      
      // force profiles for appproval
      $emp_personal->is_approved = '0';
      $emp_employment->is_approved = '0';
      $emp_payroll->is_approved = '0';
      
      // force profiles as new records
      $emp_personal->isNewRecord = true;
      $emp_employment->isNewRecord = true;
      $emp_payroll->isNewRecord = true;
                                     
      // validate models
      $valid_basic = $emp_basic->validate();
      $valid_personal = $emp_personal->validate();
      $valid_employment = $emp_employment->validate();
      $valid_payroll = $emp_payroll->validate();
      $valid_model = $model->validate();
	  
      // validate cross entities
      $vPayrollEmployment = $emp_payroll->validatePtoEligibility($emp_employment->status);
      
      // save if all are valid
      if($valid_basic and $valid_personal and $valid_employment and $valid_payroll and $vPayrollEmployment){              
        // get the originals for comparison
        $orig_basic = Employee::model()->findByPk($id);
        $orig_personal = EmployeePersonalInfo::getInfo($orig_basic);
        $orig_employment = EmployeeEmployment::getInfo($orig_basic);
        $orig_payroll = EmployeePayroll::getInfo($orig_basic);
        
        // get photo and contract attachments
        $photo = CUploadedFile::getInstance($emp_basic,'photo');
        $contract = CUploadedFile::getInstance($emp_employment,'contract_file');
        
        //set filenames
        $emp_basic->photo = isset($photo) ? Helper::generateFilename($id, $photo) : $orig_basic->photo;
        $emp_employment->contract_file = isset($contract) ? Helper::generateFilename($id, $contract) : $orig_employment->contract_file;
        
        // see which model has changes
        $basic_changed = array_diff($emp_basic->attributes, $orig_basic->attributes);
        $personal_changed = array_diff($emp_personal->attributes, $orig_personal->attributes);
        $employment_changed = array_diff($emp_employment->attributes, $orig_employment->attributes);
        $payroll_changed = array_diff($emp_payroll->attributes, $orig_payroll->attributes);
        
        // only save new record for those with changes
        $isSomethingChanged = false;               
        if(!empty($personal_changed)){
          $emp_personal->isNewRecord = true;
          unset($emp_personal->id);         
          $emp_personal->save(false);
          $emp_basic->active_personal_id = $emp_personal->id;
          $model->comment .= ' | Employee Personal Info Changes: '.Helper::arrayToString($personal_changed);
          $isSomethingChanged = true;
          $model->summarizeChanges($emp_personal, $orig_personal);
        }

        if(!empty($employment_changed)){
          $emp_employment->isNewRecord = true;
          unset($emp_employment->id);
          if(!empty($contract)){
            $salt = time();
            $fileName = "{$new_employment->emp_id}-{$salt}-{$contract}";
            $fileName = Helper::cleanFilename($fileName);
            $emp_employment->contract_file = $fileName;            
            $contract->saveAs(Yii::app()->basePath.'/../images/employee/file/'.$fileName);
          }
          $emp_employment->save(false);
          $emp_basic->active_employment_id = $emp_employment->id;
          $model->comment .= ' | Employee Employment Info Changes: '.Helper::arrayToString($employment_changed);
          $isSomethingChanged = true;
          $model->summarizeChanges($emp_employment, $orig_employment);
        }
        
        if(!empty($payroll_changed)){
          $emp_payroll->isNewRecord = true;
          unset($emp_payroll->id);
          $emp_payroll->save(false);
          $emp_basic->active_payroll_id = $emp_payroll->id;
          $model->comment .= ' | Employee Payroll Info Changes: '.Helper::arrayToString($payroll_changed);
          $isSomethingChanged = true;
          $model->summarizeChanges($emp_payroll, $orig_payroll);
        }
        
        if(!empty($basic_changed)){
          $emp_basic_archive = new EmployeeBasicInfoArchive;
          $emp_basic_archive->attributes = $emp_basic->attributes;
          $emp_basic_archive->active_employment_id = $emp_basic->active_employment_id; // save the new employment profile id to archive
          $emp_basic_archive->active_personal_id = $emp_basic->active_personal_id; // save the new personal profile id to archive
          $emp_basic_archive->active_payroll_id = $emp_basic->active_payroll_id; // save the new payroll profile id to archive
          $emp_basic_archive->emp_id = $emp_basic->emp_id;
          $model->comment .= ' | Employee Basic Info Changes: '.Helper::arrayToString($basic_changed);
          if(!empty($photo)){
            $salt = time();
            $fileName = "{$emp_basic_archive->emp_id}-{$salt}-{$photo}";
            $fileName = Helper::cleanFilename($fileName);
            $emp_basic_archive->photo = $fileName;
            $photo->saveAs(Yii::app()->basePath.'/../images/employee/photo/'.$fileName);
          }else{
            $emp_basic_archive->photo = $emp_basic->photo; 
          }
          $emp_basic_archive->save(false);
          $emp_basic->emp_id = '0';
          $isSomethingChanged = true;
          $model->summarizeChanges($emp_basic, $orig_basic);  
        }
        
        if($isSomethingChanged){
          $model->profile_id = $emp_basic->emp_id; 
          $model->personal_profile_id = $emp_basic->active_personal_id;
          $model->employment_profile_id = $emp_basic->active_employment_id;
          $model->payroll_profile_id = $emp_basic->active_payroll_id;
          $model->is_approved = '1'; // approve and sign directly
          
          $initiator = Yii::app()->user->getState('id');
          $model->initiated_by = empty($initiator) ? '0' : $initiator;
          $model->setStatus();
          $model->routeToGroup();
          $model->setSignee();          
          $model->setEffectiveDate($emp_employment,$emp_payroll,$employment_changed,$payroll_changed);
          $model->saveAttachments();
          
          if($model->save()){        
            $model->notifyGroup();
            WorkflowChangeNotice::log($emp_basic->emp_id, $model->notice_type, 'Created ID '.$model->id ,$model->status, $model->processing_group, '', $model->comment);
          }else{
            $frm = new CActiveForm;
            WorkflowChangeNotice::log($emp_basic->emp_id, $model->notice_type, 'Failed to create: '.print_r($frm->errorSummary($model),true) ,$model->status, $model->processing_group, '', $model->$comment);   
          }
          
          // redirect
          $this->redirect(array('view','id'=>$model->id));
  
        }

      }

    }

    $this->render('new',array(
      'model'=>$model,
      'emp_basic'=>$emp_basic,
      'emp_personal'=>$emp_personal,
      'emp_employment'=>$emp_employment,
      'emp_payroll'=>$emp_payroll,
    ));
  }
  
  public function actionRequiredocs($t, $s){
    Yii::import('ext.yii-bootstrap.widgets.TbActiveForm');
    $form  = new TbActiveForm;
    $form->type = 'horizontal';
    $notice = new WorkflowChangeNotice;
    if(!Yii::app()->request->isAjaxRequest) throw new CHttpException(500,'Invalid Request.'); 
    $data['form'] = $this->renderPartial('_attachments',array(
      'type'=>$t,
      'subtype'=>$s,
      'form'=>$form,
      'notice'=>$notice,
    ),true);
    $docs = WorkflowChangeNotice::getDocsToAttach($t,$s);
    $data['doc_count'] = sizeof($docs);
    $i = 0;
    foreach($docs as $doc){
      $data['doc'][$i++] = CHtml::activeId($notice,'docs['.$doc->document.']').'-cum-uploader';
    } 
    echo CJSON::encode($data);
    Yii::app()->end();
  }
} 
?>
