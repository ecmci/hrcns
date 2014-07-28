<?php
$this->layout = '//layouts/column1';
Yii::app()->clientScript->registerMetaTag("5;url=".Yii::app()->createAbsoluteUrl('tar/message'),null,'refresh'); 
?>
<div class="hero-unit">
  <h1>Message sent.</h1>
  <p></p>
  <p>
    <a href="<?php echo Yii::app()->createUrl('tar/message'); ?>" class="btn btn-primary btn-large">Click here if this page is taking a long to redirect.</a>
  </p>
</div>