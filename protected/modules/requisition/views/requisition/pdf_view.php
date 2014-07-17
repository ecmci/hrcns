<?php
$this->pageTitle = Yii::app()->name.' | Requisition | ID '.$model->idREQUISITION;
$this->layout = 'column1';
Yii::app()->clientScript->registerScript('printme',"
  window.print();
",CClientScript::POS_READY);
?>
<style>
table.container{
	font:8pt arial,sans-serif;
	width: 850px;
	height:auto;
}
table.child{
	font:8pt arial,sans-serif;
	min-width: 425px;
	height:auto;
	margin:0 auto;	
}
thead{font-weight:bold; text-align:center;}
td.header{text-align:center;font-weight:bold;border-bottom:1px solid black;}
table.child thead td{border-bottom:1px solid black;}
img.logo{width:auto;height:60px;position:relative;float:left;}
/*table td{border:1px solid #DEE3DE;padding:5px;}
table{border:1px solid #DEE3DE;border-collapse:collapse;}*/
td.label{font-weight:bold;width:250px;}
td.note{min-width:300px;}
.right{text-align:right;}
.header{font-size:10pt; text-align:center;font-weight:bold;border-bottom:1px solid black;}
</style>
<?php
$reqtype = $model->rEQTYPEIdREQTYPE->acronym;
//items
$items="<table class='child'>";
$purchased = "<table class='child'>";
switch($reqtype){
	case 'PO':		
		$items.="<thead><tr>";
		$items.="<td><b>Item#</b></td><td><b>Qty.</b></td><td><b>Unit</b></td><td><b>Item Name</b></td><td><b>Specifications</b></td><td><b>Reason</b></td><td><b>Unit Price</b></td><td><b>Total Price</b></td>";
		$items.="</tr></thead>";
		
		$purchased.="<thead><tr><td><b>Item#</b></td><td><b>Purchased?</b></td><td><b>Subtituted</b></td><td><b>Price</b></td><td><b>Vendor</b></td>";
		$purchased.="</tr></thead>";
		foreach($model->reqItemsPurchases as $item){
			$items.="<tr>";
			$items.="<td>$item->item_num</td>";
			$items.="<td>$item->quantity</td>";
			$items.="<td>$item->unit</td>";
			$items.="<td>$item->item_name</td>";
			$items.="<td>$item->specification</td>";
			$items.="<td>$item->reason</td>";
			$items.="<td>$item->price_estimate</td>";
			$items.="<td>".($item->quantity * $item->price_estimate)."</td>";
			$items.="</tr>";
			
			$purchased .= "<tr>";
			$purchased .= "<td>$item->item_num</td>";
			$purchased .= "<td>".(($item->is_purchased=='1')?'Yes':'No')."</td>";
			$purchased .= "<td>".(($item->is_substitute=='1')?'Yes':'No')."</td>";
			$purchased .= "<td>".((Yii::app()->user->getState('role')== 'ST' or Yii::app()->user->getState('role')== 'A') ? '':$item->price_availed)."</td>";
			$purchased .= "<td>".((Yii::app()->user->getState('role')== 'ST' or Yii::app()->user->getState('role')== 'A') ? '':$item->vendor_availed_from)."</td>";
			$purchased .= "</tr>";
		}
	break;
	case 'SO':		
		$items.="<thead><tr>";
		$items.="<td><b>Vendor</b></td><td><b>Qoutation</b></td>";
		$items.="</tr></thead>";
		
		$purchased.="<thead><tr><td><b>Vendor</b></td><td><b>Qoutation</b></td><td><b>Approved</b></td>";
		$purchased.="</tr></thead>";

		foreach($model->reqItemsServices as $item){
			$items.="<tr>";
			$items.="<td>$item->vendor</td>";
			$items.="<td>$item->qoutation</td>";
			$items.="</tr>";
			
			$purchased .= "<tr>";
			$purchased .= "<td>$item->vendor</td>";
			$purchased .= "<td>$item->qoutation</td>";
			$purchased .= "<td>".(($item->is_approved=='1')?'Yes':'No')."</td>";
			$purchased .= "</tr>";
		}
	break;
}
$items.="</table>";
$purchased .= "</table>";
?>
<table class="container"></caption>
	<tr>
		<td class="header" colspan="4"><img class="logo" src="<?=Yii::app()->baseUrl.'/images/logo-eva.gif'?>" />
		<h2><?=($reqtype=='PO') ? 'Purchase' : 'Service'?> Order Form</h2></td>
	</tr>
	<tr>
		<td class="label">Title</td>
		<td colspan="3"><?=$model->title?></td>
	</tr>
	<tr>
		<td class="label">Date Posted</td>
		<td colspan="3"><?=$model->date_posted?></td>
	</tr>
	<tr>
		<td class="label">Facility</td>
		<td colspan="3"><?=$model->fACILITYIdFACILITY->title?></td>
	</tr>
	<tr>
		<td class="label">Initiated By</td>
		<td colspan="3"><?=$model->uSERIdUSERSignReq->getFullName()?></td>
	</tr>
	<tr>
		<td class="label">Preferred Vendor</td>
		<td colspan="3"><?=$model->preferred_vendor?></td>
	</tr>
	<tr>
		<td  class="label">Supply / Service Needed:</td>
		<td colspan="3"><?=$model->pRIORITYIdPRIORITY->title." : ".$model->pRIORITYIdPRIORITY->description?></td>		
	</tr>
	<tr>
		<td colspan="4"><?=$items?></td>		
	</tr>
	<tr>
		<td class="header" colspan="4">Facilty</td>
	</tr>
	<tr>		
		<td class="label">Note</td><td colspan="3" class="note"><?=$model->note_admin?></td>		
	</tr>
	<tr>
		<td class="label">Facility Auth:</td><td colspan="3"><?=($model->uSERIdUSERSignAdmin!=null)?$model->uSERIdUSERSignAdmin->getFullName().' ('.$model->date_sign_admin.')':''?></td>
	</tr>
	<tr>
		<td  class="header" colspan="4">Decision</td>
	</tr>
	<tr>
		<td class="label">P.O.#:</td><td colspan="3"><?=$model->po_num?></td>
	</tr>
	<tr>		
		<td class="label">AP MNL Note</td><td colspan="3" class="note"><?=$model->note_apmnl?></td>		
	</tr>
	<tr>
		<td class="label">AP MNL Auth:</td><td colspan="3"><?=($model->uSERIdUSERSignApmnl!=null)?$model->uSERIdUSERSignApmnl->getFullName().' ('.$model->date_sign_apmnl.')':''?></td>
	</tr>
	
	<tr>		
		<td class="label">AP CORP Note</td><td colspan="3" class="note"><?=$model->note_apcorp?></td>		
	</tr>
	<tr>
		<td class="label">AP CORP Auth:</td><td colspan="3"><?=($model->uSERIdUSERSignApcorp!=null)?$model->uSERIdUSERSignApcorp->getFullName().' ('.$model->date_sign_apcorp.')':''?></td>
	</tr>
	<tr>
		<td  class="header" colspan="4">Purchasing</td>
	</tr>
	<tr>
		<td class="label">Confirmation#:</td><td colspan="3"><?=$model->confirmation_number?></td>
	</tr>
	<?php if($reqtype=='PO'):?>
	<tr>
		<td class="label">Order Date:</td><td colspan="3"><?=$model->order_date?></td>
	</tr>
	<tr>
		<td class="label">Est. Delivery Date:</td><td colspan="3"><?=$model->estimated_delivery_date?></td>
	</tr>
	<?php endif; ?>
	<?php if($reqtype=='SO'):?>
	<tr>
		<td class="label">Completion Date:</td><td colspan="3"><?=$model->completion_date?></td>
	</tr>
	<?php endif; ?>

	<tr>
		<td colspan="4"><?=$purchased?></td>
	</tr>
	<tr>		
		<td class="label">Purchasing Note</td><td colspan="3" class="note"><?=$model->note_purch?></td>		
	</tr>
	<tr>
		<td class="label">Purchased By:</td><td colspan="3"><?=($model->uSERIdUSERSignPurch!=null)?$model->uSERIdUSERSignPurch->getFullName().' ('.$model->date_sign_purch.')':''?></td>
	</tr>
	<tr>
		<td  class="header" colspan="4">Receiving</td>
	</tr>
	<tr>		
		<td class="label">Receiver Note</td><td colspan="3" class="note"><?=$model->note_rcvr?></td>		
	</tr>
	<tr>
		<td class="label">Received By:</td><td colspan="3"><?=($model->uSERIdUSERSignRcvr!=null)?$model->uSERIdUSERSignRcvr->getFullName().' ('.$model->date_sign_rcvr.')':''?></td>
	</tr>
	<tr>
		<td  class="header" colspan="4">Billing</td>
	</tr>
	<tr>	
		<td class="label">Billed?</td><td><?=($model->is_billed=='1')?'Yes':'No'?></td>	
		<td class="label right">Invoice#</td><td><?=$model->invoice_number?></td>			
	</tr>	
	<tr>		
		<td class="label">Biller Note</td><td colspan="3" class="note"><?=$model->note_apinv?></td>		
	</tr>
	<tr>
		<td class="label">Received By:</td><td colspan="3"><?=($model->uSERIdUSERSignApinv!=null)?$model->uSERIdUSERSignApinv->getFullName().' ('.$model->date_sign_apinv.')':''?></td>
	</tr>
	

</table>

