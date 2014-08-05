<fieldset><legend><small>Business Office Manager</small></legend>
	<blockquote>
		<p>Approves: <?php echo $notice->decision_bom == '1' ? 'Yes' : 'No'; ?></p>
		<p><?php echo $notice->comment_bom; ?></p>		
		<p><small><?php echo $notice->bom ? $notice->bom->getFullName() : ''; ?> <?php echo App::printDatetime($notice->timestamp_bom_signed); ?></small></p>
	</blockquote>
</fieldset>

<fieldset><legend><small>Facility Administrator</small></legend>
	<blockquote>
		<p>Approves: <?php echo $notice->decision_fac_adm == '1' ? 'Yes' : 'No'; ?></p>
		<p><?php echo $notice->comment_fac_adm; ?></p>		
		<p><small><?php echo $notice->facadm ? $notice->facadm->getFullName() : ''; ?> <?php echo App::printDatetime($notice->timestamp_fac_adm_signed); ?></small></p>
	</blockquote>
</fieldset>

<fieldset><legend><small>AR Manila</small></legend>
	<blockquote>
		<p>Approves: <?php echo $notice->decision_mnl == '1' ? 'Yes' : 'No'; ?></p>
		<p><?php echo $notice->comment_mnl; ?></p>		
		<p><small><?php echo $notice->mnl ? $notice->mnl->getFullName() : ''; ?> <?php echo App::printDatetime($notice->timestamp_mnl_signed); ?></small></p>
	</blockquote>
</fieldset>

<fieldset><legend><small>HR Corporate</small></legend>
	<blockquote>
		<p>Approves: <?php echo $notice->decision_corp == '1' ? 'Yes' : 'No'; ?></p>
		<p><?php echo $notice->comment_corp; ?></p>		
		<p><small><?php echo $notice->corp ? $notice->corp->getFullName() : ''; ?> <?php echo App::printDatetime($notice->timestamp_corp_signed); ?></small></p>
	</blockquote>
</fieldset>
