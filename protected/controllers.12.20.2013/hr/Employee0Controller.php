<?php

class Employee0Controller extends Controller
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
		return AccessRules::getRules('employee');
	}
  
  public function actionImport2(){
    Yii::log('MIGRATING EMP_ID:','error','app');
  }
  
  public function actionImportdfdsfsd(){
    $row = 1;
    $i = 999;
    if (($handle = fopen("/var/www/hrcns/elist2.csv", "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
          //Yii::log('MIGRATING EMP_ID: '.$data[0],'error','app');
          echo 'Migrating Emp_Id = '.$data[0].'<br/>';
          //if($row > 1){
            $basic = new Employee;
            $basic->emp_id = $i;
            $name = explode(' ',$data[1]);
            
            $lname = !empty($name[0]) ? $name[0] : '';
            $fname = !empty($name[1]) ? $name[1] : '';
            
            $lname = ucfirst(strtolower($lname));
            $fname = ucfirst(strtolower($fname));
             
            $mname = !empty($name[2]) ? ucfirst(strtolower($name[2])) : '';
            $fname = $fname.' '.$mname;
            $basic->last_name = $lname;
            $basic->first_name = $fname;
            $basic->middle_name = '';
            
            $personal = new EmployeePersonalInfo;
            $personal->emp_id = $basic->emp_id;
            $personal->birthdate = date('Y-m-d',strtotime($data[9]));
            $personal->gender = $data[8] == 'M' ? 'Male' : 'Female';
            $personal->marital_status = $data[10] = 'S' ? 'Single' : 'Married';
            $personal->SSN = $data[11];
            $addr1 = explode(' ',$data[2]);
            $personal->number = !empty($addr1[0]) ? $addr1[0] : '';
            $personal->building = '';
            $personal->street = !empty($addr1[1]) ? $addr1[1] : '';
            $personal->city = $data[3];
            $personal->state = $data[4];
            $personal->zip_code = $data[5];
            $personal->telephone = $data[6];
            $personal->cellphone = $data[7];
            $personal->email = '';
            $personal->is_approved = '1';
            
             $employment = new EmployeeEmployment;
             $employment->emp_id = $basic->emp_id;
             $n = TmHrNotices::model()->find(array(
              //'select'=>'facility_id',
              'condition'=>"employee_id = '$basic->emp_id'",
              'order'=>'id desc'
             ));
             if(!empty($n->facility_id)){
                $nn = TmpFacility::model()->find("id = '".$n->facility_id."'");
                $employment->facility_id = $nn->id_here;
             }else{
                $employment->facility_id = '69';   
             }
//             $employment->facility_id = !empty($n->facility_id) ? $n->facility_id : '';
//             $employment->status
            switch($data[13]){
              case 'F': $employment->status = 'FULL_TIME'; break;
              case 'B': $employment->status = 'FULL_TIME_IN_LIEU_OF_BENEFITS'; break;
              case 'P': $employment->status = 'PART_TIME'; break;
              case 'C': $employment->status = 'ON_CALL'; break;
            }

            
             $employment->date_of_hire = new CDbExpression('NULL');
             $employment->date_of_termination = new CDbExpression('NULL');
//             $employment->department_code
             $dept = TmpHrDept::model()->find(array(
              'select' =>'dept_code',
              'condition'=>"position_id = '".$data[12]."'"
             ));
             $employment->department_code = !empty($dept->dept_code) ?  $dept->dept_code : '';
             $employment->position_code = $data[12];
             $employment->start_date = new CDbExpression('NULL');
             $employment->end_date = new CDbExpression('NULL');
             $employment->contract_file =='';
             $employment->is_approved = '1';

            
            $payroll = new EmployeePayroll;
            $payroll->emp_id = $basic->emp_id;
            $payroll->is_pto_eligible = $data[14] == 'Y' ? '1' : '0';
            $payroll->pto_effective_date = $data[14] == 'Y' ? $data[15] : new CDbExpression('NULL');
            $payroll->fed_expt =  $data[16];
            $payroll->fed_add =  $data[17];
            $payroll->state_expt =  $data[18];
            $payroll->state_add =  $data[19];
            $payroll->rate_type = (!empty($n->rate_type) and $n->rate_type == 'H') ? 'HOURLY' : 'SALARY';
//             $payroll->w4_status
            $payroll->rate_proposed = $data[20];
            $payroll->rate_recommended = $data[20];
            $payroll->rate_approved = $data[20];
            $payroll->rate_effective_date = new CDbExpression('NULL');
//             $payroll->deduc_health_code
//             $payroll->deduc_health_amt
//             $payroll->deduc_dental_code
//             $payroll->deduc_dental_amt
//             $payroll->deduc_other_code
//             $payroll->deduc_other_amt
             $payroll->is_approved = '1';
            
            //echo '<pre>';print_r($payroll->attributes);echo '</pre>';
            
            $basic->save(false);
            $personal->save(false);
            $employment->save(false);
            $payroll->save(false);

            $basic->active_personal_id = $personal->id;
            $basic->active_employment_id  = $employment->id;
            $basic->active_payroll_id = $payroll->id;
            $basic->save(false);
            
            
          //}
          $row++;
          $i++;
          //if($row == 10)break;    
        }
        fclose($handle);
    } 
  }
  
  public function actionPrintreport(){
    $employee = new Employee('search');
    $employee->unsetAttributes();
    $title = 'Employees';
    if(isset($_GET['Employee'])) $employee->setAttributes($_GET['Employee']);    
    $this->render('print_report',array('employee'=>$employee,'title'=>$title));
  
  }
  
  public function actionApplicantselfservice(){
    $model = new Employee('selfservice');
    $model_personal = new EmployeePersonalInfo('selfservice');
    $model_employment = new EmployeeEmployment('selfservice');
    $model_payroll = new EmployeePayroll('selfservice');
    
    $this->performAjaxValidation($model,'self-service-form');
    $this->performAjaxValidation($model_personal,'self-service-form');
    $this->performAjaxValidation($model_employment,'self-service-form');
    
    if(isset($_POST['Employee'])){
      $model->attributes = $_POST['Employee'];
      $uploadedFile=CUploadedFile::getInstance($model,'photo');
      $model->photo = $uploadedFile;
      $model_personal->attributes = $_POST['EmployeePersonalInfo'];
      $model_employment->attributes = $_POST['EmployeeEmployment'];
      
      $validBasic = $model->validate();
      $validPersonal = $model_personal->validate();
      $validEmployment = $model_employment->validate();
      
      if($validBasic and $validPersonal and $validEmployment){
        // save the parent
        $model->save(false);
        
        // log new employee
        Employee::log($model->emp_id, "Registered New Employee" , "Applicant Self-Service");
        
        //save the photo
        $salt = time();
        $fileName = "{$model->emp_id}-{$salt}-{$uploadedFile}";
        $fileName = Helper::cleanFilename($fileName);
        $model->photo = !empty($uploadedFile) ? $fileName : '';
        if(!empty($uploadedFile)) {
           $uploadedFile->saveAs(Yii::app()->basePath.'/../images/employee/photo/'.$fileName);
        }
        
        //update the parent photo
        $model->save(false);
        
        // set the children
        $model_personal->emp_id = $model->emp_id;
        $model_employment->emp_id = $model->emp_id;
        $model_payroll->emp_id = $model->emp_id;
        
        //save the children
        $model_personal->save(false);
        $model_employment->save(false);
        $model_payroll->save(false);
        
        // tie up profiles and re-save parent
        $model->active_personal_id = $model_personal->id;
        $model->active_employment_id = $model_employment->id;
        $model->active_payroll_id = $model_payroll->id;
        $model->save(false); 
        
        
        // initiate a change notice workflow
        $profiles['emp_id'] = $model->emp_id;
        $profiles['personal_profile_id'] = $model_personal->id;
        $profiles['employment_profile_id'] = $model_employment->id;
        $profiles['payroll_profile_id'] = $model_payroll->id;
        $profiles['date_of_hire'] = $model_employment->date_of_hire;
        //Yii::log('D='.print_r( $model_employment->attributes,true),'info','app');
        WorkflowChangeNotice::initiate('NEW_HIRE',$profiles,'Applicant Self-Service');
        
       
        
        // redirect to sucess page
        $this->render('//site/success_page',array(
            'code'=>'Applicant Self-Service Registration',
            'message'=>'Your application has been submitted. We look forward to working with you here at Eva Care Group.',
        ));
        Yii::app()->end();
      }
    }
    
    $this->render('applicant_self_service',array(
      'model'=>$model,
      'model_personal'=>$model_personal,
      'model_employment'=>$model_employment,
    ));
  }

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		//$this->render('view',array(
			//'model'=>$this->loadModel($id),
		//));
	}
  
  
  
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Employee('create');
    $model_personal = new EmployeePersonalInfo('create');
    $model_employment = new EmployeeEmployment('create');
    $model_payroll = new EmployeePayroll('create');
    $notice = new WorkflowChangeNotice('attach');
    $notice->notice_type = 'NEW_HIRE';
    
		// Uncomment the following line if AJAX validation is needed    
		$this->performAjaxValidation(array($model,$model_personal,$model_employment,$model_payroll), 'new-employee-form');

		if(isset($_POST['Employee']))
		{
			// get post data
      $model->attributes=$_POST['Employee'];
      $model->photo = CUploadedFile::getInstance($model,'photo'); 
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
      if($validBasic and $validPersonal and $validEmployment and $validPayroll and $validPayrollEmployment){
        //save the parent
        $model->save(false);
        
        // log creation
        Employee::log($model->emp_id, "Registered New Employee" , "Staff-Initiated Registration");
        
        //save the profile attachments
        $uploadedPhoto=CUploadedFile::getInstance($model,'photo');
        $uploadedContract=CUploadedFile::getInstance($model_employment,'contract_file');
        
        $salt = time();
        $fileNamePhoto = "{$model->emp_id}-{$salt}-{$uploadedPhoto}";
        $fileNamePhoto = Helper::cleanFilename($fileNamePhoto);        
        $fileNameContract = "{$model->emp_id}-{$salt}-{$uploadedContract}";
        $fileNameContract = Helper::cleanFilename($fileNameContract);
        
        $model->photo = !empty($uploadedPhoto) ? $fileNamePhoto : 'avatar.jpg';
        $model_employment->contract_file = !empty($uploadedContract) ? $fileNameContract : '';
        if(!empty($uploadedPhoto)) {
           $uploadedPhoto->saveAs(Yii::app()->basePath.'/../images/employee/photo/'.$fileNamePhoto);
        }
        if(!empty($uploadedContract)) {
           $uploadedContract->saveAs(Yii::app()->basePath.'/../images/employee/file/'.$fileNameContract);
        }
        
               
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
        if($notice->save()){        
          $notice->notifyGroup();
          WorkflowChangeNotice::log($model->emp_id, $notice->notice_type, 'Created ID '.$notice->id ,$notice->status, $notice->processing_group, '', $notice->comment);
        }else{
          $frm = new CActiveForm;
          WorkflowChangeNotice::log($model->emp_id, $notice->notice_type, 'Failed to create: '.print_r($frm->errorSummary($notice),true) ,$notice->status, $notice->processing_group, '', $notice->comment);   
        }
        
        $this->redirect(array('view','id'=>$model->emp_id));

      }
			
		} //end post

		$this->render('create',array(
			'model'=>$model,
      'model_personal'=>$model_personal,
      'model_employment'=>$model_employment,
      'model_payroll'=>$model_payroll,
      'notice'=>$notice,
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
    $employee = $this->loadModel($id);
    $model->scenario = 'update';
    
		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model,'employee-form');

		if(isset($_POST['Employee']))
		{
			$model->attributes=$_POST['Employee'];
      $newPhoto = CUploadedFile::getInstance($model,'photo');
       
			if($model->validate()){
        if(!empty($newPhoto)) {
           $salt = time();
           $fileNamePhoto = "{$model->emp_id}-{$salt}-{$newPhoto}";  
           $newPhoto->saveAs(Yii::app()->basePath.'/../images/employee/photo/'.$fileNamePhoto);
           $model->photo = $fileNamePhoto; 
        }
        $model->save(false);
        //WorkflowChangeNotice::initiate('CHANGE',$model->emp_id,'Employee Basic Info Updated by staff '.Yii::app()->user->name.' User\'s reason was: '.$model->update_reason);
        // initiate a change notice workflow
        $profiles['emp_id'] = $model->emp_id;
        $profiles['personal_profile_id'] = $employee->active_personal_id;
        $profiles['employment_profile_id'] = $employee->active_employment_id;
        $profiles['payroll_profile_id'] = $employee->active_payroll_id;
        WorkflowChangeNotice::initiate('CHANGE',$profiles,$model->update_reason);
        
				$this->redirect(array('view','id'=>$model->emp_id));
      }
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
// 		$dataProvider=new CActiveDataProvider('Employee');
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
		$model=new Employee('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Employee']))
			$model->attributes=$_GET['Employee'];

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
		$model=Employee::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($models,$form)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']===$form)
    //if(isset($_POST['ajax']))
		{
      echo CActiveForm::validate($models);
			Yii::app()->end();
		}
	}
  
 
  protected function renderGridviewButtonColumn($data,$row){
    Employee::renderGridviewButtonColumn($data,$row,$this);  
  }
}
