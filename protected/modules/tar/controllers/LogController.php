<?php

class LogController extends Controller
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
			array('allow',
				'actions'=>array('index','create','view','update','close','followup'),
				'users'=>array('@'),
			),
      array('allow',
				'actions'=>array('cron','test'),
				'users'=>array('*'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
  
  /**
	 * CRON job
	 */
	public function actionCron($f='daily'){
    try{
      $model = new TarLog;
      switch($f){
        case 'daily':
          $model->updateThreshold();
          $model->summarizeOpenCases();
          $model->processCustomAlerts();
        break;
        case 'weekly':
          //send open cases report to all users per facility
          $model->is_closed = '0';
          foreach(Facility::model()->findAll() as $f){
            $model->facility_id = $f->idFACILITY;
            $dataProvider = $model->reportOpenCases();
            if($dataProvider){
              $subject = 'TAR Weekly Report | Open Cases for '.Facility::model()->findByPk($f->idFACILITY);
              $message = $this->renderPartial('_weekly_report',array('dataProvider'=>$dataProvider),true);
              $users = TarUserFacility::model()->findAll("facility_id = ".$f->idFACILITY);
              if($users){
                foreach($users as $user){
                  Helper::queueMail($user->user->parentUser->username,$subject,$message);
                }  
              } 
            } 
          }
        break;
      }  
    }catch(Exception $ex){
      Yii::log('TAR Log Cron: '.$ex->getMessage(),'error','app');  
    }  
  }

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new TarLog;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['TarLog']))
		{
			$model->attributes=$_POST['TarLog'];
			if($model->save()){
        TarActivityTrail::log('Created','Created by '.Yii::app()->user->getState('user'),$model->case_id);
        $this->redirect(array('update','id'=>$model->case_id));
      }
				
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
    $posted = false; //flag to enable form controls

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['TarLog']))
		{
			$model->attributes=$_POST['TarLog'];
      $posted = true;
      
			if($model->save()){
        TarActivityTrail::log('Modified','Modified by '.Yii::app()->user->getState('user'),$model->case_id);
        $this->redirect(array('update','id'=>$model->case_id));
      }
		}

		$this->render('update',array(
			'model'=>$model,
      'posted'=>$posted
		));
	}
  
  /**
	 * Closes a particular case.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionClose($id)
	{
    $model = $this->loadModel($id);
    $model->is_cron_trigerred = true;
    
    // Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);
    
    if($model->status_id == TarLog::$STATUS_APPROVED or $model->age_in_days < 22){
      $model->close()->save(false);
      TarActivityTrail::log('Closed','Closed by '.Yii::app()->user->getState('user').'. Reason was: APPROVED',$model->case_id);
      $this->render('close_success',array('model'=>$model));
      Yii::app()->end();
    }elseif(isset($_POST['TarLog'])){
      $model->attributes = $_POST['TarLog'];
      $model->scenario = 'close';
      if($model->validate()){
        $model->close()->save(false);
        TarActivityTrail::log('Closed','Closed by '.Yii::app()->user->getState('user').'. Reason was: '.$model->reason_for_closing,$model->case_id);
        $this->render('close_success',array('model'=>$model));
        Yii::app()->end();  
      }   
    }
    
    $this->render('close',array('model'=>$model));  
	}
  
  /**
	 * Sends a follow up notice for a particular case.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionFollowup($id){
    $model = $this->loadModel($id);
    $model->scenario = 'followup';
    
    // Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);
    
    if(isset($_POST['TarLog'])){
      $model->attributes = $_POST['TarLog'];
      if($model->validate()){
        $model->followUp();
        TarActivityTrail::log('Follow Up','Follow Up by '.Yii::app()->user->getState('user').'. Message was: '.$model->message,$model->case_id);
        $this->render('followup_success',array('model'=>$model));
        Yii::app()->end();
      }
    }
    
    $this->render('followup',array('model'=>$model));  
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
  public function actionIndex(){
    $this->actionAdmin();
  }
	public function actionIndex0()
	{
		$dataProvider=new CActiveDataProvider('TarLog');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new TarLog('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['TarLog']))
			$model->attributes=$_GET['TarLog'];

		$this->render('home',array(
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
		$model=TarLog::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='tar-log-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
