<?php
Yii::import('application.controllers.hr.Workflowchangenotice1Controller');
class WorkflowchangenoticeController extends Workflowchangenotice1Controller{
	public $form_title; 
	

	public function actionSign($id){
		try{
			$model = $this->loadModel($id); //echo json_encode($model->attributes); exit();
			$r['e'] = 'Something went wrong...';
			if(isset($_POST['WorkflowChangeNotice']) ){
			  $model->attributes = $_POST['WorkflowChangeNotice'];		  
			  switch($model->decision){
				  case '0' : 
					$model->is_approved = '0';
					$model->decline();
				  break;
				  case '1' : 
					$model->is_approved = '1';
					$model->routeToGroup();
				  break;
				  case '2' : 
					$model->is_approved = '0';
					$model->routeBackToBOM();
				  break;
			  }
			  $model->setSignee();        
			  $model->notifyGroup();
			  $model->save(false);      
			}
			$r['e'] = '0';	
		}catch(Exception $ex){
			$r['e'] = $ex->getMessage();
		}
		echo CJSON::encode($r);
		Yii::app()->end();
	}
  
  public function actionRoutebacktobom($id,$c=''){
    $model = $this->loadModel($id);
    $model->comment = CHtml::encode($c);	
    $model->routeBackToBOM()->save();
    $this->redirect( array( 'site/index' ) );
	}
  
	public function actionFinalize($id){
		$notice = $this->loadmodel($id);
		$notice->scenario = 'new';
		//$employee = Employee::model()->findByPk($notice->profile_id); //QUICK FIXED!!! CAUSE: ??
		$personal = EmployeePersonalInfo::model()->findByPk($notice->personal_profile_id);
		$employee = Employee::model()->findByPk($personal->emp_id);
		$employment = EmployeeEmployment::model()->findByPk($notice->employment_profile_id);
		$payroll = EmployeePayroll::model()->findByPk($notice->payroll_profile_id);
		
		$this->performAjaxValidationMany(array($notice,$employee,$personal,$employment,$payroll),'workflow-change-notice-form');
		
		if(isset($_POST['WorkflowChangeNotice'])){
			// get post data
			$notice->attributes = $_POST['WorkflowChangeNotice'];
			$employee->attributes = $_POST['Employee'];
			$personal->attributes = $_POST['EmployeePersonalInfo'];
			$employment->attributes = $_POST['EmployeeEmployment'];
			$payroll->attributes = $_POST['EmployeePayroll'];
			$employee->update_reason = $notice->reason;

			// validate models
			$vemployee = $employee->validate();
			$vpersonal = $personal->validate();
			$vemployment = $employment->validate();
			$vpayroll = $payroll->validate();
			$vnotice = $notice->validate();

			//save
			if($vemployee and $vpersonal and $vemployment and $vpayroll and $vnotice){
				$grp = Yii::app()->user->getState('hr_group');
				
				//trap routeback to BOM
				if($notice->decision == '2'){
				  $notice->routeBackToBom()->save(false);
				  $this->redirect( array( 'site/index' ) );
				  Yii::app()->end();
				}
        
				$personal->is_approved = $notice->decision;
				$employment->is_approved = $notice->decision;
				$payroll->is_approved = $notice->decision;
				
				$personal->save(false);
				$employment->save(false);
				$payroll->save(false);
				
				//update the main employee profile only if decision is yes
				if($notice->decision == '1'){
					$employee->active_personal_id = $notice->personal_profile_id;
					$employee->active_employment_id = $notice->employment_profile_id;
					$employee->active_payroll_id = $notice->payroll_profile_id;
					$employee->save(false);	
				}			

				$notice->is_approved = $notice->decision;
				$notice->setStatus();
				$notice->routeToGroup();
				$notice->setSignee();
				$notice->saveAttachments();  
				if($notice->save(false)){
				  $notice->notifyGroup();
				  $this->redirect(array('view','id'=>$notice->id));
				}
				
				
			}//end save			
		}//end post
		
		$this->render('finalize',array(
			'model'=>$notice,
			'emp_basic'=>$employee,
			'emp_personal'=>$personal,
			'emp_employment'=>$employment,
			'emp_payroll'=>$payroll,
		));
	}
  
