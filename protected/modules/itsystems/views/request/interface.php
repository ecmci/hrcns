<table class="table table-condensed">
 <thead>
  <tr>
    <th>System</th><th>Status</th><th>Request Type</th><th></th>&nbsp;<th></th>
  </tr>
 </thead>
 <tbody>
  <?php foreach($data as $d) : ?>
  <tr>
    <td><?php echo $d->system->name; ?></td>
    <td><?php echo $d->status; ?></td>
    <td><?php echo $d->type; ?></td>
    <td><a href="<?php echo Yii::app()->createUrl('/itsystems/request/view/id/'.$d->id); ?>" rel="tooltip" title="View"><i class="icon icon-eye-open"></i></a></td>  
  </tr>
  <?php endforeach; ?>
 </tbody>
</table>
<p><?php echo CHtml::link('New',Yii::app()->createUrl('/itsystems/request/create'),array('class'=>'btn')); ?></p>