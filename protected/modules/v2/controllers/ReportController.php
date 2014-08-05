<?php

class ReportController extends Controller
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
		return Security::getControllerRules('report');
	}
	
	public function actionView($r)
	{
		$d = null;
		$view = '';
		switch($r){
			case '1': 	$view = 'union'; $d = Report::getUnionEmployees(); break;
			case '2': 	$view = 'dob'; break;
			default: throw new CHttpException(401,'Report not found!');
		}
		
		$this->render($view,array(
			'dataProvider'=>$d,
		));
	}
	
	public function actionIndex()
	{
		$this->render('index');
	}
}
