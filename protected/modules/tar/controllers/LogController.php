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
			'postOnly + delete', // we only allow deletion via POST request
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
				'actions'=>array('index'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Pure RESTful API
	 */
  public function actionIndex($id=''){ //sleep(1);
    switch($_SERVER['REQUEST_METHOD']){
      case 'GET':
        $model=new TarLog('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['TarLog']))
            $model->attributes=$_GET['TarLog'];

        $this->render('/home/_home_tar_list',array(
            'model'=>$model,
        ));
        //throw new CHttpException(501);
      break;
      case 'POST':
        $model = new TarLog;
        $model->attributes = $_POST['TarLog'];
        if($model->save()){
          echo $model->case_id;
        }else{
          $errors = array(''=>'Please correct the following:');
          foreach($model->getErrors() as $key=>$error){
            $errors[$key] = implode(', ',$error);
          }
          throw new CHttpException(500,implode("\n",$errors));
        }
      break;
      case 'PUT':
        throw new CHttpException(501);
      break;
      case 'DELETE':
        throw new CHttpException(501);
      break;
    }  
  }     

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return TarLog the loaded model
	 * @throws CHttpException
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
	 * @param TarLog $model the model to be validated
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
