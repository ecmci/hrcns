<?php

class RequestController extends Controller
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
				'actions'=>array('index','view','admin','create','print','report','cancel'),
				'users'=>array('@'),
			),
			array('allow', 
				'actions'=>array('delete','process'),
				'users'=>array('@'),
        'expression'=>'ItSysHelper::isAdmin()',
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
  
  public function actionTest(){
    ItSysCron::noticeRequestPoolerCron();
    //$s = array('1','4');
    //echo CJSON::encode($s);
    //$str = '["1","4"]';
    //echo print_r(CJSON::decode($str));
  }
  
  public function actionReport(){
    $model = new Request('search');
    $model->unsetAttributes();
    
    if(isset($_GET['Request'])) $model->attributes = $_GET['Request'];
    
    $this->render('report',array('model'=>$model));
  }
  
  public function actionCancel($id){
    $model = $this->loadModel($id);
    $model->scenario = 'cancel';
    $class = '';
    $message = '';
    if($model->save()){
      $class = 'alert alert-success';
      $message = 'Request ID '.$id.' has been successfully cancelled.';  
    }else{
      $class = 'alert alert-error';
      $f = new CActiveForm;
      $message = 'Request ID '.$id.' cannot be cancelled. '.$f->errorSummary($model,'Errors:'); 
    }
    echo "<div class='$class'>$message</div>";
    Yii::app()->end();
  }
  
  public function actionPrint($id){
    $model = $this->loadModel($id);
    
    $this->render('print',array('model'=>$model));
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
		$model=new Request;

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['Request']))
		{
			$model->attributes=$_POST['Request'];
			if($model->validate()){
        $model->submitRequest();
        $this->redirect(array('admin'));
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

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['Request']))
		{
			$model->attributes=$_POST['Request'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}
  
  public function actionProcess($id){
		$model=$this->loadModel($id);
    $model->scenario = 'process';

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['Request']))
		{
			$model->attributes=$_POST['Request'];
			if($model->validate()) {
        $model->process()->save(false);
        $this->redirect(array('view','id'=>$model->id));  
      }
				
		}

		$this->render('process',array(
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
	{   $this->actionAdmin();
// 		$dataProvider=new CActiveDataProvider('Request');
// 		$this->render('index',array(
// 			'dataProvider'=>$dataProvider,
// 		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Request('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Request']))
			$model->attributes=$_GET['Request'];

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
		$model=Request::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='request-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
