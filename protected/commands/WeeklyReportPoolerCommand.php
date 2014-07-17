<?php
class WeeklyReportPoolerCommand extends CConsoleCommand{
  public function run($args){
    Cron::poolWeeklyReportForChangeNotice();  
  }
}
?>