<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Login';
$this->breadcrumbs=array(
	'Login',
);
//nice scroll updates container
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/nicescroll/jquery.nicescroll.min.js');
Yii::app()->clientScript->registerScript('nicescrollinit',"
$(document).ready(function(){
  $('#updates-feed').height($(window).height()-160);
  $('#updates-feed').niceScroll();

});
");                 
?>

<div class="row-fluid">  
  <div class="span4">
    <fieldset><legend>Account Login</legend>
    <?php $this->renderPartial('_login_form',array('model'=>$model)); ?>
    </fieldset>
  </div>
  
  <div class="span8">
    <fieldset><legend>Updates <small>(Updates)</small></legend>
      <div id="updates-feed">
      <?php $this->renderPartial('_announcement'); ?>
      </div>
    </fieldset>
  </div>
  
    
</div>
