<?php
Yii::import('application.controllers.hr.Workflowchangenotice1Controller');
class WorkflowchangenoticeController extends Workflowchangenotice1Controller{
  public $form_title; 
  
  public function actionOverride($id){
      $model = $model = $this->loadModel($id);
      $model->scenario = 'override2';
      
      $this->performAjaxValidation($model,'workflow-override-form');
      
      if(isset($_POST['WorkflowChangeNotice'])){
        $model->attributes = $_POST['WorkflowChangeNotice'];
        if($model->validate()){
          $model->setSignee();
          $model->save(false);
          $this->redirect(Yii::app()->user->returnUrl);
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
