<?php
Yii::app()->clientScript->registerScript('accordion',"
$( '.accordion' ).collapse({toggle:false});
",CClientScript::POS_READY);
?>

<div class="accordion" id="accordion2">
  <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne">
        1. <?php echo ($notice->timestamp_bom_signed) ? '<i class="icon-check"></i>' : '<i class="icon-refresh"></i>'; ?> Business Office Manager 
      </a>
    </div>
    <div id="collapseOne" class="accordion-body collapse in">
      <div class="accordion-inner">
        <?php if($notice->isSignable() and $notice->processing_group == 'BOM'){
           $this->widget('bootstrap.widgets.TbButton', array(
              'label'=>'Review And Edit',
              'type'=>'primary',
              'size'=>'large',
              'url'=>array('hr/employee/modify','id'=>$notice->id),
              'htmlOptions'=>array('data-dismiss'=>'modal'),
          ));     
        }else{
          $this->widget('bootstrap.widgets.TbDetailView',array(  
            'id'=>'sign-bom',
            'type'=>array('bordered','condensed'),
            'data'=>$notice,
            'attributes'=>array(
                'decision_bom:boolean',
                array('name'=>'bom_id','value'=>($notice->bom) ? $notice->bom->getFullName() : ''),
                array('name'=>'comment_bom','type'=>'raw','value'=>$notice->parseComment($notice->comment_bom)),
                array('name'=>'bom_attachment','value'=>$notice->attachment_bom ? CHtml::link($notice->attachment_bom,Yii::app()->baseUrl.'/images/employee/file/'.$notice->attachment_bom) : '', 'type'=>'raw'),
                'timestamp_bom_signed',
            ),
          ));  
        } ?>
      </div>
    </div>
  </div>
  
  <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo">
        2. <?php echo ($notice->timestamp_fac_adm_signed) ? '<i class="icon-check"></i>' : '<i class="icon-refresh"></i>'; ?> Facility Administrator 
      </a>
    </div>
    <div id="collapseTwo" class="accordion-body collapse">
      <div class="accordion-inner">
        <?php if($notice->isSignable() and $notice->processing_group == 'FAC_ADM'){
          $this->renderPartial('/hr/workflowchangenotice/_sign',array('notice'=>$notice));    
        }else{
          $this->widget('bootstrap.widgets.TbDetailView',array(
            'id'=>'sign-facadm',
            'type'=>array('bordered','condensed'),
            'data'=>$notice,
            'attributes'=>array(
                'decision_fac_adm:boolean',
                array('name'=>'fac_adm_id','value'=>($notice->facAdm) ? $notice->facAdm->getFullName() : ''),
                array('name'=>'comment_fac_adm','type'=>'raw','value'=>$notice->parseComment($notice->comment_fac_adm)),
                array('name'=>'attachment_fac_adm','value'=> $notice->attachment_fac_adm ? CHtml::link($notice->attachment_fac_adm,Yii::app()->baseUrl.'/images/employee/file/'.$notice->attachment_fac_adm) : '', 'type'=>'raw' ),
                'timestamp_fac_adm_signed',
            ),
          ));  
        } ?> 
      </div>
    </div>
  </div>
  
  <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseThree">
        3. <?php echo ($notice->timestamp_mnl_signed) ? '<i class="icon-check"></i>' : '<i class="icon-refresh"></i>'; ?> Manila Office 
      </a>
    </div>
    <div id="collapseThree" class="accordion-body collapse">
      <div class="accordion-inner">
      <?php if($notice->isSignable() and $notice->processing_group == 'MNL'){
          $this->renderPartial('/hr/workflowchangenotice/_sign',array('notice'=>$notice));    
        }else{
          $this->widget('bootstrap.widgets.TbDetailView',array(
            'id'=>'sign-mnl',
            'type'=>array('bordered','condensed'),
            'data'=>$notice,
            'attributes'=>array(
                'decision_mnl:boolean',
                array('name'=>'mnl_id','value'=>($notice->mnl) ? $notice->mnl->getFullName() : ''),
                array('name'=>'comment_mnl','type'=>'raw','value'=>$notice->parseComment($notice->comment_mnl)),          
                array('name'=>'attachment_mnl','value'=>$notice->attachment_mnl ? CHtml::link($notice->attachment_mnl,Yii::app()->baseUrl.'/images/employee/file/'.$notice->attachment_mnl) : '', 'type'=>'raw'),
                'timestamp_mnl_signed',
            ),
          ));  
        } ?>
      </div>
    </div>
  </div>
  
  <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseFour">
        4. <?php echo ($notice->timestamp_corp_signed) ? '<i class="icon-check"></i>' : '<i class="icon-refresh"></i>'; ?> HR Corporate 
      </a>
    </div>
    <div id="collapseFour" class="accordion-body collapse">
      <div class="accordion-inner">
      <?php if($notice->isSignable() and $notice->processing_group == 'CORP'){
        $this->widget('bootstrap.widgets.TbButton', array(
            'label'=>'Review And Finalize',
            'type'=>'primary',
            'size'=>'large',
            'url'=>array('hr/workflowchangenotice/view','id'=>$notice->id),
            'htmlOptions'=>array('data-dismiss'=>'modal'),
        ));    
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
              array('name'=>'attachment_corp','value'=>$notice->attachment_corp ? CHtml::link($notice->attachment_corp,Yii::app()->baseUrl.'/images/employee/file/'.$notice->attachment_corp) : '', 'type'=>'raw'),
              'timestamp_corp_signed',
          ),
        ));  
      } ?>
      </div>
    </div>
  </div>
</div>