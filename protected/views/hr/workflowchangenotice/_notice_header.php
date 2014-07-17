<table class="table table-condensed">
  <tr>
    <th>ID</th><td><?php //echo CHtml::link($notice->id,Yii::app()->createUrl('/hr/workflowchangenotice/view/id/'.$notice->id),array('rel'=>"tooltip", 'data-original-title'=>"View Request Details")); ?><?php echo $notice->id; ?></td>
    <th>Facility</th><td><?php echo $notice->facility; ?></td>
  </tr>
  <tr>
    <th>Type</th><td><?php echo Helper::printEnumValue($notice->notice_type); ?></td>
    <th>Employee</th><td><?php echo CHtml::link($notice->employmentProfile->emp->getFullName(),Yii::app()->createUrl('/hr/employee/view/id/'.$notice->employmentProfile->emp_id),array('rel'=>"tooltip", 'data-original-title'=>"View Profile")); ?><?php //echo $notice->employmentProfile->emp->getFullName(); ?></td>
  </tr>
  <tr>
    <th>Sub-Type</th><td><?php echo Helper::printEnumValue($notice->notice_sub_type); ?></td>
    <th>Reason</th><td><?php echo $notice->reason; ?></td>
  </tr>
  <tr>
	<th>Status</th><td colspan="3"><?php echo $notice->getStatus(); ?></td>    
  </tr>
  <tr>
    <th>Attachments</th>
    <td colspan="3">
    <?php $as = WorkflowChangeNotice::parseAttachments($notice->attachments);
      foreach($as as $i=>$attachment){
        echo '<li><i class="icon-envelope"></i> '.CHtml::link($attachment['pretty'],Yii::app()->baseUrl.'/uploads/'.$attachment['raw'],array('target'=>'_blank') ).'</li>';  
      } 
    ?>  
    </td>
  </tr>                   
</table>
