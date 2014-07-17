<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>

  <div class="row-fluid">
  	<div class="span2">
  		<div class="sidebar-nav">        
  		  <?php $this->widget('zii.widgets.CMenu', array(
    			/*'type'=>'list',*/
    			'encodeLabel'=>false,
    			'items'=>array(
    				// Include the operations menu
    				array('label'=>'Actions','items'=>$this->menu),
    			),
    			));?>
  		</div> 
    </div><!--/span-->
    <div class="span10">    
    <?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
            'links'=>$this->breadcrumbs,
      			'homeLink'=>CHtml::link('Main'),
      			'htmlOptions'=>array('class'=>'breadcrumb')
              )); ?><!-- breadcrumbs -->
          <?php endif?>
    
    <!-- Include content pages -->
    <?php echo $content; ?>

	 </div><!--/span-->
  </div><!--/row-->


<?php $this->endContent(); ?>