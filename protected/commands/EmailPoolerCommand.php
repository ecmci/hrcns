<?php
class EmailPoolerCommand extends CConsoleCommand{
  public function run($args){
    Cron::poolEmails();  
  }  
}
?>