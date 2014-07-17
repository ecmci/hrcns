<?php
/* @var $this SiteController */
/* @var $error array */

$this->pageTitle=Yii::app()->name . ' - Success';
$this->breadcrumbs=array(
	'Success',
);
$this->layout = '//layouts/column1';
?>

<h1 class="page-header"><?php echo $code; ?></h1>
<div class="row-fluid">
  <ul class="thumbnails">    
    <li class="span4">
      <div class="thumbnail">
        <img alt="success-kid.jpg" src="<?php echo Yii::app()->baseUrl; ?>/images/success-kid.jpg">
      </div>
    </li>
    <li class="span8">
      <div class="thumbnail alert alert-success">
        <h2>That went well!</h2>
        <p class=""><?php echo $message; ?></p>
      </div>
    </li>
  </ul>
</div>