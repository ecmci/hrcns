<?php $items = (!isset($items)) ? $model->reqItemsServices : $items; ?>
<?php echo $form->errorSummary($items); ?>
<div class="" style="max-height: 200px; overflow:scroll; ">
	<table>
		<thead><tr><td><b>Vendor</b></td><td><b>Quoted Amount</b></td><td><b>Approved?</b></td></tr></thead>
		<tbody>			
			<?php foreach($items as $i=>$item): ?>
			<tr>			
				<?php echo $form->hiddenField($item,"[$i]REQUISITION_idREQUISITION"); ?>
				<td><?php echo $form->textField($item,"[$i]vendor"); ?></td>
				<td><?php echo $form->textField($item,"[$i]qoutation"); ?></td>
				<td><?php echo $form->checkBox($item,"[$i]is_approved"); ?></td>
			</tr>
			<?php endforeach; ?>				
		</tbody>
	</table>
</div>



