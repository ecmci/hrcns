<?php

class RequisitionController extends GxController {

public function filters() {
	return array(
			'accessControl', 
			);
}

public function accessRules() {
	return array(
			array('allow',
				'actions'=>array('index','view','test','getpdf','getprintableform','postsavenote'),
				'users'=>array('@'),
				),
			array('allow',
				'actions'=>array('signfacility'),
				'expression'=>"Yii::app()->user->getState('role')=='CE' || Yii::app()->user->getState('role')=='A' || Yii::app()->user->getState('role')=='SA'",//facility admin or sys admin
				),
			array('allow',
				'actions'=>array('signapmnl','signinv'),
				'expression'=>"Yii::app()->user->getState('role')=='CE' || Yii::app()->user->getState('role')=='S' || Yii::app()->user->getState('role')=='SA'",//AP -MNL or sys admin
				),
			array('allow',
				'actions'=>array('signapcorp','signinv'),
				'expression'=>"Yii::app()->user->getState('role')=='CE' || Yii::app()->user->getState('role')=='CL' || Yii::app()->user->getState('role')=='SA'",//AP -CORP or sys admin
				),
			array('allow',
				'actions'=>array('signpurch', 'updateitemsajax'),
				'expression'=>"Yii::app()->user->getState('role')=='M' || Yii::app()->user->getState('role')=='EDC' || Yii::app()->user->getState('role')=='SA'",//PURCHASING or sys admin
				),
			array('allow',
				'actions'=>array('signrcvr'),
				'expression'=>"Yii::app()->user->getState('role')=='ST' || Yii::app()->user->getState('role')=='A' || Yii::app()->user->getState('role')=='SA'",//facility staff or facility admin or sys admin
				),
			array('allow', 
				'actions'=>array('minicreate', 'createpo','createso','admin','cancelrequest'),
				'users'=>array('@'),
				),
			array('allow', 
				'actions'=>array('update','delete'),
				//'users'=>array('admin'),
				'expression'=>"Yii::app()->user->getState('role')=='SA'",
				),
			array('deny', 
				'users'=>array('*'),
				),
			);
}

	public function actionView($id) {
		$id = ($id=='')? '0' : $id;
		$model = $this->loadModel($id, 'Requisition');
		switch($model->sTATUSIdSTATUS->acronym){
			case 'N': 	$model->scenario='signfacility'; break;
			case 'W': 	$model->scenario='signapmnl'; break;
			case 'WC': 	$model->scenario='signapcorp'; break;
			case 'A': 	if($model->REQTYPE_idREQTYPE=='1')
							$model->scenario='signpurch';
						else
							$model->scenario='signpurchso';			
			break;
			case 'P': $model->scenario='signrcvr'; break;
			case 'R': $model->scenario='signinv'; break;
		}
		//echo "scenario=".$model->scenario.' for status='.$model->sTATUSIdSTATUS->acronym;
		$this->render('view', array(
			'model' => $model,
		));
	}

