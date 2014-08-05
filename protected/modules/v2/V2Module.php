<?php

class V2Module extends CWebModule
{
	public $assetsPath;
	
	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'v2.models.*',
			'v2.components.*',
			'application.models.*',
			'application.components.*',
		));
		$this->assetsPath = Yii::app()->assetManager->publish(Yii::getPathOfAlias('application.modules.v2.assets'));
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else
			return false;
	}
}
