<?php

class EmployeeController extends Controller
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
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('register'),
				'users'=>array('*'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionRegister(){
    $employee = new Employee;
    $personal = new EmployeePersonal;
    $employment = new EmployeeEmployment;
    $payroll = new EmployeePayroll;
    $workflow = new WorkflowChangeNotice;
    
    $this->performAjaxValidation($employee, $personal, $employment);
    
    if(isset($_POST['Employee'])){
      //get data
      $employee->attributes = $_POST['Employee'];
      $personal->attributes = $_POST['EmployeePersonal'];
      $employment->attributes = $_POST['EmployeeEmployment'];
      
      //validate
      $vEmployee = $employee->validate();
      $vPersonal = $personal->validate();
      $vEmployment = $employment->validate();
      
      if($vEmployee and $vPersonal and $vEmployment){
        //save profiles
        $employee->save(false);
        $personal->emp_id =  $employee->emp_id;
        $employment->emp_id =  $employee->emp_id;
        $payroll->emp_id = $employee->emp_id;
        $personal->save(false);
        $employment->save(false);
        $payroll->save(false);
        
        //tie up profiles
        $employee->active_personal_id = $personal->id;
        $employee->active_employment_id = $employment->id;
        $employee->active_payroll_id = $payroll->id;
        $employee->save(false);
        
        //initiate workflow
        $workflow->profile_id = $employee->emp_id;
        $workflow->personal_profile_id = $personal->id;
        $workflow->employment_profile_id = $employment->id;
        $workflow->payroll_profile_id = $payroll->id;
        $workflow->facility_id = $employment->facility_id;
        $workflow->save(false);

        
        //redirect
        $this->render('//site/success_page',array(
            'code'=>'Self-Service Registration',
            'message'=>'Your application has been submitted. We look forward to working with you here at Eva Care Group.',
        ));
        Yii::app()->end();
      } 
    }
    
    $this->render('register',array(
      'employee'=>$employee,
      'personal'=>$personal,
      'employment'=>$employment,
    ));  
  }

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Employee::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($employee, $personal, $employment)
	{
		if(isset($_POST['ajax']))
		{
			echo CActiveForm::validate(array($employee, $personal, $employment));
			Yii::app()->end();
		}
	}
}
