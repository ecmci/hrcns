<fieldset><legend>Summary Of Changes</legend>
<?php if(!empty($notice->summary_of_changes)){ $changes = unserialize($notice->summary_of_changes); ?>
<table class="table table-condensed">
  <thead><tr><th>Data</th><th>From</th><th>To</th></tr></thead>
  <tbody>
  <?php foreach($changes as $change){     
    $info = explode('|',$change);
    $data = $info[0];
    $proposal = $info[1];
    $last_approved = $info[2];
  ?>
  <tr>
    <td><?php echo $data; ?></td><td><?php echo $proposal; ?></td><td><?php echo $last_approved; ?></td>
  </tr>
  <?php } ?>
  </tbody>
</table>
<?php }else{ echo '<p>Nothing to display</p>'; } ?>
</fieldset>