<?php
$activities = new TarActivityTrail;  
$activities->log_case_id = $model->case_id;
?>
<?php $this->widget('bootstrap.widgets.TbGridView',array(
    'id'=>'tar-activity-trail-grid',
    'dataProvider'=>$activities->getActivity(),
    'filter'=>$activities,
    'columns'=>array(
        //'id',
        array('name'=>'action','filter'=>false),
        array('name'=>'message','filter'=>false),
        array('name'=>'timestamp','filter'=>false),
    ),
)); ?> 