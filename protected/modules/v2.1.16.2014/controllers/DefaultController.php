<?php

class DefaultController extends Controller
{
	public function actionIndex()
	{
		$this->redirect(Yii::app()->createUrl('/v2/notice'));
	}
}
