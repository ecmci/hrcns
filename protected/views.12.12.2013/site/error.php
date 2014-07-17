<?php
/* @var $this SiteController */
/* @var $error array */

$this->pageTitle=Yii::app()->name . ' - Error';
$this->breadcrumbs=array(
	'Error',
);
?>

<h1 class="page-header">Error <?php echo $code; ?></h1>
<div class="row-fluid">
  <ul class="thumbnails">    
    <li class="span4">
      <div class="thumbnail">
        <img alt="error.jpg" src="<?php echo Yii::app()->baseUrl; ?>/images/error.jpg">
      </div>
    </li>
    <li class="span8">
      <div class="hero-unit alert alert-error">
        <h1>Whoa $#@%*!</h1>
        <p class=""></p>
        <p class="alert alert-error"><?php echo $message; ?> (<?php echo $type; ?>)</p>
        <p class=""></p>

        <p><?php $this->widget('bootstrap.widgets.TbButton', array(
            'type'=>'primary',
            'buttonType'=>'link',
            'url'=>Yii::app()->user->returnUrl,
            'size'=>'large',
            'label'=>'Go Home',
        )); ?></p>
      </div>
    </li>
  </ul>
</div>