	public function actionCreatepo() {
		$model = new Requisition;
		$model->REQTYPE_idREQTYPE = '1';//PO: hardcoded from db table reqtype
		$model->scenario = 'createpo';
		$items=$this->getItems();
		
		//$this->performAjaxValidation($model,'requisition-form');
		
		if (isset($_POST['Requisition'])) {
			$model->setAttributes($_POST['Requisition']);			
			$validItems = true;
			$total = 0;			
			foreach($items as $i=>$item){		
				if($i==0) $model->title = $item->item_name;
				$validItems = $validItems && $item->validate();
				$total += $item->quantity * $item->price_estimate;
			}
			$isValidParent = $model->validate();
			
			//check amount policy
			switch($this->checkTotalAtFacility($total)){
				case '0': $model->addError('','This request is just below $200.00.'); $validItems = false; break;
				case '1': if(!isset($_POST['uploads']) and Yii::app()->user->getState('role')=='A'){ //if f.admin is logged in and no attachment
					$model->addError('','A request amounting to $5,000 and up needs an attached approval from the CEO. Please secure an approval authorization first and attach it here afterwards.'); 
					$validItems = false; 
				}
				break;
			}
			
			//additional validations
			if(Yii::app()->user->getState('role')=='A' and strlen($model->note_admin) < 2){
				$model->addError('note_admin','Admin Notes is required.');
				$isValidParent = false;
			}

			if ($isValidParent && $validItems) {
				if (Yii::app()->getRequest()->getIsAjaxRequest())
					Yii::app()->end();
				else{	
					$model->USER_idUSER_sign_req = Yii::app()->user->id;
					$model->date_posted = new CDbExpression('NOW()');
					
					//determine who is submitting this and set status accordingly
					if(Yii::app()->user->getState('role')=='A'){//facility admin
						$model->STATUS_idSTATUS = $this->getStatusIDFromAcronym('W');		
						$model->USER_idUSER_sign_admin = Yii::app()->user->id;
						$model->date_sign_admin = new CDbExpression('NOW()');	
					}else if(Yii::app()->user->getState('role')=='S'){//AP MNL
						$model->STATUS_idSTATUS = $this->getStatusIDFromAcronym('WC');		
						$model->USER_idUSER_sign_admin = Yii::app()->user->id;
						$model->date_sign_admin = new CDbExpression('NOW()');
						$model->USER_idUSER_sign_apmnl = Yii::app()->user->id;
						$model->date_sign_apmnl = new CDbExpression('NOW()');
					}else{
						$model->STATUS_idSTATUS = $this->getStatusIDFromAcronym('N');
					}
					
					$model->save(false);
					foreach($items as $item){
						$item->REQUISITION_idREQUISITION = $model->idREQUISITION;
						$item->save(false);
					}
					
					if(isset($_POST['uploads'])){
						foreach($_POST['uploads'] as $file){
							$attch = new AttachmentReq;
							$attch->REQUISITION_idREQUISITION = $model->idREQUISITION;
							$attch->filename = $file;
							$attch->save(false);
						}
					}
					
					$this->notify($model->STATUS_idSTATUS,$model->idREQUISITION);
					
					$this->redirect(array('view', 'id' => $model->idREQUISITION));
				}
			}
		}

		$this->render('create',array(
			'model'=>$model,
			'items'=>$items,
		));
	}
	
	public function actionCreateso(){
		$model = new Requisition;
		$model->REQTYPE_idREQTYPE = '2';//SO: hardcoded from db table reqtype
		$model->scenario='createso';
		$vendors = $this->getVendors();
		
		//$this->performAjaxValidation(array($model,$items),'requisition-form');
		
		if(isset($_POST['Requisition'])){
			$model->attributes = $_POST['Requisition'];
			$validParent = $model->validate();
			$validChildren = true;
			$largest_amount = 0;
			foreach($vendors as $i=>$item){	
				$item->scenario = 'createso';
				$v = $item->validate();
				$largest_amount = (is_numeric($item->qoutation) && ($item->qoutation > $largest_amount)) ? $item->qoutation : $largest_amount;
				$validChildren = $validChildren && $v;
			}
			//check min vendors
			if(sizeof($vendors)<2){
				$model->addError('','Please provide at least two vendors.');
				$validParent=false;
			}
			
			//check amount policy
			switch($this->checkTotalAtFacility($largest_amount)){
				case '0': $model->addError('','This request is just below $200.00.'); $validChildren = false; break;
				case '1': if(!isset($_POST['uploads']) and Yii::app()->user->getState('role')=='A'){ //if f.admin is logged in and no attachment
					$model->addError('','A request amounting to $5,000 and up needs an attached approval from the CEO. Please secure an approval authorization first and attach it here afterwards.'); 
					$validChildren = false; 
				}
				break;
			}
			
			//additional validations
			if(Yii::app()->user->getState('role')=='A' and strlen($model->note_admin) < 2){
				$model->addError('note_admin','Admin Notes is required.');
				$validChildren = false;
			}
			
			if($validParent and $validChildren){
				if (Yii::app()->getRequest()->getIsAjaxRequest())
					Yii::app()->end();
				else{
					$model->title = $model->project_name;
					$model->USER_idUSER_sign_req = Yii::app()->user->id;
					$model->date_posted = new CDbExpression('NOW()');
					
					//determine who is submitting this and set status accordingly
					if(Yii::app()->user->getState('role')=='A'){//facility admin
						$model->STATUS_idSTATUS = $this->getStatusIDFromAcronym('W');		
						$model->USER_idUSER_sign_admin = Yii::app()->user->id;
						$model->date_sign_admin = new CDbExpression('NOW()');	
					}else if(Yii::app()->user->getState('role')=='S'){//AP MNL
						$model->STATUS_idSTATUS = $this->getStatusIDFromAcronym('WC');		
						$model->USER_idUSER_sign_admin = Yii::app()->user->id;
						$model->date_sign_admin = new CDbExpression('NOW()');
						$model->USER_idUSER_sign_apmnl = Yii::app()->user->id;
						$model->date_sign_apmnl = new CDbExpression('NOW()');
					}else{
						$model->STATUS_idSTATUS = $this->getStatusIDFromAcronym('N');
					}
					
					$model->save(false);
					foreach($vendors as $vendor){
						$vendor->REQUISITION_idREQUISITION = $model->idREQUISITION;
						$vendor->save(false);
					}
					
					if(isset($_POST['uploads'])){
						foreach($_POST['uploads'] as $file){
							$attch = new AttachmentReq;
							$attch->REQUISITION_idREQUISITION = $model->idREQUISITION;
							$attch->filename = $file;
							$attch->save(false);
						}
					}
					
					$this->notify($model->STATUS_idSTATUS,$model->idREQUISITION);
					
					$this->redirect(array('view', 'id' => $model->idREQUISITION));

				}
			}
			
		}

		$this->render('create',array(
			'model'=>$model,
			'vendors'=>$vendors,
		));
	}
	
