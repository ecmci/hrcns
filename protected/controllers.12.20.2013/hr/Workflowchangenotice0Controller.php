<?php

abstract class Workflowchangenotice0Controller extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()  
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return AccessRules::getRules('workflowchangenotice');
	}
  
  public function actionDecline(){
    try{
      if(!Yii::app()->request->isAjaxRequest) throw new CHttpException(500,'Invalid request.');
      $p = new CHtmlPurifier;
      $id = $p->purify($_POST['id']);
      $routeback = $p->purify($_POST['routeback']);
      $comment = $p->purify($_POST['comment']);
      $model = $this->loadModel($id);
      $model->status = $routeback == '1' ? WorkflowChangeNotice::$WAITING : WorkflowChangeNotice::$DECLINED;
      $model->processing_group = $routeback == '1' ? 'BOM' : $model->processing_group;
      $model->is_approved = '0';
      $model->comment = $comment; 
      $model->setSignee();
      if($model->save(false)){
        $model->notifyGroup();
        WorkflowChangeNotice::log($model->personalProfile->emp_id, '', 'DECLINE, back to BOM = '.$routeback ,'', '', '', $comment);
        echo '1';
      }else {
        throw new CHttpException(500,'Save failed!');
      }
    }catch(Exception $ex){
      WorkflowChangeNotice::log($model->personalProfile->emp_id, '', 'DECLINE FAILED!' ,'', '', '', $ex->getMessage());
      echo $ex->getMessage();      
    }
    Yii::app()->end(); 
  }
  
  public function actionPrint($id){   
    $this->render('_notice_form',array('notice'=>$this->loadModel($id)));
	//$this->render('print',array('notice'=>$this->loadModel($id)));  
  }
  
  public function actionPrintreport(){
    $notice = new WorkflowChangeNotice('search');
    $notice->unsetAttributes();
    $title = 'Change Notice Requests';
    if(isset($_GET['WorkflowChangeNotice'])) $notice->setAttributes($_GET['WorkflowChangeNotice']); 
    
    $this->render('print_report',array('notice'=>$notice,'title'=>$title));
  }
  
  public function actionGetquick($id){ //sleep(2);
    if(Yii::app()->request->isAjaxRequest){
      $notice = $this->loadModel($id);
      $this->renderPartial('_quick_view',array('notice'=>$notice));
      Yii::app()->end();
    }else throw new CHttpException(400, 'Invalid Request.');
  }
  
  public function actionOverride($id){
    $model = $this->loadModel($id);
    $model->scenario = 'override';
   
    $this->performAjaxValidation($model,'workflow-override-form');
    
    if(isset($_POST['WorkflowChangeNotice'])){
      // get post data
      $model->setAttributes($_POST['WorkflowChangeNotice']);
      
      // force some settings
       $model->is_approved = ($model->status == 'APPROVE' and $model->decision == 'approve') ? '1' : '0';
       $model->setSignee();
       $model->resetSignatures();
       
      // validate
      
      // save
      if($model->save()){        
        WorkflowChangeNotice::log($model->personalProfile->emp_id, '', 'Override' ,'', '', '', 'Override Reason:'.$model->comment);
        $model->notifyGroup();
        $this->redirect(array('admin'));        
      }else{
        $f = new CActiveForm;
        Yii::log('DEBUG: '.$f->errorSummary($model),'error','app');
      }


    }
    
    $this->render('override',array(
      'model'=>$model,
    ));
  }
  
  
  public function actionNewforemployee(){
    $this->render('newforemployee');
  }

  /**
   *    Finalize any data on a notice change; only updates existing profiles
   *    Preconditions: needs endorsement (function called $this->needsEndorsement returns true)
   *    WARNING: Updates the profiles   
   **/                 
  public function actionEndorse($id){    
    $notice = $this->loadModel($id);
    //$basic = Employee::model()->findByPk($notice->profile_id); // gets 1 record thru fk.profile_id
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
    $basic->scenario = $personal->scenario = $employment->scenario = $payroll->scenario = 'create'; 
    $notice->scenario = 'sign';
    
    $this->performAjaxValidationMany(array($notice,$basic,$personal,$employment,$payroll),'workflow-endorse-new-employee-form');
    
    if(isset($_POST['Employee'])){
      // get post data
      $basic->setAttributes($_POST['Employee']);
      $personal->setAttributes($_POST['EmployeePersonalInfo']);
      $employment->setAttributes($_POST['EmployeeEmployment']);
      $payroll->setAttributes($_POST['EmployeePayroll']);
      $notice->setAttributes($_POST['WorkflowChangeNotice']);
      
      // get attachment data
      $photoUpload = CUploadedFile::getInstance($basic,'photo');
      $contractUpload = CUploadedFile::getInstance($employment,'contract_file');
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
      
      // validate cross entities
      $vPayrollEmployment = $payroll->validatePtoEligibility($employment->status);

      
      if($vBasic and $vPersonal and $vEmployment and $vPayroll and $vPayrollEmployment){
        // save attachments
        $salt = time();
        if(!empty($photoUpload)){
          $fileName = "{$basic->emp_id}-{$salt}-{$photoUpload}";
          $fileName = Helper::cleanFilename($fileName);
          $photoUpload->saveAs(Yii::app()->basePath.'/../images/employee/photo/'.$fileName);
          $basic->photo = $fileName;
        }
        if(!empty($contractUpload)){
          $fileName = "{$basic->emp_id}-{$salt}-{$contractUpload}";
          $fileName = Helper::cleanFilename($fileName);
          $contractUpload->saveAs(Yii::app()->basePath.'/../images/employee/file/'.$fileName);
          $employment->contract_file = $fileName;
        }
        if(!empty($workflowUpload)){
          $fileName = "{$basic->emp_id}-{$salt}-{$workflowUpload}";
          $fileName = Helper::cleanFilename($fileName);
          $workflowUpload->saveAs(Yii::app()->basePath.'/../images/employee/file/'.$fileName);
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

  public function actionSign(){     
    $model_notice = new WorkflowChangeNotice('sign');
    
   
    if(isset($_POST['WorkflowChangeNotice'])){
       // get post data
       $data = $_POST['WorkflowChangeNotice'];
       
       // get record
       $on_record = $this->loadModel($data['id']);
       
       // set data on record
       $on_record->scenario = 'sign';
       $on_record->comment = $data['comment'];
       $uploadedFile = CUploadedFile::getInstance($on_record,'attachment');       
       $on_record->decision = $data['decision'];
       
      //save the attachment
      if(!empty($uploadedFile)){
        $salt = time();
        $fileName = "{$on_record->personalProfile->emp_id}-{$salt}-{$uploadedFile}";
        $fileName = Helper::cleanFilename($fileName);            
        $uploadedFile->saveAs(Yii::app()->basePath.'/../uploads/'.$fileName);
        $on_record->attachment = $fileName;
      }       
      
      //echo '<pre>'; echo print_r($on_record->comment); echo '<pre>'; exit(); 
       
       if($on_record->validate()){
         $on_record->setDecision();
         if($on_record->save(false)){
            $on_record->notifyGroup(); 
         }
         $this->redirect(Yii::app()->user->returnUrl);
       }else{
         $fr = new CActiveForm;
         $this->render('view2',array(
      			'notice'=>$on_record,      
      		));
       }

    }else{
      throw new CHttpException(400,'Invalid Request!');
    }
  }
  
  public function actionNew($id){

    // do not proceed if there is still an active change notice
    if(WorkflowChangeNotice::hasActiveNotice($id)){
      throw new CHttpException(403,'<strong>Cannot proceed with your request.</strong><br/>This employee has an active notice. Please wait until that notice has been officially decided. Otherwise, contact HR to cancel it.');
      Yii::app()->end();
    }
    
    $model = new WorkflowChangeNotice('new');
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
    
    if(isset($_POST['Employee'])){
      // get post data
      $model->attributes = $_POST['WorkflowChangeNotice'];
      $emp_basic->attributes = $_POST['Employee'];
      $emp_personal->attributes = $_POST['EmployeePersonalInfo'];
      $emp_employment->attributes = $_POST['EmployeeEmployment'];
      $emp_payroll->attributes = $_POST['EmployeePayroll'];
      
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
      
     
      // validate cross entities
      $vPayrollEmployment = $emp_payroll->validatePtoEligibility($emp_employment->status);
      
      // save if all are valid
      if($valid_basic and $valid_personal and $valid_employment and $valid_payroll and $vPayrollEmployment){              
        // get the originals for comparison
        $orig_basic = Employee::model()->findByPk($id);
        $orig_personal = EmployeePersonalInfo::getInfo($orig_basic);
        $orig_employment = EmployeeEmployment::getInfo($orig_basic);
        $orig_payroll = EmployeePayroll::getInfo($orig_basic);
        
        // get attachment data
        $photo = CUploadedFile::getInstance($emp_basic,'photo');
        $contract = CUploadedFile::getInstance($emp_employment,'contract_file');
        
        //set filenames
        $emp_basic->photo = isset($photo) ? $photo : $orig_basic->photo;
        $emp_employment->contract_file = isset($photo) ? $contract : $orig_employment->contract_file;
        
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
        
        // initiate a new workflow
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
  
  
  /**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$notice = WorkflowChangeNotice::model()->findByPk($id);

    if($notice->needsEndorsement()){
      $this->redirect(array('endorse','id'=>$notice->id));
    }
    
    $this->render('view2',array(
			'notice'=>$notice,      
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new WorkflowChangeNotice;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['WorkflowChangeNotice']))
		{
			$model->attributes=$_POST['WorkflowChangeNotice'];
			//if($model->save())
				//$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['WorkflowChangeNotice']))
		{
			$model->attributes=$_POST['WorkflowChangeNotice'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
// 		$dataProvider=new CActiveDataProvider('WorkflowChangeNotice');
// 		$this->render('index',array(
// 			'dataProvider'=>$dataProvider,
// 		));
    $this->actionAdmin();
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new WorkflowChangeNotice('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['WorkflowChangeNotice']))
			$model->attributes=$_GET['WorkflowChangeNotice'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=WorkflowChangeNotice::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model,$form)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']===$form)
    //if(isset($_POST['ajax']))
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
  
  protected function performAjaxValidationMany($models,$form){
    if(isset($_POST['ajax']) && $_POST['ajax']===$form)
		{
			echo CActiveForm::validate($models);
			Yii::app()->end();
		}    
  }
  
  public function actionTest(){
    $current = new Employee;
    $current->emp_id = '1';
    $current->last_name = 'xyz';
    $current->first_name = 'qwe';
    
    $last = new Employee;
    $last->emp_id = '2';
    $last->last_name = 'asd';
    $last->first_name = 'zxc';
    
    $cAttributes = $current->attributes;
    $lAttributes = $last->attributes;
    $changes = array();
    $empty = array();

    while($current_value = current($cAttributes)){
      $idx = key($cAttributes);
      $changes[] = $idx.'|'.$lAttributes[$idx].'|'.$current_value;
      next($cAttributes);
    }    
    
    $changes = serialize($empty);
    
    echo '<pre>';print_r($changes);echo '</pre>'; 
  }
  
  protected function renderActionColumn($data,$row){
    WorkflowChangeNotice::renderActionColumn($data,$row,$this);  
  }
}
