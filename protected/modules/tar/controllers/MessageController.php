<?php

class MessageController extends Controller
{
	private $api_key = '123';
  
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
				'actions'=>array('getmessages','getmessages2'),
				'users'=>array('*'),
			),
      array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('@'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
  
  /**
   * API for desktop alert client
   */    
  public function actionGetmessages($u='',$k=''){
    try{
      //trap all possible invalids
      $u = User::model()->find("username = '$u'");
      if(empty($u)){
        throw new CHttpException('401','User not found!');
      }
      if(empty($k)){
        throw new CHttpException('401','Key required!');
      }elseif($k != $this->api_key){
        throw new CHttpException('401','Wrong key!');
      }
      
      
      
      //return all unseen messages for the users
      $model = new TarMessaging('search');
      $model->to_user_id = $u->idUSER;
      $model->is_seen = '0';
      $data = array();
      $i=0;
      foreach($model->search()->getData() as $d){  
        $data[$i]['id'] = $d->id;
        $data[$i]['from'] = $d->sender->f_name.' '.$d->sender->l_name;
        $data[$i]['message'] = trim(preg_replace('/\s\s+/', ' ', strip_tags($d->message)));
        $data[$i]['timestamp'] = date('m/d/Y h:i A',strtotime($d->timestamp));
        $i++;
      }
      header('Content-type: application/json');
      echo json_encode($data);
      //Yii::app()->end(); 
    }catch(Exception $ex){
      throw $ex;
    }
  }

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$model = $this->loadModel($id);   
    if($model->is_seen == '0'){
      $model->markSeen()->save(false);
    }
      
    $this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate($t='')
	{
		$model=new TarMessaging;
    
    if(!empty($t)){
      $model->to_user_id = $t;
    }

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['TarMessaging']))
		{
			$model->attributes=$_POST['TarMessaging'];
			if($model->save()){
        $this->render('sent');
        Yii::app()->end();
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
		// $this->performAjaxValidation($model);

		if(isset($_POST['TarMessaging']))
		{
			$model->attributes=$_POST['TarMessaging'];
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
		$dataProvider=new CActiveDataProvider('TarMessaging',array(
      'criteria'=>array(
        'condition'=>"seen ="
      ),
    ));
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new TarMessaging('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['TarMessaging']))
			$model->attributes=$_GET['TarMessaging'];

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
		$model=TarMessaging::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='tar-messaging-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
