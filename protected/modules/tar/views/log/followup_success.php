<?php
$this->layout = '//layouts/column1';
Yii::app()->clientScript->registerMetaTag("5;url=".Yii::app()->createAbsoluteUrl('tar/log'),null,'refresh'); 
?>
<div class="hero-unit">
  <h1>TAR Case Followed Up</h1>
  <p>A follow up notification has been sent for TAR Case # <?php echo $model->case_id; ?>.</p>
  <p>
    <a href="<?php echo Yii::app()->createUrl('tar/log'); ?>" class="btn btn-primary btn-large">Click here if this page is taking a long to redirect.</a>
  </p>
</div>