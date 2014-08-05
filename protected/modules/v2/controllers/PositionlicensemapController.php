<?php

class PositionlicensemapController extends Controller
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
		return Security::getControllerRules('position_license_map');
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
	 *  * @property string $name
 * @property string $
 * @property string $
 * @property string $
	 */
	public function actionGetmappedlicenses($p){
		$c = new CDbCriteria;
		$c->compare('position_code',CHtml::encode($p));
		$ls = PositionLicenseMap::model()->findAll($c);
		$d = '';
		$n = new Notice;
		$i=0;
		foreach($ls as $l){
			$d .= '<tr>';
			$d .= '<td>'.CHtml::activeTextField($n,'licenses['.$i.'][name]',array('class'=>'span12','value'=>$l->license_name)).'</td>';
			$d .= '<td>'.CHtml::activeTextField($n,'licenses['.$i.'][serial_number]',array('class'=>'span12')).'</td>';
			$d .= '<td>'.CHtml::activeTextField($n,'licenses['.$i.'][date_issued]',array('class'=>'span12 datepicker','placeholder'=>'YYYY-MM-DD')).'</td>';
			$now = time();
			$exp_date = (!empty($l->default_expiration)) ? date('Y-m-d',strtotime("+".$l->default_expiration,$now)) : '';
			$d .= '<td>'.CHtml::activeTextField($n,'licenses['.$i.'][date_of_expiration]',array('required'=>'required', 'class'=>'span12 datepicker','value'=>$exp_date,'placeholder'=>'YYYY-MM-DD')).'</td>';
			$d .= '</tr>';
			$i++;
		}
		echo $d;
		Yii::app()->end();
	}
	
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new PositionLicenseMap;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['PositionLicenseMap']))
		{
			$model->attributes=$_POST['PositionLicenseMap'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}
  
  public function actionCreate000() {
    $pos = Position::model()->findAll();
    foreach($pos as $p){
      $m = new PositionLicenseMap;
      $m->position_code = $p->code;
      $m->license_name = 'Annual Performance Review';
      $m->default_expiration = '12 months';
      $m->save(false); 
      //echo $p->name.',';  
    }
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

		if(isset($_POST['PositionLicenseMap']))
		{
			$model->attributes=$_POST['PositionLicenseMap'];
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
		$dataProvider=new CActiveDataProvider('PositionLicenseMap');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new PositionLicenseMap('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['PositionLicenseMap']))
			$model->attributes=$_GET['PositionLicenseMap'];

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
		$model=PositionLicenseMap::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='position-license-map-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
