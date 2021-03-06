<?php

class HomeController extends Controller
{
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
                'actions'=>array('index','report'),
                'users'=>array('@'),
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }
 
  public function actionIndex()
	{
    $this->redirect('tar/log');    
	}
  
  public function actionReport(){
    $this->render('report');
  }
}