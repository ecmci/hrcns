<table class="table table-bordered">
	<tr>
		<td>
			<p><small><strong>ID</strong></small></p><?php echo $notice->id; ?>
		</td>
		<td>
			<p><small><strong>Notice</strong></small></p><?php echo App::printEnum($notice->getType()); ?>
		</td>
		<td>
			<p><small><strong>Reason</strong></small></p><?php echo $notice->reason; ?>
		</td>
		<td>
			<p><small><strong>Effective Date</strong></small></p><?php echo App::printDate($notice->effective_date); ?>
		</td>
	</tr>
	<tr>
		<td colspan="4">
			<p><small><strong>Attachments</strong></small></p>
			<ul class="nav nav-list">
			<?php foreach($notice->attachments as $k=>$a): ?>
			<li><i class="icon icon-file"></i> <?php echo $k?></li>
			<?php endforeach; ?>
			</ul>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<p><small><strong>Status</strong></small></p><?php echo $notice->getStatus(); ?>
		</td>
		<td>
			<p><small><strong>Created</strong></small></p><?php echo App::printDatetime($notice->timestamp); ?>
		</td>
		<td>
			<p><small><strong>Last Updated</strong></small></p><?php echo App::printDatetime($notice->last_updated_timestamp); ?>
		</td>
	</tr>	
</table>

