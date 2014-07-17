<div class="row-fluid">
  <?php $this->widget('bootstrap.widgets.TbButtonGroup', array(
        'type'=>'primary', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
        'size'=>'medium',
        'buttons'=>array(
            array('label'=>'Workflow Actions', 'items'=>array(
                array('label'=>'Notice',),
                array('label'=>'View Details', 'url'=>array('hr/workflowchangenotice/view','id'=>$notice->id)),
                array('label'=>'Print', 'url'=>array('hr/workflowchangenotice/print','id'=>$notice->id)),                
                '---',
                array('label'=>'ADMIN',),
                array('label'=>'Override','url'=>'#','linkOptions'=>array('submit'=>array('hr/workflowchangenotice/override','id'=>$notice->id),'confirm'=>"Are you sure you want to OVERRIDE this notice?\n\nWARNING: Overriding removes signatures, attachment and comments on the workflow depending on what stage it needs to regress.")),
            ),'icon'=>'question-sign white',
            'htmlOptions'=>array('rel'=>'tooltip','title'=>'What do you want to do?'),),
        ),
    )); ?>
  <br><br>
  <?php $this->renderPartial('/hr/workflowchangenotice/_notice_header',array('notice'=>$notice));  ?>
  <h4>Workflow Thread <small>(Click An Item Below to Expand)</small></h4>
  <?php (isset($print)) ? include_once '_workflow_feed.php' : include_once '_workflow_feed_accordion.php'; ?>
  <?php $this->widget('bootstrap.widgets.TbButtonGroup', array(
        'type'=>'primary', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
        'dropup'=>true,
        'size'=>'medium',
        'buttons'=>array(
            array('label'=>'Workflow Actions', 'items'=>array(
                array('label'=>'Notice',),
                array('label'=>'View Details', 'url'=>array('hr/workflowchangenotice/view','id'=>$notice->id)),
                array('label'=>'Print', 'url'=>array('hr/workflowchangenotice/print','id'=>$notice->id)),                
                '---',
                array('label'=>'ADMIN',),
                array('label'=>'Override','url'=>'#','linkOptions'=>array('submit'=>array('hr/workflowchangenotice/override','id'=>$notice->id),'confirm'=>"Are you sure you want to OVERRIDE this notice?\n\nWARNING: Overriding removes signatures, attachment and comments on the workflow depending on what stage it needs to regress.")),
            ),'icon'=>'question-sign white',
            'htmlOptions'=>array('rel'=>'tooltip','title'=>'What do you want to do?'),),
        ),
    )); ?> 
</div>