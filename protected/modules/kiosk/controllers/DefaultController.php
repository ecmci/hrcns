<?php

class DefaultController extends Controller
{
	public function actionIndex()
	{
		$this->render('index');
    //echo Helper::getUploadsDir();
	}
}