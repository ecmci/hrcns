<?php

class AlerttemplatesController extends Controller
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
				'actions'=>array('index','view'),
				'users'=>array('@'),
        'expression'=>'Yii::app()->user->getState("role") == "ADMIN"'
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','rest'),
				'users'=>array('@'),
        'expression'=>'Yii::app()->user->getState("role") == "ADMIN"'
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('@'),
        'expression'=>'Yii::app()->user->getState("role") == "ADMIN"'
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
  
  public function actionRest($id='',$data=''){
    switch($_SERVER['REQUEST_METHOD']){
      case 'GET':
        throw new CHttpException(501,'Not implemented');
      break;
      case 'POST':
        $model=new TarAlertsTemplate;
        $model->attributes = $_POST['TarAlertsTemplate'];
        if($model->save()){
          echo $model->id;
        }else{
          $errors = array(''=>'Please correct the following:');
          foreach($model->getErrors() as $key=>$error){
            $errors[$key] = implode(', ',$error);
          }
          throw new CHttpException(500,implode("\n",$errors));
        }
        //throw new CHttpException(501,'Not implemented');
      break;
      case 'PUT':
        $model = $this->loadModel($id);
        $put_vars = '';
        parse_str(file_get_contents("php://input"), $put_vars);        
        $model->attributes = $put_vars['TarAlertsTemplate'];
        if($model->save()){
          echo $model->id;
        }else{
          $errors = array(''=>'Please correct the following:');
          foreach($model->getErrors() as $key=>$error){
            $errors[$key] = implode(', ',$error);
          }
          throw new CHttpException(500,implode("\n",$errors));
        }      
        //throw new CHttpException(501,'Not implemented');
      break;
      case 'DELETE':
        throw new CHttpException(501,'Not implemented');
      break;
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
		$model=new TarAlertsTemplate;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['TarAlertsTemplate']))
		{
			$model->attributes=$_POST['TarAlertsTemplate'];
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
  public function actionUpdate($id){
    $this->redirect(array('view','id'=>$id));
  }
	public function actionUpdate0($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['TarAlertsTemplate']))
		{
			$model->attributes=$_POST['TarAlertsTemplate'];
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
	public function actionIndex(){
    $this->actionAdmin();
  }
  public function actionIndex0()
	{
		$dataProvider=new CActiveDataProvider('TarAlertsTemplate');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new TarAlertsTemplate('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['TarAlertsTemplate']))
			$model->attributes=$_GET['TarAlertsTemplate'];

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
		$model=TarAlertsTemplate::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='tar-alerts-template-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
