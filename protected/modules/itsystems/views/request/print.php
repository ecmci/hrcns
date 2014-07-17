<?php
 $this->pageTitle = 'Systems Requests ID '.$model->id;
 $this->layout = '//layouts/print_preview';
?>

<h1 class="page-header"><?php echo $model->type.' '.$model->system->name; ?> Account Request - <small><?php echo $model->status; ?></small></h1>

<table class="table">
 <tr>
  <th>ID</th><td><?php echo $model->id; ?></td>
  <th>Status</th><td><?php echo $model->status; ?></td>
 </tr>
 <tr>
  <th>Type</th><td><?php echo $model->type; ?></td>
  <th>System</th><td><?php echo $model->system->name; ?></td>
 </tr>
 
 <tr>
  <th>Processed By</th><td><?php echo ($model->activatedBy) ? $model->activatedBy->getFullName() : ''; ?></td>
  <th>Timestamp</th><td><?php echo $model->activated_timestamp; ?></td>
 </tr>
 <tr>
  <th>Deactivated By</th><td><?php echo ($model->deactivatedBy) ? $model->deactivatedBy->getFullName() : ''; ?></td>
  <th>Timestamp</th><td><?php echo $model->deactivated_timestamp; ?></td>
 </tr>
 <tr>
  <th>Notes</th><td colspan="3"><?php echo $model->printNotes(); ?></td>
 </tr>
 <tr>
  <th>Configurations</th>
  <td colspan="3">
    <?php echo $model->printConfiguration(); ?>
  </td>
 </tr>
</table>