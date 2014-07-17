<table class="table table-condensed">
 <thead>
  <tr>
    <th>Name</th><th>Serial #</th><th>Issued</th><th>Expiration</th>&nbsp;<th></th>
  </tr>
 </thead>
 <tbody>
  <?php foreach($data as $d) : ?>
  <tr class="<?php echo $d->alert == '1' ? 'alert alert-error' : ''; ?>"">
    <td><?php echo $d->name; ?></td>
    <td><?php echo $d->serial_number; ?></td>
    <td><?php echo $d->date_issued; ?></td>
    <td><?php echo $d->date_of_expiration; ?></td>
    <td><a href="<?php echo Yii::app()->createUrl('/license/license/update/id/'.$d->id); ?>" rel="tooltip" title="Update"><i class="icon icon-pencil"></i></a></td>
  </tr>
  <?php endforeach; ?>
 </tbody>
</table>
<p><?php echo CHtml::link('New',Yii::app()->createUrl('/license/license/create'),array('class'=>'btn')); ?></p>