<?php

class RequisitionModule extends CWebModule
{
	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'requisition.models.*',
      'requisition.models._base.*',
      'requisition.extensions.giix-components.*',
      'requisition.extensions.giix-core.*',
      'requisition.extensions.htmltableui.*',
      'requisition.extensions.jphpmailer.*',
      'requisition.extensions.mbmenu.*',
      'requisition.extensions.phpmailer.*',
      'requisition.extensions.YiiConditionalValidator.*',
      'requisition.extensions.yii-pdf.*',
      'requisition.extensions.EMailer',
			'requisition.extensions.TabularInputManager',
      'requisition.components.*'
		));
    
    // set layout
    $this->setLayoutPath(Yii::getPathOfAlias('webroot.themes.yii-bootstrap.views.layouts'));
    
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
