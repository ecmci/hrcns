<?php if(!empty($notice->attachments) and $notice->processing_group == 'CORP'){  ?>
<fieldset><legend>Attachments</legend> 
<ol>
<?php
  $attachments = WorkflowChangeNotice::parseAttachments($notice->attachments);
  foreach($attachments as $i=>$attachment){
    echo '<li><i class="icon-envelope"></i> '.CHtml::link($attachment['pretty'],Yii::app()->baseUrl.'/uploads/'.$attachment['raw'],array('target'=>'_blank') ).'</li>';  
  }
  echo '<p class="required" style="color:red; padding-top:10px; margin-bottom:-25px; padding-left:60px;">*</p>'.$form->fileFieldRow($notice,"docs[E-Verify]",array('class'=>'span5','required'=>'required', 'readonly'=>'readonly'));                                                      

?>
</ol>
</fieldset>
<fieldset><legend>Decisions</legend> 
<?php
 $this->renderPartial('/hr/workflowchangenotice/_comment_feed',array('notice'=>$notice));
?>
</fieldset>
<?php }else{ ?>
<?php
$docs = WorkflowChangeNotice::getDocsToAttach(!empty($type) ? $type : 'NEW_HIRE', !empty($subtype) ? $subtype : '');
?>
<fieldset title="Attachments"><legend>Attachments</legend>
  <div class="attachments">
    <p class="alert alert-error">Please make sure to attach the following files.</p>
    <table class="table">
      <?php foreach($docs as $doc){ ?>
      <tr>
        <th><?php //echo $doc->document; ?><span class="required">*</span></th>
        <td><?php echo $form->fileFieldRow($notice,"docs[$doc->document]",array('class'=>'span5','readonly'=>'readonly')) ?></td>
      </tr>      
      <?php } ?>
    </table>
  </div>
</fieldset>
<?php } ?>
