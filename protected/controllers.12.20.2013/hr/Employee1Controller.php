<?php 
Yii::import('application.controllers.hr.Employee0Controller');
class Employee1Controller extends Employee0Controller{
  public function actionModify($id){
    $notice = WorkflowChangeNotice::model()->findByPk($id);
    $basic = $notice->getProposedBasic(); // gets either from Employee or Employee Archive depending on the value of $notice->profile_id
    $personal = EmployeePersonalInfo::model()->findByPk($notice->personal_profile_id); // gets 1 record thru fk.active_personal_id 
    $employment = EmployeeEmployment::model()->findByPk($notice->employment_profile_id); // gets 1 record thru fk.active_employment_id
    $payroll = EmployeePayroll::model()->findByPk($notice->payroll_profile_id); // gets 1 record thru fk.active_payroll_id
    $notice->retrieveAttachments(); 
    $notice->scenario = 'attach';
    
		$this->performAjaxValidation(array($basic,$personal,$employment,$payroll,$notice), 'new-employee-form');

    if(isset($_POST['Employee']) or isset($_POST['EmployeePayroll'])){
      //get post data
      $basic->attributes=$_POST['Employee'];
      $basic->update_reason = 'REJECTED WITH CHANCE';
      $personal->attributes=$_POST['EmployeePersonalInfo'];
      $employment->attributes=$_POST['EmployeeEmployment'];
      $payroll->attributes=$_POST['EmployeePayroll'];
      $notice->attributes = $_POST['WorkflowChangeNotice'];
      $notice->setAttachments();
      
      // validate
      $validBasic = $basic->validate();
      $validPersonal = $personal->validate();
      $validEmployment = $employment->validate();
      $validPayroll = $payroll->validate();
      $validNotice = $notice->validate();
      
      // validate cross entities
      $validPayrollEmployment = $payroll->validatePtoEligibility($employment->status);
      
      //save
      if($validBasic and $validPersonal and $validEmployment and $validPayroll and $validNotice and $validPayrollEmployment){
        //save the models
        $basic->save(false);
        $personal->save(false);
        $employment->save(false);
        $payroll->save(false);
        
        //update the workflow
        $notice->is_approved = '1';
        $notice->comment = 'For Reconsideration';
        $notice->setStatus();
        $notice->routeToGroup();
        $notice->setSignee();
        $notice->saveAttachments();
        
        //save notice          
        if($notice->save(false)){        
          $notice->notifyGroup();
          WorkflowChangeNotice::log($basic->emp_id, $notice->notice_type, 'Modified ID '.$notice->id ,$notice->status, $notice->processing_group, '', $notice->comment);
        }else{
          $frm = new CActiveForm;
          WorkflowChangeNotice::log($basic->emp_id, $notice->notice_type, 'Failed to modify: '.print_r($frm->errorSummary($notice),true) ,$notice->status, $notice->processing_group, '', $notice->comment);   
        }
        //redirect 
        $this->redirect(array('view','id'=>$basic->emp_id));
        
      }
  
    }
  
    $this->render('/hr/employee/create',array(
			'model'=>$basic,
      'model_personal'=>$personal,
      'model_employment'=>$employment,
      'model_payroll'=>$payroll,
      'notice'=>$notice,
      'type'=>$notice->notice_type,
      'subtype'=>$notice->notice_sub_type,
		)); 
  
  }
  
  public function actionCreate(){
    $model=new Employee('create');
    $model_personal = new EmployeePersonalInfo('create');
    $model_employment = new EmployeeEmployment('create');
    $model_payroll = new EmployeePayroll('create');
    $notice = new WorkflowChangeNotice('attach');
    $notice->notice_type = 'NEW_HIRE';

    
		$this->performAjaxValidation(array($model,$model_personal,$model_employment,$model_payroll), 'new-employee-form');

    if(isset($_POST['Employee'])){
      //get post data
      $model->attributes=$_POST['Employee'];
      $model_personal->attributes=$_POST['EmployeePersonalInfo'];
      $model_employment->attributes=$_POST['EmployeeEmployment'];
      $model_payroll->attributes=$_POST['EmployeePayroll'];
      $notice->attributes = $_POST['WorkflowChangeNotice'];
      $notice->setAttachments();
      
      // validate
      $validBasic = $model->validate();
      $validPersonal = $model_personal->validate();
      $validEmployment = $model_employment->validate();
      $validPayroll = $model_payroll->validate();
      $validNotice = $notice->validate();

      // validate cross entities
      $validPayrollEmployment = $model_payroll->validatePtoEligibility($model_employment->status);

      
      //save
      if($validBasic and $validPersonal and $validEmployment and $validPayroll and $validNotice and $validPayrollEmployment){
        //save the parent
        $model->save(false);
        
        // log creation
        Employee::log($model->emp_id, "Registered New Employee" , "Staff-Initiated Registration");

        //set the children
        $model_personal->emp_id = $model->emp_id;
        $model_employment->emp_id = $model->emp_id;
        $model_payroll->emp_id = $model->emp_id;
        
        // save the children
        $model_personal->save(false);
        $model_employment->save(false);
        $model_payroll->save(false);
        
        //tie up profiles and update the parent 
        $model->active_personal_id = $model_personal->id;
        $model->active_employment_id = $model_employment->id;
        $model->active_payroll_id = $model_payroll->id;
        $model->save(false);
        
        //create a new notice
        $notice->profile_id = $model->emp_id;
        $notice->personal_profile_id = $model_personal->id;
        $notice->employment_profile_id = $model_employment->id;
        $notice->payroll_profile_id = $model_payroll->id;
        $notice->is_approved = '1'; 
        $notice->effective_date = $model_employment->date_of_hire; 
        $notice->comment = 'Staff Initiated Registration';
        $notice->initiated_by = Yii::app()->user->getState('id');
        $notice->setStatus();
        $notice->routeToGroup();
        $notice->setSignee();
        $notice->saveAttachments();
        
        //save notice          
        if($notice->save(false)){        
          $notice->notifyGroup();
          WorkflowChangeNotice::log($model->emp_id, $notice->notice_type, 'Created ID '.$notice->id ,$notice->status, $notice->processing_group, '', $notice->comment);
        }else{
          $frm = new CActiveForm;
          WorkflowChangeNotice::log($model->emp_id, $notice->notice_type, 'Failed to create: '.print_r($frm->errorSummary($notice),true) ,$notice->status, $notice->processing_group, '', $notice->comment);   
        }
        //redirect 
        $this->redirect(array('view','id'=>$model->emp_id));
      }
      
    }

    $this->render('create2',array(
			'model'=>$model,
      'model_personal'=>$model_personal,
      'model_employment'=>$model_employment,
      'model_payroll'=>$model_payroll,
      'notice'=>$notice,
		));
  }
}
?>