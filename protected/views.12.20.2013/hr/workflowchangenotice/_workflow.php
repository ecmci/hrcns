<?php $uploadsDir = Helper::getBaseUploadsUrl(); ?>
<?php
Yii::app()->clientScript->registerScript('nice2',"

  var windowHeight = $(window).height()-275;
  $('#scroll-workflow').height(windowHeight);

",CClientScript::POS_READY);
?>
<div id="scroll-workflow">      
  <fieldset><legend>1. <small>Business Office Manager</small></legend>
  <?php if($notice->isSignable() and $notice->processing_group == 'BOM'){
    $this->renderPartial('_sign',array('notice'=>$notice));    
  }else{
    $this->widget('bootstrap.widgets.TbDetailView',array(  
      'id'=>'sign-bom',
      'type'=>array('bordered','condensed'),
      'data'=>$notice,
      'attributes'=>array(
          'decision_bom:boolean',
          array('name'=>'bom_id','value'=>($notice->bom) ? $notice->bom->getFullName() : ''),
          array('name'=>'comment_bom','type'=>'raw','value'=>$notice->parseComment($notice->comment_bom)),
          array('name'=>'bom_attachment','value'=>$notice->attachment_bom ? CHtml::link($notice->attachment_bom,$uploadsDir.$notice->attachment_bom) : '', 'type'=>'raw'),
          'timestamp_bom_signed',
      ),
    ));  
  } ?>                          
  </fieldset>
  <fieldset><legend>2. <small>Facility Administrator</small></legend>
  <?php if($notice->isSignable() and $notice->processing_group == 'FAC_ADM'){
    $this->renderPartial('_sign',array('notice'=>$notice));    
  }else{
    $this->widget('bootstrap.widgets.TbDetailView',array(
      'id'=>'sign-facadm',
      'type'=>array('bordered','condensed'),
      'data'=>$notice,
      'attributes'=>array(
          'decision_fac_adm:boolean',
          array('name'=>'fac_adm_id','value'=>($notice->facAdm) ? $notice->facAdm->getFullName() : ''),
          array('name'=>'comment_fac_adm','type'=>'raw','value'=>$notice->parseComment($notice->comment_fac_adm)),
          array('name'=>'attachment_fac_adm','value'=> $notice->attachment_fac_adm ? CHtml::link($notice->attachment_fac_adm,$uploadsDir.$notice->attachment_fac_adm) : '', 'type'=>'raw' ),
          'timestamp_fac_adm_signed',
      ),
    ));  
  } ?>                 
  </fieldset>
  <fieldset><legend>3. <small>Manila</small></legend>
  <?php if($notice->isSignable() and $notice->processing_group == 'MNL'){
    $this->renderPartial('_sign',array('notice'=>$notice));    
  }else{
    $this->widget('bootstrap.widgets.TbDetailView',array(
      'id'=>'sign-mnl',
      'type'=>array('bordered','condensed'),
      'data'=>$notice,
      'attributes'=>array(
          'decision_mnl:boolean',
          array('name'=>'mnl_id','value'=>($notice->mnl) ? $notice->mnl->getFullName() : ''),
          array('name'=>'comment_mnl','type'=>'raw','value'=>$notice->parseComment($notice->comment_mnl)),          
          array('name'=>'attachment_mnl','value'=>$notice->attachment_mnl ? CHtml::link($notice->attachment_mnl,$uploadsDir.$notice->attachment_mnl) : '', 'type'=>'raw'),
          'timestamp_mnl_signed',
      ),
    ));  
  } ?>                      
  </fieldset>
  <fieldset><legend>4. <small>HR Corporate</small></legend>
  <?php if($notice->isSignable() and $notice->processing_group == 'CORP'){
    $this->renderPartial('_sign',array('notice'=>$notice));    
  }else{
    $this->widget('bootstrap.widgets.TbDetailView',array(
      'id'=>'sign-corp',
      'type'=>array('bordered','condensed'),
      'data'=>$notice,
      'attributes'=>array(
          'decision_corp:boolean',
          //array('name'=>'corp_id','value'=>($notice->corp) ? $notice->corp->getFullName() : ''),
          'corp_id',
          array('name'=>'comment_corp','type'=>'raw','value'=>$notice->parseComment($notice->comment_corp)),
          array('name'=>'attachment_corp','value'=>$notice->attachment_corp ? CHtml::link($notice->attachment_corp,$uploadsDir.$notice->attachment_corp) : '', 'type'=>'raw'),
          'timestamp_corp_signed',
      ),
    ));  
  } ?>                         
  </fieldset>
</div>