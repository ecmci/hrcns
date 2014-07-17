<?php

class NoticeController extends Controller
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
		return Security::getControllerRules('notice');
	}
    
    /**
     * Cancels a notice
     */ 
    public function actionCancel($id){ 
		$notice = $this->loadModel($id);
		
		switch($notice->status){
			case 'NEW' : 
			case 'WAITING' : 
				$notice->status = 'CANCELLED';		
				$notice->edit = '1';		
			break;
			default: throw new CHttpException(403,'Only active notices can be cancelled.');
		}
		
		if($notice->save()){
			
		}else{} 
		$this->redirect(array('review','id'=>$notice->id));
	}
    
    /**
     * Prints a Notice
     */
    public function actionPrint($id){
		$notice = $this->loadModel($id);

		$employee = Employee::model()->findByPk($notice->profile_id);
		$personal = Personal::model()->findByPk($notice->personal_profile_id);
		$employment = Employment::model()->findByPk($notice->employment_profile_id);
		$payroll = Payroll::model()->findByPk($notice->payroll_profile_id);
		
		$this->render('print',array(
			'notice'=>$notice,
			'employee'=>$employee,
			'personal'=>$personal,
			'employment'=>$employment,
			'payroll'=>$payroll,
		));
	} 
    
    /**
     * Prints a report
     */ 
    public function actionPrintreport(){
		$notice = new Notice('search');
		$notice->unsetAttributes();
		
		if(isset($_GET['Notice'])) $notice->attributes = $_GET['Notice'];
		
		$this->render('printreport',array('notice'=>$notice));
	}
    
    /**
     * Search for a notice ID
     * 
     */
    public function actionSearch(){
		$notice = new Notice('search');
		$notice->unsetAttributes();
		
		if(isset($_GET['Notice'])) $notice->attributes = $_GET['Notice'];
		
		$this->render('search',array('notice'=>$notice));
	}
    
    /**
     * Edit the notice; notice stays at the current status and processing group
     */  
    public function actionEdit($id){
        $notice = $this->loadModel($id);
        
       
		$employee = Employee::model()->findByPk($notice->profile_id);
		$personal = Personal::model()->findByPk($notice->personal_profile_id);
		$employment = Employment::model()->findByPk($notice->employment_profile_id);
		$payroll = Payroll::model()->findByPk($notice->payroll_profile_id);
        $form = App::printEnum($notice->notice_type);
        
        //set scenario
		$notice->scenario = 'prepare';
		$employee->scenario = 'prepare';
		$personal->scenario = 'prepare';
		$employment->scenario = 'prepare';
		$payroll->scenario = 'prepare';
		
		//handle ajax validation
		$this->performAjaxValidation(array($notice,$employee,$personal,$employment,$payroll));
        
        //handle posted data
		if(isset($_POST['Notice'])){
			$notice->attributes = $_POST['Notice'];
			$employee->attributes = $_POST['Employee'];
			$personal->attributes = $_POST['Personal'];
			$employment->attributes = $_POST['Employment'];
			$payroll->attributes = $_POST['Payroll'];
			$employee->photo = CUploadedFile::getInstance($employee,'photo');
			
			//validate
			$p0 = $notice->validate();
			$p1 = $employee->validate();
			$p2 = $personal->validate();
			$p3 = $employment->validate();
			$p4 = $payroll->validate();
			$p5 = $payroll->validatePTO($employment);
            
            if($p0 and $p1 and $p2 and $p3 and $p4 and $p5){
                //set flag that this is just an edit so this will stay in the current group and status
                $notice->edit = '1';
                
                //save profiles in strict order
				if(!empty($employee->photo)){
					$name = md5($employee->photo->name).time().'.'.$employee->photo->extensionName;
					$employee->photo->saveAs(App::getUploadDir().$name);
					$employee->photo = $name;
				}
				$employee->save(false);
				$personal->save(false);
				$employment->save(false);
				$payroll->save(false);
                $notice->save(false);
                
                $this->redirect(array('review','id'=>$notice->id));
            }//end all valid
        }//end POST
        
        //load form
		$this->render('prepare',array(
			'notice'=>$notice,
			'employee'=>$employee,
			'personal'=>$personal,
			'employment'=>$employment,
			'payroll'=>$payroll,
			'frm'=>$form
		));
        
    }       

	
	/**
	 * Process notice uploads
	 */
	public function actionSign($id){
        $r['e'] = '0';
        try{
            if(isset($_POST['Notice'])){
                $notice = $this->loadModel($id);
                $notice->attributes = $_POST['Notice'];
                if($notice->validate()){
                    //if user is CORP and decision is approved, adopt the subprofiles
                    if('CORP' === Yii::app()->user->getState('hr_group') and $notice->decision === '1'){                        
                        $employee = Employee::model()->findByPk($notice->profile_id);
                        $employee->active_personal_id = $notice->personal_profile_id;
				        $employee->active_employment_id = $notice->employment_profile_id;
				        $employee->active_payroll_id = $notice->payroll_profile_id;
                        $employee->save(false); 
                    }
                    $notice->save(false);                    
                }else{
                    //echo var_dump($notice->getErrors());
                    $f = new CActiveForm;                    
                    throw new Exception(implode(',',$notice->getErrors()));
                }
            }    
        }catch(Exception $ex){
            $r['e'] = $ex->getMessage();
        }
        echo CJSON::encode($r);
        Yii::app()->end();	
	}

	/**
	 * Process notice uploads
	 */
	public function actionUpload(){
		//echo App::getUploadDir();exit();
		try{
			$a = array('error'=>'0');
			if(isset($_FILES['Notice'])){
				$n = new Notice;
				$n->attachments = CUploadedFile::getInstance($n,'attachments');
				$name = md5($n->attachments->name).time();
				$tmpname = $n->attachments->tempName;
				
				$n->attachments->saveAs(App::getUploadDir().$name.'.'.$n->attachments->extensionName);
				$a['gwapa'] = $n->attachments->name;
				$a['maldita'] = $name.'.'.$n->attachments->extensionName;
			}else{
				throw new Exception('Upload failed! File not set.');
			}
		}catch(Exception $ex){
			$a['error'] = $ex->getMessage();
		}
		echo CJSON::encode($a);
		Yii::app()->end();
	}
	 
	/**
	 * Get required attachments
	 */
   public function actionGetrequiredattachments($a,$b=''){
      $d = ''; 
      if(!empty($a)){
        $c = new CDbCriteria;
        $c->compare('notice_type',CHtml::encode($a));
        $c->compare('notice_sub_type',CHtml::encode($b));
        $docs = NoticeAttachment::model()->findAll($c);  
        foreach($docs as $doc){
          $d .= "<li>$doc->document</li>"; 
        }
      }
      echo $d; Yii::app()->end();   
   }     
  
	/**
	 * Reviews a notice
	 * @param str $id the notice id
	 */
	public function actionReview($id){
		$notice = $this->loadModel($id);

		$employee = Employee::model()->findByPk($notice->profile_id);
		$personal = Personal::model()->findByPk($notice->personal_profile_id);
		$employment = Employment::model()->findByPk($notice->employment_profile_id);
		$payroll = Payroll::model()->findByPk($notice->payroll_profile_id);
		
		$this->render('review',array(
			'notice'=>$notice,
			'employee'=>$employee,
			'personal'=>$personal,
			'employment'=>$employment,
			'payroll'=>$payroll,
		));
	}
  
	public function actionPrepare0($f,$e=''){
		echo '<pre>';
		$notice = new Notice;
		$notice->attributes = $_POST['Notice'];
		foreach($notice->licenses as $l){
			print_r($l);
		}
		echo '</pre>';
	}
    
    /**
     * Prepares a new notice; only two possibilities; new hire form or new change notice form; all edits must be implemented in a separate action
     * @param str $f the form: h = new hire, c = change
	 * @param str $e the employee ID     
     */
    public function actionPrepare($f,$e=''){
        //determine the form
		$notice = null;
		$employee = null;
		$personal = null;
		$employment = null;
		$payroll = null;
		$form = '';
        if($f==='h'){
            $notice = new Notice;
			$employee = new Employee;
			$personal = new Personal;
			$employment = new Employment;
			$payroll = new Payroll;
			$form = 'New Hire';		
			$notice->notice_type = 'NEW_HIRE';
            
			//unset defaults
			$notice->unsetAttributes();
			$employee->unsetAttributes();
			$personal->unsetAttributes();
			$employment->unsetAttributes();
			$payroll->unsetAttributes();
        }elseif($f==='c' and !empty($e)){
            $notice = new Notice;
			$employee = Employee::model()->findByPk(CHtml::encode($e));
			$personal = Personal::model()->findByPk($employee->active_personal_id);
			$employment = Employment::model()->findByPk($employee->active_employment_id);
			$payroll = Payroll::model()->findByPk($employee->active_payroll_id);
			$form = 'Change Notice';
            $notice->notice_type = 'CHANGE';
			
			//always force sub profiles as new profiles
			$personal->isNewRecord = true;
			$employment->isNewRecord = true;
			$payroll->isNewRecord = true;
			
			$personal->id = null;
			$employment->id = null;
			$payroll->id = null;
        }else throw new CHttpException(400,'Invalid Request');
        
        //set scenario
		$notice->scenario = 'prepare';
		$employee->scenario = 'prepare';
		$personal->scenario = 'prepare';
		$employment->scenario = 'prepare';
		$payroll->scenario = 'prepare';
		
		//handle ajax validation
		$this->performAjaxValidation(array($notice,$employee,$personal,$employment,$payroll));
        
        //handle posted data
		if(isset($_POST['Notice'])){
            $notice->attributes = $_POST['Notice'];
			$employee->attributes = $_POST['Employee'];
			$personal->attributes = $_POST['Personal'];
			$employment->attributes = $_POST['Employment'];
			$payroll->attributes = $_POST['Payroll'];
			$employee->photo = CUploadedFile::getInstance($employee,'photo');
			
			//validate
			$p0 = $notice->validate();
			$p1 = $employee->validate();
			$p2 = $personal->validate();
			$p3 = $employment->validate();
			$p4 = $payroll->validate();
			$p5 = $payroll->validatePTO($employment);
            
            if($p0 and $p1 and $p2 and $p3 and $p4 and $p5){
                //tie up and save profiles in strict order
				if(!empty($employee->photo)){
					$name = md5($employee->photo->name).time().'.'.$employee->photo->extensionName;
					$employee->photo->saveAs(App::getUploadDir().$name);
					$employee->photo = $name;
				}				
				$employee->save(false);
				$personal->emp_id = $employee->emp_id; $personal->save(false);
				$employment->emp_id = $employee->emp_id; $employment->save(false);
				$payroll->emp_id = $employee->emp_id; $payroll->save(false);
                //tie up the sub profiles to the main profile if new hire mode only
                if($notice->notice_type=='NEW_HIRE'){
                    $employee->active_personal_id = $personal->id;
    				$employee->active_employment_id = $employment->id;
    				$employee->active_payroll_id = $payroll->id;
                    $employee->save(false);
                }
                
                //create the notice
				$notice->profile_id = $employee->emp_id;
				$notice->personal_profile_id = $personal->id;
				$notice->employment_profile_id = $employment->id;
				$notice->payroll_profile_id = $payroll->id;
				$notice->save(false);
				
                //display the review page
                $this->redirect(array('review','id'=>$notice->id));

            }//end all profiles valid trap
        }//end POST
        
        
        //load form
		$this->render('prepare',array(
			'notice'=>$notice,
			'employee'=>$employee,
			'personal'=>$personal,
			'employment'=>$employment,
			'payroll'=>$payroll,
			'frm'=>$form
		));
                
    }         
    
   
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->redirect(Yii::app()->createUrl('v2/notice/review/id/'.$id));
		/* $this->render('view',array(
			'model'=>$this->loadModel($id),
		)); */
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Notice;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Notice']))
		{
			$model->attributes=$_POST['Notice'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
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

		if(isset($_POST['Notice']))
		{
			$model->attributes=$_POST['Notice'];
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
		$notice = new Notice('search');
		$notice->unsetAttributes();
		
		if(isset($_GET['Notice']))
			$notice->attributes=$_GET['Notice'];
			
		$this->render('workspace2',array('notice'=>$notice));
		/*
		$dataProvider=new CActiveDataProvider('Notice');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
		* */
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Notice('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Notice']))
			$model->attributes=$_GET['Notice'];

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
		$model=Notice::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($models)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='notice-form')
		{
			echo CActiveForm::validate($models);
			Yii::app()->end();
		}
	}
}
