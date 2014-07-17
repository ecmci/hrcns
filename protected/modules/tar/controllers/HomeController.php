<?php

class HomeController extends Controller
{
	public function actionIndex()
	{
		$this->render('master');
	}
  
  public function actionReport(){
    $this->render('report');
  }
}