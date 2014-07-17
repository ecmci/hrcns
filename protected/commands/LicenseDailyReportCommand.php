<?php
class LicenseDailyReportCommand extends CConsoleCommand{
  public function run($args){
    Yii::import('application.modules.license.components.LicenseApp');
    LicenseApp::dailyReportPooler();  
  }  
}
?>