  public function actionRedo($id){	    
		$notice = $this->loadModel($id);
		$notice->scenario = 'new';
		$employee = Employee::model()->findByPk($notice->profile_id);
		$personal = EmployeePersonalInfo::model()->findByPk($notice->personal_profile_id);
		$employment = EmployeeEmployment::model()->findByPk($notice->employment_profile_id);
		$payroll = EmployeePayroll::model()->findByPk($notice->payroll_profile_id);
		

		//restrict when viewing admin and don    
		switch($employment->position_code){
			case '25': case '6':
				if( !AccessRules::canSee('rate_approved')){
					throw new CHttpException(400,'You are not authorized to view this resource.');
				}
			break;
		}
		
		// set scenario
		$employee->scenario = 'workflow_new'; 
		$personal->scenario = 'workflow_new';   
		$employment->scenario = 'workflow_new';
		$payroll->scenario = 'workflow_new';
		
		$this->performAjaxValidationMany(array($notice,$employee,$personal,$employment,$payroll),'workflow-change-notice-form');
		
		if(isset($_POST['WorkflowChangeNotice'])){
			  // get post data
			  $notice->attributes = $_POST['WorkflowChangeNotice'];
			  $employee->attributes = $_POST['Employee'];
			  $personal->attributes = $_POST['EmployeePersonalInfo'];
			  $employment->attributes = $_POST['EmployeeEmployment'];
			  $payroll->attributes = $_POST['EmployeePayroll'];
			  
			  
			  // force profiles for appproval
			  $personal->is_approved = '0';
			  $employment->is_approved = '0';
			  $payroll->is_approved = '0';
			  
			  // validate models
			  $vemployee = $employee->validate();
			  $vpersonal = $personal->validate();
			  $vemployment = $employment->validate();
			  $vpayroll = $payroll->validate();
			  $vnotice = $notice->validate();
        
        if($vemployee and $vpersonal and $vemployment and $vpayroll and $vnotice){
            $employee->save(false);
            $personal->save(false);
            $employment->save(false);
            $payroll->save(false);
            
            $notice->is_approved = '1';
            $notice->setStatus();
            $notice->routeToGroup();
            $notice->setSignee();
            $notice->saveAttachments();  
            if($notice->save(false)){
              $notice->notifyGroup();
              $this->redirect(array('view','id'=>$notice->id));
            }
        }//end valid
		}//end post
		
		 
		$this->render('redo',array(
		  'model'=>$notice,
		  'emp_basic'=>$employee,
		  'emp_personal'=>$personal,
		  'emp_employment'=>$employment,
		  'emp_payroll'=>$payroll,
		));
		
  }
  
  public function actionOverride($id){
		$model = $model = $this->loadModel($id);
		$model->scenario = 'override';
		
		$this->performAjaxValidation($model,'workflow-override-form');
		
		if(isset($_POST['WorkflowChangeNotice'])){
			$model->attributes = $_POST['WorkflowChangeNotice'];
			if($model->validate()){
				$model->setSignee();
				echo '<pre>'; print_r($model->attributes);  echo '</pre>';
			}
		}
		
		$this->render('override',array(
		  'model'=>$model,
		));
  }
  
  public function actionGetdeptcode(){
    if(!Yii::app()->request->isAjaxRequest) throw new CHttpException(400,'Forbidden');
    $data = array();
    $pcode = Yii::app()->request->getParam('poscode');
    $data['dept_code'] = (!empty($pcode)) ? Position::model()->find("code = '$pcode'")->dept_code : '';
    echo CJSON::encode($data);
    Yii::app()->end();  
  }
  
  public function actionPrint($id){
    //if(!AccessRules::canSee('rate_approved'))
		//throw new CHttpException(403,'You are not authorized to print this request.');
    
    $this->form_title = 'Employee New Hire and Change Notice';
    parent::actionPrint($id);
  }
  
  public function actionEndorse($id){
    $notice = $this->loadModel($id);
    $employee = $notice->getProposedBasic(); 
    $personal = EmployeePersonalInfo::model()->findByPk($notice->personal_profile_id);  
    $employment = EmployeeEmployment::model()->findByPk($notice->employment_profile_id); 
    $payroll = EmployeePayroll::model()->findByPk($notice->payroll_profile_id); 
    
    //set scenario
    $notice->scenario = $notice->processing_group == 'CORP' ? '' : 'attach';
    $employee->scenario = 'create';
    $personal->scenario = 'create';
    $employment->scenario = 'create';
    $payroll->scenario = 'create';
    
    if(isset($_POST['ajax']))
		{
			echo CActiveForm::validate(array($notice,$employee,$personal,$employment,$payroll));
			Yii::app()->end();
		}
    
    if(isset($_POST['WorkflowChangeNotice']) ){
      //save post data
      $notice->attributes = $_POST['WorkflowChangeNotice'];
      $employee->attributes = $_POST['Employee'];
      $personal->attributes = $_POST['EmployeePersonalInfo'];
      $employment->attributes = $_POST['EmployeeEmployment'];
      $payroll->attributes = $_POST['EmployeePayroll'];
      
      //validate
      $vNotice = $notice->validate();
      $vEmployee = $employee->validate();
      $vPersonal = $personal->validate();
      $vEmployment = $employment->validate();
      $vPayroll = $payroll->validate();
      $vPayrollEmployment = $payroll->validatePtoEligibility($employment->status); 
      
     
      if( $vNotice and $vEmployee and $vPersonal and $vEmployment and $vPayroll and $vPayrollEmployment){
        //save profiles
        $employee->save(false);
        $personal->save(false);
        $employment->save(false);        
        $payroll->save(false);
        
        //update and save the workflow
        $notice->is_approved = '1'; 
        $notice->effective_date = $employment->date_of_hire; 
        //$notice->comment = $notice->processing_group == 'CORP' ? $notice->comment : 'Endorsement';
        $notice->initiated_by = Yii::app()->user->getState('id');
        $notice->setStatus();
        $notice->routeToGroup();
        $notice->setSignee();
        $notice->saveAttachments();
        
        if($notice->save(false)){
          $notice->notifyGroup();
          $this->redirect(array('view','id'=>$notice->id));  
        }
        
      }
        
    }
    
    $this->render('/hr/employee/create2',array(
			'model'=>$employee,
      'model_personal'=>$personal,
      'model_employment'=>$employment,
      'model_payroll'=>$payroll,
      'notice'=>$notice,
		));
    
  }         
  
  

}
?>
