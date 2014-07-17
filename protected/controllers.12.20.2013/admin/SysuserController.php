<?php

class SysuserController extends Controller
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
		return AccessRules::getRules('sys_user');
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
		$model=new SysUser;
    $model_req = new ReqUser;
    $model_hr = new HrUser;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['SysUser']))
		{
			$model->attributes=$_POST['SysUser'];
      $model_req->attributes=$_POST['ReqUser'];
      $model_hr->attributes=$_POST['HrUser'];
      
      $vModel = $model->validate();
      $vModelReq = ($model->req_access == '1') ? $model_req->validate() : true;
      $vModelHr = ($model->hr_access == '1') ? $model_hr->validate() : true;
      
			if($vModel and $vModelReq and $vModelHr){
        $model->save(false);
        if($model->hr_access == '1'){
          $model_hr->user_id = $model->idUSER;
          $model_hr->save(false);  
        }
        if($model->req_access == '1'){
          $model_req->user_id = $model->idUSER;
          $model_req->save(false);  
        }
        //$this->redirect('admin');
      }
				
		}

		$this->render('create',array(
			'model'=>$model,
      'model_req'=>$model_req,
      'model_hr'=>$model_hr,
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

		if(isset($_POST['SysUser']))
		{
			$model->attributes=$_POST['SysUser'];
			if($model->save())
				//$this->redirect(array('view','id'=>$model->idUSER));
        $this->redirect(array('admin'));
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
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new SysUser('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['SysUser']))
			$model->attributes=$_GET['SysUser'];

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
		$model=SysUser::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='sys-user-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
