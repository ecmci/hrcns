<style>
table.container{
	font:12pt arial,sans-serif;
	width: 850px;
	height:auto;
}
table.child{
	font:12pt arial,sans-serif;
	width: 840px;
	height:auto;
	margin:0 auto;	
}
thead th{font-weight:bold; text-align:center;color:white; background:black;}
td.header{text-align:center;font-weight:bold;border-bottom:1px solid black;}
table.child thead td{border-bottom:1px solid black;}
img.logo{width:auto;height:60px;position:relative;float:left;}
/*table td{border:1px solid #DEE3DE;padding:5px;}*/
table{border:1px solid #fff;border-collapse:collapse;}
td.label{font-weight:bold;width:250px;}
td.note{min-width:300px;}
.right{text-align:right;}
.center{text-align:center;}
.header{font-size:10pt; text-align:center;font-weight:bold;border-bottom:1px solid black;}
</style>
<?php
$reqtype = ($model->REQTYPE_idREQTYPE == '1') ? 'PO' : 'SO'; //hardcoded
//items
$items="<table class='child'>";
$purchased = "<table class='child'>";
switch($reqtype){
	case 'PO':		
		$items.="<thead><tr>";
		$items.="<th>Item#</th><th>Qty.</th><th>Unit</th><th>Item Name</th><th>Specifications</th><th>Reason</th><th>Unit Price</th><th>Total Price</th>";
		$items.="</tr></thead>";
		
		$purchased.="<thead><tr><td><b>Item#</b></td><td><b>Purchased?</b></td><td><b>Subtituted</b></td><td><b>Price</b></td><td><b>Vendor</b></td>";
		$purchased.="</tr></thead>";
		foreach($children as $item){
			$items.="<tr>";
			$items.="<td>$item->item_num</td>";
			$items.="<td>$item->quantity</td>";
			$items.="<td>$item->unit</td>";
			$items.="<td>$item->item_name</td>";
			$items.="<td>$item->specification</td>";
			$items.="<td>$item->reason</td>";
			$items.="<td>".$this->formatNumber($item->price_estimate)."</td>";
			$items.="<td>".$this->formatNumber($item->quantity * $item->price_estimate)."</td>";
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
		
		$purchased.="<thead><tr><th>Vendor</th><th>Qoutation</th><th>Approved</th>";
		$purchased.="</tr></thead>";

		foreach($children as $item){
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
		<td class="header" colspan="4"><img class="logo" src="<?=Yii::app()->baseUrl.'/images/eva-logo.png'?>" />
		<h2><?=($reqtype=='PO') ? 'Purchase' : 'Service'?> Request Form</h2></td>
	</tr>
	<tr>
		<td colspan="4">&nbsp;</td>		
	</tr>
	<tr>
		<td colspan="4">&nbsp;</td>		
	</tr>
	<tr>
		<td colspan="4">&nbsp;</td>		
	</tr>
	<tr>
		<td class="label">Title</td>
		<td colspan="3"><?=$model->title?></td>
	</tr>
	<tr>
		<td class="label">Date Request</td>
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
		<td  class="label">Priority Reason (if urgent):</td>
		<td colspan="3"><?=$model->priority_reason?></td>		
	</tr>
	<?php if($reqtype=='SO'): ?>
	<tr>
		<td  class="label">Project Name:</td>
		<td colspan="3"><?=$model->project_name?></td>		
	</tr>
	<tr>
		<td  class="label">Project Description:</td>
		<td colspan="3"><?=$model->service_description?></td>		
	</tr>
	<?php endif; ?>
	<tr>
		<td colspan="4">&nbsp;</td>		
	</tr>
	<tr>
		<td colspan="4">&nbsp;</td>		
	</tr>
	<tr>
		<td colspan="4">&nbsp;</td>		
	</tr>
	<tr>
		<td colspan="4"><?=$items?></td>		
	</tr>
	<tr>
		<td colspan="4">&nbsp;</td>		
	</tr>
	<tr>
		<td colspan="4">&nbsp;</td>		
	</tr>
	<tr>
		<td colspan="4">&nbsp;</td>		
	</tr>
	<tr>
		<td class="label" colspan="2">CEO Signed</td>
		<td style="border-bottom:1px solid black;"></td>
	</tr>
	<tr>
		<td></td>
		<td class="center" colspan="3">(Signature over printed name)</td>		
	</tr>
	<tr>
		<td class="label" colspan="2">Date:</td>
		<td style="border-bottom:1px solid black;"></td>
	</tr>
	<tr>
		<td class="label" colspan="2">Note:</td>
		<td style="border-bottom:1px solid black;"></td>
	</tr>
</table>
<p><button onclick="window.print()">Print</button></p>
