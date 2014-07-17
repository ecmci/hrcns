<?php

class SiteController extends Controller
{
	
  public function filters() {
  	return array(
  			'accessControl', 
  			);
  }
  

  public function accessRules() {
  	return AccessRules::getRules('site');  
  }
  
  public function actionCron($f){
    Yii::log("CRON Ran via WebReq from IP ".$_SERVER['REMOTE_ADDR'].' for '.$f.' schedule.');
    try{
      switch($f){
        case 'interval':
          $carbonCopy = new CarbonCopy;          
          $carbonCopy->run(array());
          Cron::poolEmails();    
        break;
        case 'daily':
          Yii::import('application.modules.license.components.LicenseApp');          
          $itsys = new ItSysNotice;
          $thirdMonth = new ThirdMonthReview;
          $annualReview = new AnnualReview;
          
          $itsys->run(array());
          $thirdMonth->run(array());
          $annualReview->run(array());
          LicenseApp::dailyReportPooler();
        break;
        case 'weekly':
          Cron::poolWeeklyReportForChangeNotice();  
        break;
      }
    }catch(Exception $ex){
      Yii::log("CRON ERROR via WebReq: ".$ex->getMessage(),'error','app');
    }
    Yii::app()->end();
  }
  
  public function actionHelp(){
    $this->render('help');  
  }
  
  public function actionCronpoolemail(){
    Cron::poolEmails();    
  }
  
  public function actionCronweeklyreport(){
    Cron::poolWeeklyReportForChangeNotice();    
  }
  
 
  public function actionTest(){
     //echo date('Y-m-d h:i:s [e]',time());
     echo md5('eva1937');
  }
  
  public function actionIndex(){
    $notice = new WorkflowChangeNotice('search');
    
    $this->render('index',array(
      'notice'=>$notice,
    ));
  }
  
  public function actionLogin(){
    /* LOGIN ALL IPs */
    Yii::log("Visitor from ".$_SERVER['REMOTE_ADDR'],'error','app');
    
    $model=new LoginForm;
    
    if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
    
    if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}

		$this->render('login',array('model'=>$model));
  }
  
  public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	} 
  
  public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
}