	public function actionUpdate($id) {
		$model = $this->loadModel($id, 'Requisition');

		$this->performAjaxValidation($model, 'requisition-form');

		if (isset($_POST['Requisition'])) {
			$model->setAttributes($_POST['Requisition']);

			if ($model->save()) {
				$this->redirect(array('view', 'id' => $model->idREQUISITION));
			}
		}

		$this->render('update', array(
				'model' => $model,
				));
	}

	public function actionDelete($id) {
		if (Yii::app()->getRequest()->getIsPostRequest()) {
			$this->loadModel($id, 'Requisition')->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('admin'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}
	
	public function actionCancelrequest($id){
		if (Yii::app()->getRequest()->getIsPostRequest()) {
			$model = $this->loadModel($id,'Requisition');
			if($model->sTATUSIdSTATUS->acronym=='P' or $model->sTATUSIdSTATUS->acronym=='R' or $model->sTATUSIdSTATUS->acronym=='I'){
				echo "Aborted! This request is already ".$model->sTATUSIdSTATUS->description.".";
			}elseif(strlen($_POST['reason']) < 2){
				echo "A reason is required.";
			}else{
				$model->STATUS_idSTATUS = '8';//hardcoded from status table				
				$model->USER_idUSER_cancel =Yii::app()->getRequest()->getPost('uid');
				$model->datetime_cancel = new CDbExpression('NOW()');
				$model->cancel_reason = Yii::app()->getRequest()->getPost('reason');
				
				$this->notify($model->STATUS_idSTATUS,$model->idREQUISITION);
				
				echo $model->save(false);
			}

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('admin'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));			
	}

	public function actionIndex() {
		/*
		$dataProvider = new CActiveDataProvider('Requisition');
		$this->render('index', array(
			'dataProvider' => $dataProvider,
		));
		*/
		$this->actionAdmin();
	}

	public function actionAdmin() {
		$model = new Requisition('search');
		$model->unsetAttributes();

		if (isset($_GET['Requisition']))
			$model->setAttributes($_GET['Requisition']);

		$this->render('admin', array(
			'model' => $model,
		));
	}
	
	public function actionSignfacility(){
		if(!isset($_POST['rid'])) exit();
		$rid = $_POST['rid'];
		$req = Requisition::model()->find("idREQUISITION=$rid");
		$req->scenario = 'signfacility';
		
		//$this->performAjaxValidation($req, 'req-sign-facility');
		
		$sts = (isset($_POST['s'])) ? $_POST['s'] : $this->getStatusIDFromAcronym('N');
	
		if(isset($_POST['Requisition'])){
			$req->attributes = $_POST['Requisition'];
			$req->note_admin = ($req->note_admin === '-') ? '' : $req->note_admin;
			$valid = $req->validate(); 
			$amount_to_check = ($req->REQTYPE_idREQTYPE=='1') ? $req->getItemsTotal($req->idREQUISITION) : $req->getLargestQoutAmt();//hardcoded reqtype id from reqtype table
			if($this->checkTotalAtFacility($amount_to_check) == '1' and !isset($_POST['uploads'])){
				$req->addError('','A request amounting to $5,000 and up needs an attached approval from the CEO. Please secure an approval authorization first and attach it here afterwards.'); 
				$valid = false;
			}
			
			
			if($valid){
				//save parent
				
				/*
				* Workflow Override, SG and GD
				* Requests from SG and GD will be routed directly to AP Corp temporarily upon facility admin's approval.
				* Requested By: Jimmy Hoesan 
				* Implemented: 3.26.2013 by Steven Ly
				*/
				//if GD or SG, route to AP Corp
				/*
				try{
					if($req->FACILITY_idFACILITY == '3' or $req->FACILITY_idFACILITY == '8'){
						$sts = '9';
						Yii::log("Workflow Override to StsID $sts | ReqID $rid | FaciID ".$req->FACILITY_idFACILITY,'info','app');
					}
				}catch(Exception $ex){
					Yii::log("Workflow Override ReqID $rid | Error: ".$ex->getMessage(),'info','app');
				}
				*/
				
				$req->STATUS_idSTATUS = $sts;
				$req->USER_idUSER_sign_admin = Yii::app()->user->getState('id');
				$req->date_sign_admin = new CDbExpression('NOW()');
				$req->save(false);
				
				if(isset($_POST['uploads'])){
					foreach($_POST['uploads'] as $file){
						$attch = new AttachmentFacAdmin;
						$attch->REQ_idREQ = $req->idREQUISITION;
						$attch->filename = $file;
						$attch->save(false);
					}
				}
				
				//notify
				$this->notify($sts,$rid);
				
				//redirect to view
				$this->redirect(array('view','id'=>$rid,));
			}
		}
		$this->render('view',array('id'=>$rid,'model'=>$req,'hash'=>'facility'));
	}

	public function actionSignapmnl(){
		if(!isset($_REQUEST['rid']))exit();
		$rid = $_REQUEST['rid'];
		$model = $this->loadModel($rid,'Requisition');
		$model->scenario = 'signapmnl';
		$status = (isset($_POST['s'])) ? $_POST['s'] : "";
		
		if(isset($_POST['Requisition'])){
			$model->attributes = $_POST['Requisition'];			
			
			if($model->validate()){
				$model->USER_idUSER_sign_apmnl = Yii::app()->user->id;
				$model->date_sign_apmnl = new CDbExpression('NOW()');
				$model->STATUS_idSTATUS=$status;
				$model->save(false);
				if(isset($_POST['uploads'])){
					foreach($_POST['uploads'] as $file){
						$attch = new AttachmentDecApmnl;
						$attch->REQUISITION_idREQUISITION = $model->idREQUISITION;
						$attch->filename = $file;
						$attch->save(false);
					}
				}
				
				//notify
				$this->notify($status,$rid);
				
				$this->redirect(array('view','id'=>$rid,));				
			}
		}

		
		$this->render('view',array('model'=>$model,'hash'=>'ap'));
	}
	
	public function actionSignapcorp(){
		if(!isset($_REQUEST['rid']))exit();
		$rid = $_REQUEST['rid'];
		$model = $this->loadModel($rid,'Requisition');		
		$model->scenario = 'signapcorp';
		$status = (isset($_POST['s'])) ? $_POST['s'] : "";
		
		if(isset($_POST['Requisition'])){
			$model->attributes = $_POST['Requisition'];			
			
			if($model->validate()){
				$model->USER_idUSER_sign_apcorp = Yii::app()->user->id;
				$model->date_sign_apcorp = new CDbExpression('NOW()');
				$model->STATUS_idSTATUS=$status;
				$model->save(false);
				if(isset($_POST['uploads'])){
					foreach($_POST['uploads'] as $file){
						$attch = new AttachmentDecApcorp;
						$attch->REQUISITION_idREQUISITION = $model->idREQUISITION;
						$attch->filename = $file;
						$attch->save(false);
					}
				}
				
				//notify
				$this->notify($status,$rid);
				
				$this->redirect(array('view','id'=>$rid,));				
			}
		}

		$this->render('view',array('model'=>$model,'hash'=>'ap'));
	}
	
	public function actionSignpurch(){
		if(!isset($_REQUEST['rid']))exit();
		$rid = $_REQUEST['rid'];
		$model = $this->loadModel($rid,'Requisition');		
		$model->scenario = ($model->REQTYPE_idREQTYPE=='1') ? 'signpurch' : 'signpurchso';//hardcoded id from reqtype table		
		$status = (isset($_POST['s'])) ? $_POST['s'] : "";
		$items = ($model->REQTYPE_idREQTYPE=='1') ? $this->getItems() : $this->getServiceVendors();

		if(isset($_POST['Requisition'])){
			$model->attributes = $_POST['Requisition'];

			if($model->REQTYPE_idREQTYPE=='1') { 	
				$valid = $model->validate();
				$valid = $this->isValidPODate($model->order_date, $model->estimated_delivery_date, $model);
			}elseif($model->REQTYPE_idREQTYPE=='2'){
				$valid = $model->validate();
			}				
			
			$validItems = true;
			$checkedVendors = 0;
			foreach($items as $item){	
				$item->scenario = 'signpurch';
				$validItems = $validItems and $item->validate();
				if($model->REQTYPE_idREQTYPE=='2' and $item->is_approved=='1') {
					$checkedVendors++;
				}
			}
			
			if($model->REQTYPE_idREQTYPE=='2' and $checkedVendors == 0 and $status=='6'){//hardcoded id from status table
				$model->addError('','Please approve at least one vendor');
				$valid=false;
			}
			
			//$valid = false;
			if($valid and $validItems){
				$model->USER_idUSER_sign_purch = Yii::app()->user->id;
				$model->date_sign_purch = new CDbExpression('NOW()');
				$model->STATUS_idSTATUS=$status;
				$model->save(false);

				
				if(isset($_POST['uploads'])){
					foreach($_POST['uploads'] as $file){
						$attch = new AttachmentOrder;
						$attch->REQUISITION_idREQUISITION = $model->idREQUISITION;
						$attch->filename = $file;
						$attch->save(false);
					}
				}
				
				$c = new CDbCriteria;
				$c->condition = "REQUISITION_idREQUISITION=$model->idREQUISITION";
				if($model->REQTYPE_idREQTYPE=='1'){//hardcoded id from reqtype table					
					ReqItemsPurchase::model()->deleteAll($c,null);
				}elseif($model->REQTYPE_idREQTYPE=='2'){
					ReqItemsService::model()->deleteAll($c,null);
				}				
				foreach($items as $item){					
					$item->REQUISITION_idREQUISITION = $model->idREQUISITION;
					$item->save(false);
				}
				
				
				//notify
				$this->notify($status,$rid);
				
				$this->redirect(array('view','id'=>$rid,));				
			}
		}

		$this->render('view',array('model'=>$model,'items'=>$items,'hash'=>'purchasing'));
	}
	
	public function actionSignrcvr(){
		if(!isset($_REQUEST['rid']))exit();
		$rid = $_REQUEST['rid'];
		$model = $this->loadModel($rid,'Requisition');		
		$model->scenario = 'signrcvr';
		$status = (isset($_POST['s'])) ? $_POST['s'] : "";
		
		if(isset($_POST['Requisition'])){
			$model->attributes = $_POST['Requisition'];
			$valid = $model->validate();
			if($model->REQTYPE_idREQTYPE=='2' and $model->has_agreed_tos=='0' and strlen($model->note_rcvr) < 2){
				$valid = false;
				$model->addError('note_rcvr','Please provide a reason why you were not satisfied with the service.');
			}
			if($status != $this->getStatusIDFromAcronym('R')){
				$model->addError('','This request can\'t be cancelled at this stage.');$valid=false;
			}
			if($valid){
				$model->STATUS_idSTATUS=$status;
				$model->USER_idUSER_sign_rcvr = Yii::app()->user->id;
				$model->date_sign_rcvr = new CDbExpression('NOW()');
				$model->save(false);
				
				$this->notify($status,$rid);
				
				$this->redirect(array('view','id'=>$rid,));
			}
		}
		
		
		
		$this->render('view',array('model'=>$model,'hash'=>'received'));
	}

	public function actionSigninv(){
		if(!isset($_REQUEST['rid']))exit();
		$rid = $_REQUEST['rid'];
		$model = $this->loadModel($rid,'Requisition');		
		$model->scenario = 'signinv';
		$status = (isset($_POST['s'])) ? $_POST['s'] : "";
		
		if(isset($_POST['Requisition'])){
			$model->attributes = $_POST['Requisition'];
			$valid = $model->validate();
			
			if(!isset($_POST['uploads']) and $model->REQTYPE_idREQTYPE=='1'){//hardcoded id from reqtype table
				$model->addError('','An attached invoice(s) is required.');
				$valid = false;
			}
			
			if($status != $this->getStatusIDFromAcronym('I')){
				$model->addError('','This request must be invoiced at this stage.');$valid=false;
			}
			
			if($valid){
				$model->STATUS_idSTATUS=$status;
				$model->USER_idUSER_sign_apinv = Yii::app()->user->id;
				$model->date_sign_apinv = new CDbExpression('NOW()');
				$model->save(false);
				
				if(isset($_POST['uploads'])){
					foreach($_POST['uploads'] as $file){
						$attch = new AttachmentInv;
						$attch->REQUISITION_idREQUISITION = $model->idREQUISITION;
						$attch->filename = $file;
						$attch->save(false);
					}
				}
				
				$this->notify($status,$rid);
				
				$this->redirect(array('view','id'=>$rid,));
			}
		}
		
		$this->render('view',array('model'=>$model,'hash'=>'billing'));
	}
	
	public function actionGetpdf($id){
		$model = Requisition::model()->findByPk($id);
		//Yii::import('ext.yii-pdf.EYiiPdf');
		//$this->renderPartial('pdf_view', array('model'=>$model));
		
		//$mPDF1 = Yii::app()->ePdf->mpdf('', 'letter');
    //$mPDF1 = new EYiiPdf();
    //$mPDF1->mpdf('', 'letter'); 
		//mPDF($mode,$format,$default_font_size,$default_font,$mgl,$mgr,$mgt,$mgb,$mgh,$mgf, $orientation)
		
		
		//$mPDF1 = Yii::app()->ePdf->mpdf('', 'Letter', 8, 'arial', 12.7, 12.7, 14, 12.7, 8, 8);
    //$mPDF1 = new EYiiPdf();
    //$mPDF1 = $mPDF1->mpdf('', 'Letter', 8, 'arial', 12.7, 12.7, 14, 12.7, 8, 8);
		//$mPDF1->WriteHTML($this->renderPartial('pdf_view', array('model'=>$model), true));
		//$mPDF1->Output();
		$this->render('pdf_view', array('model'=>$model));
	}

		public function actionGetprintableform(){
		$model = new Requisition;
		$model->setAttributes($_GET['Requisition']);
		
		//force assign attributes		
		$model->REQTYPE_idREQTYPE = (isset($_GET['ReqItemsPurchase'])) ? '1' : '2';//hardcoded id from tbl reqtype
		$model->date_posted = date('M d, Y',time());
		$model->USER_idUSER_sign_req = Yii::app()->user->getState('id');
		
		$items = array();
		switch($model->REQTYPE_idREQTYPE){
			case '1':
				foreach($_GET['ReqItemsPurchase'] as $i=>$item){					
					$items[$i] = new ReqItemsPurchase;
					$items[$i]->attributes = $_GET['ReqItemsPurchase'][$i];
					if($i==0) $model->title = $items[$i]->item_name;
				}
			break;
			case '2':
				foreach($_GET['ReqItemsService'] as $i=>$item){
					$items[$i] = new ReqItemsService;
					$items[$i]->attributes = $_GET['ReqItemsService'][$i];				
				}
			break;
		}
		
		
		
		$this->renderPartial('print_view',array(
			'model'=>$model,
			'children'=>$items,
		));
		
		//echo "<pre>";print_r($model->attributes);echo "</pre>";
	}

	//helpers
	private function getStatusIDFromAcronym($acronym){
		$criteria=new CDbCriteria;
		$criteria->select='idSTATUS'; 
		$criteria->condition='acronym=:acronym';
		$criteria->params=array(':acronym'=>$acronym);
		$s=Status::model()->find($criteria); 
		return $s->idSTATUS;
	}
	
	protected function getItems(){
		if(!isset($_POST['ReqItemsPurchase'])){
			$items[] = new ReqItemsPurchase;
			return $items;
		}else{
			$yItems[] = null;
			$items = $_POST['ReqItemsPurchase'];
			foreach($items as $i=>$item){
				$yItems[$i] = new ReqItemsPurchase;
				$yItems[$i]->attributes = $_POST['ReqItemsPurchase'][$i];				
			}
			return $yItems;
		}
	}
	
	protected function getServiceVendors(){
		if(!isset($_POST['ReqItemsService'])){
			$items[] = new ReqItemsService;
			return $items;
		}else{
			$yItems[] = null;
			$items = $_POST['ReqItemsService'];
			foreach($items as $i=>$item){
				$yItems[$i] = new ReqItemsService;
				$yItems[$i]->attributes = $_POST['ReqItemsService'][$i];				
			}
			return $yItems;
		}

	}

	protected function getVendors(){
		if(!isset($_POST['ReqItemsService'])){
			$items[] = new ReqItemsService;
			$items[] = new ReqItemsService;
			return $items;
		}else{
			$yItems[] = null;
			$items = $_POST['ReqItemsService'];
			foreach($items as $i=>$item){
				$yItems[$i] = new ReqItemsService;
				$yItems[$i]->attributes = $_POST['ReqItemsService'][$i];				
			}			
			return $yItems;
		}
	}

	private function checkTotalAtFacility($total){
		//implements the 200-5000up amount policy
		if($total < 200) return "2";//error
		if($total >= 5000) return "1";//require Dr. B attachment
		return "k";
	}

	public static function checkUserAccess($status_id, $group_id){		
		$criteria=new CDbCriteria;		
		$criteria->condition="STATUS_idSTATUS=$status_id AND GROUP_idGROUP=$group_id";	
		return StatusGroupAccess::model()->exists($criteria);			
	}
		
	public function getStatusesForm($id){
		$sql = "SELECT s.idSTATUS, s.title, s.acronym\n"
			. "from `authority` a\n"
			. "join `status` s on s.idSTATUS = a.STATUS_idSTATUS\n"
			. "where a.GROUP_idGROUP = (select GROUP_idGROUP from `user` where idUSER = $id) order by s.ordering asc";
		//echo $sql;exit();
		$res = Yii::app()->db->createCommand($sql);
		$res = $res->query();
		$selector = "<select name='s'>";
		foreach($res as $r)$selector .= "<option value='".$r['idSTATUS']."'>".$r['acronym']." - ".$r['title']."</option>";
		$selector .= "</select>";
		return $selector;
	}
	
	public function actionPostsavenote(){
				
		if(!isset($_COOKIE['PHPSESSID']))
			throw new CHttpException(403, Yii::t('app', 'You are not allowed to perform this action.'));
		try{		
			$model = $this->loadModel(Yii::app()->request->getPost('id'), 'Requisition');			
			$note = "\n\n\n(Saved ".date('Y-m-d H:i').")"." - ".Yii::app()->request->getPost('note')."";		
			switch(Yii::app()->request->getPost('stage')) {
				case 'facility' : 
					$model->note_admin = $note;
				break;
				case 'apmnl':
					$model->note_apmnl = $note;
				break;
				case 'apcorp':
					$model->note_apcorp = $note;
				break;
				case 'purchasing':
					$model->note_purch = $note;
				break;
				default: Yii::app()->end();
			}	
			
			$model->save(false);		
			$data = array(
				'error'=>'0',
				'msg'=>$note,				
			);
		}catch(Exception $ex){
			$data = array(
				'error'=>'1',
				'msg'=>$ex->getMessage(),
			);
		}
		echo json_encode($data); //sleep(5);
		Yii::app()->end();
	}

	public function actionTest(){
    throw new CHttpException(400,'Impossible');
	}
	

	private function notify($sts,$rid){
		try{
			$r = Requisition::model()->findByPk($rid);
			
			//current management decision is to email every status update to the next signing group
			//echo "email=".($r->pRIORITYIdPRIORITY->acronym == 'H' or $r->sTATUSIdSTATUS->acronym == 'D');
			//if($r->pRIORITYIdPRIORITY->acronym == 'H' or $r->sTATUSIdSTATUS->acronym == 'D'){
				//compose email
				$status = $r->sTATUSIdSTATUS->title;
				$url = Yii::app()->createAbsoluteUrl('form/requisition/view/',array('id'=>$rid));
				$facility = $r->fACILITYIdFACILITY->acronym;				
				$subject = "Request # $rid - $facility | Status Updated to '$status'";
				$message = "<p>Hello,</p>";
				$message .= "<p></p>";
				$message .= "<p>Request # $rid has been updated to status '$status'.</p>";
				$message .= "<p>Request Details:</p>";
				$message .= "<ul>";
				$message .= "<li>ID: $rid</li>";
				$message .= "<li>Title: ".$r->title."</li>";
				$urgent = ($r->pRIORITYIdPRIORITY->acronym=='H')?'Yes':'No';
				$message .= "<li>Urgent: $urgent</li>";
				$message .= "<li>Status: ".$status."</li>";
				$message .= "<li>Priority: ".$r->pRIORITYIdPRIORITY->title."</li>";
				$message .= "<li>Signature Needed: ".$r->pRIORITYIdPRIORITY->description." upon posting date of this request.</li>";
				$message .= "</ul>";
				$message .= "<p></p>";
				$message .= "<p>For more details, click the link below:</p>";
				$message .= "<p><a href='$url'>$url</a></p>";
				$message .= "<p></p>";
				$message .= "<p>Best Regards,</p>";
				$message .= "<p>Eva Care Group Requisition</p>";
				
        //queue email
				$params['status_code'] = $r->sTATUSIdSTATUS->acronym;
				$params['status_id'] = $r->STATUS_idSTATUS;
				$params['rid'] = $rid;
				$emails = $this->getAddresses($params);
        foreach($emails as $email){
				  Helper::queueMail($email,$subject,$message);	
				}
         
				

// 				//instantiate PHPMailer
// 				$mailer = Yii::createComponent('application.extensions.EMailer');
// 				$mailer->IsHTML(true);
// 				$mailer->CharSet = 'UTF-8';
// 				$mailer->From = Yii::app()->params['ap_email'];
// 				$mailer->FromName = 'Eva Care Group Requisition';		
// 				$mailer->Subject = $subject;
// 				$mailer->Body = $message;
// 
// 				
// 				$params['status_code'] = $r->sTATUSIdSTATUS->acronym;
// 				$params['status_id'] = $r->STATUS_idSTATUS;
// 				$params['rid'] = $rid;
// 				$emails = $this->getAddresses($params);
// 				//echo '<pre>';print_r($emails);echo '</pre>';
// 				$rcpts = '';				
// 				foreach($emails as $email){
// 					$mailer->AddAddress($email);
// 					$rcpts .= ", ".$email;
// 					//echo $email.'<br>';
// 				}
// 				Yii::log("ID=".$rid." Status=".$status." | Notified: $rcpts",'info','app');
// 				//exit();
// 				//echo $subject;exit();
// 				//echo $message;exit();
// 				
// 
// 				//workaround bug for nobody to email
// 				//$mailer->AddAddress(Yii::app()->params['adminEmail']);
// 
// 				//mass email
// 				if($mailer->Send()){
// 					//echo "yey!";
// 				}else{
// 					//echo "bohuu!";
// 				}
// 			//}
		}catch(Exception $e){
			//echo $e->getMessage();
			Yii::log($e->getMessage(),'info','app');
			}	
			
	}
	
	private function getAcronymFromStatusID($id){
		$criteria=new CDbCriteria;
		$criteria->select='acronym'; 
		$criteria->condition='idSTATUS=:idSTATUS';
		$criteria->params=array(':idSTATUS'=>$id);
		$s=Status::model()->find($criteria); 
		return $s->acronym;
	}
	
	private function getAddresses($params){
		$emails = array();
		$email_facility_admin = false;
		$email_approving_group = false;
		switch($params['status_code']){
			case "N": case "P": case "D": case "H": case "C": case "I"://equivalent ids: 1,6,5,?,8,11
				$email_facility_admin = true;
			break;
			case "W": case "A": case "R": case "WC": case "WE":  case "R": case "AE"://eq. ids: 2,3,7,9,10,7,12
				$email_approving_group = true;
			break;			
		}
		
		//email facility only when needed
		//echo "status_code=".$params['status_code']."<br>";
		//echo "email_facility_admin=".$email_facility_admin;
		if($email_facility_admin){			
			$sql = "SELECT u.username
				FROM `user` u
				JOIN `user_facility` uf ON uf.USER_idUSER = u.idUSER
				JOIN `requisition` r ON r.FACILITY_idFACILITY = uf.FACILITY_idFACILITY
				WHERE u.GROUP_idGROUP = (
				SELECT `idGROUP`
				FROM `group`
				WHERE `title` = 'A' )
				AND r.idREQUISITION =".$params['rid'];
			$com = Yii::app()->db->createCommand($sql);
			$facility_admin = $com->query();
			foreach($facility_admin as $fa)
				$emails[] = $fa['username'];			
		}
		
		//email next approving group only when needed		
		if($email_approving_group){			
			$groups = MailGroup::model()->findAll("STATUS_idSTATUS=".$params['status_id']);
			foreach($groups as $group){
				$mail_group = MailGroup::model()->findByPk($group->idMAIL_GROUP);
				foreach($mail_group->myUsers as $user){					
					$emails[] = $user->username;
				}
			}
		}
		
		//always email the requester
		$sql = "SELECT username
				FROM user
				WHERE idUSER = (
				SELECT `USER_idUSER_sign_req`
				FROM requisition
				WHERE `idREQUISITION` =".$params['rid']." )";
		$com = Yii::app()->db->createCommand($sql);
		$requester = $com->query();
		foreach($requester as $requester_){
			$emails[] = $requester_['username'];
		}	
		//echo "<pre>";
		//print_r($emails);
		//echo "</pre>";
		
		return $emails;
	}

	private function isValidPODate($order, $ship, $model){		
		$validity = true;
		$today = strtotime(date("Y-m-d"));
		$date_today = date("m-d-Y");
		$shipping = strtotime($ship);
		$ordering = strtotime($order);
		
		/*
		if($ordering < $today){
			$model->addError('order_date',"The order date cannot be earlier than today ($date_today).");
			$validity = false;
		}
		*/
		
		if($shipping < $today){
			$model->addError('estimated_delivery_date',"The delivery date cannot be earlier than today ($date_today).");
			$validity = false;
		}
		if($shipping < $ordering){
			$model->addError('estimated_delivery_date',"The delivery date cannot be earlier than the order date.");
			$validity = false;
		}
		return $validity;
	}

	protected function formatNumber($num){
		return number_format($num, 2, '.', ',');
	}
	
}