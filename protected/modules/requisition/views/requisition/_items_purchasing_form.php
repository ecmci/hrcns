<script type="text/javascript">
	function remind(i){
		if($('#subcheck'+i).is(":checked")){
			alert('Don\'t forget to inform the facility about this item substitute.');
		}else{console.log('not checked but clicked=#subcheck['+i+']')}
	}
</script>
<?php $items = (!isset($items)) ? $model->reqItemsPurchases : $items; ?>
<?php echo $form->errorSummary($items); ?>
<div class="" style="max-height: 200px; overflow:scroll; ">
	<table>
		<thead><tr><td><b>Item#</b></td><td><b>Vendor</b></td><td><b>Price</b></td><td><b>Purchased?</b></td><td><b>Substitute?</b></td></tr></thead>
		<tbody>			
			<?php foreach($items as $i=>$item): ?>
			<tr>			
				<?php echo $form->hiddenField($item,"[$i]idREQ_PURCHASE"); ?>
				<?php echo $form->hiddenField($item,"[$i]REQUISITION_idREQUISITION"); ?>
				<?php echo $form->hiddenField($item,"[$i]item_num"); ?>
				<?php echo $form->hiddenField($item,"[$i]quantity"); ?>
				<?php echo $form->hiddenField($item,"[$i]unit"); ?>
				<?php echo $form->hiddenField($item,"[$i]item_name"); ?>
				<?php echo $form->hiddenField($item,"[$i]specification"); ?>
				<?php echo $form->hiddenField($item,"[$i]price_estimate"); ?>
				<?php echo $form->hiddenField($item,"[$i]reason"); ?>
				
				<td><?php echo $form->textField($item,"[$i]item_num",array('disabled'=>'disabled')); ?></td>
				<td><?php echo $form->textField($item,"[$i]vendor_availed_from",array('required'=>'required')); ?></td>
				<td><?php echo $form->textField($item,"[$i]price_availed",array('required'=>'required')); ?></td>
				<td><?php echo $form->checkBox($item,"[$i]is_purchased"); ?></td>
				<td><?php echo $form->checkBox($item,"[$i]is_substitute",array('id'=>"subcheck$i",'onclick'=>"remind($i)")); ?></td>					
			</tr>
			<?php endforeach; ?>				
		</tbody>
	</table>
</div>
<p class="hint"><b>Vendor</b> - Name of the supplier</p>
<p class="hint"><b>Price</b> - Availed price from the supplier</p>



