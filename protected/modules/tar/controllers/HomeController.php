<?php

class HomeController extends Controller
{
	public function actionIndex()
	{
		$this->render('home');
	}
  
  public function actionReport(){
    $this->render('report');
  }
}