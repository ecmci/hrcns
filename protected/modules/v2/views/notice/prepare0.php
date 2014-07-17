 /**
	 * Prepares a new notice
	 * @param str $f the form: h = new hire, c = change
	 * @param str $e the employee ID
	 * @param str $n notice ID   
	 * @param str $r redo: flags if this is for REDO by BOM
	 * @param str $f finalize: flags if HR is on modify and finalize mode                 
	 */
	public function actionPrepare0($f,$e='',$n='',$r='0',$f='0'){
		//determine form
		$notice = null;
		$employee = null;
		$personal = null;
		$employment = null;
		$payroll = null;
		$form = '';
		
			
		if($f === 'h'){ //new hire form
			$notice = new Notice;
			$employee = new Employee;
			$personal = new Personal;
			$employment = new Employment;
			$payroll = new Payroll;
			$form = 'New Hire';		
			$notice->notice_type = 'NEW_HIRE';
            
			//unset defaults
			$notice->unsetAttributes();
			$employee->unsetAttributes();
			$personal->unsetAttributes();
			$employment->unsetAttributes();
			$payroll->unsetAttributes();	
		}elseif($f === 'c' and !empty($e)){ // new notice for employee mode
			$notice = new Notice;
			$employee = Employee::model()->findByPk(CHtml::encode($e));
			$personal = Personal::model()->findByPk($employee->active_personal_id);
			$employment = Employment::model()->findByPk($employee->active_employment_id);
			$payroll = Payroll::model()->findByPk($employee->active_payroll_id);
			$form = 'Change Notice';
            $notice->notice_type = 'CHANGE';
			
			//always save sub profiles as new profiles
			$personal->isNewRecord = true;
			$employment->isNewRecord = true;
			$payroll->isNewRecord = true;
			
			$personal->id = null;
			$employment->id = null;
			$payroll->id = null;
		}elseif($f === 'c' and !empty($n)){ // modify notice mode
            $notice = $this->loadModel(CHtml::encode($n));
            $employee = Employee::model()->findByPk($notice->profile_id);
    		$personal = Personal::model()->findByPk($notice->personal_profile_id);
    		$employment = Employment::model()->findByPk($notice->employment_profile_id);
    		$payroll = Payroll::model()->findByPk($notice->payroll_profile_id);
            $form = 'Change Notice';
        }else{
			throw new CHttpException(400,'Invalid Request');
		}

		//set
		//$notice->notice_type = $f=='h' ? 'NEW_HIRE' : 'CHANGE';
		
		//set scenario
		$notice->scenario = 'prepare';
		$employee->scenario = 'prepare';
		$personal->scenario = 'prepare';
		$employment->scenario = 'prepare';
		$payroll->scenario = 'prepare';
		
		//handle ajax validation
		$this->performAjaxValidation(array($notice,$employee,$personal,$employment,$payroll));
		
		//handle posted data
		if(isset($_POST['Notice'])){
			$notice->attributes = $_POST['Notice'];
			$employee->attributes = $_POST['Employee'];
			$personal->attributes = $_POST['Personal'];
			$employment->attributes = $_POST['Employment'];
			$payroll->attributes = $_POST['Payroll'];
			$employee->photo = CUploadedFile::getInstance($employee,'photo');
			
			//validate
			$p0 = $notice->validate();
			$p1 = $employee->validate();
			$p2 = $personal->validate();
			$p3 = $employment->validate();
			$p4 = $payroll->validate();
			$p5 = $payroll->validatePTO($employment);
			
			if($p0 and $p1 and $p2 and $p3 and $p4 and $p5){
				//save profiles in strict order
				if(!empty($employee->photo)){
					$name = md5($employee->photo->name).time().'.'.$employee->photo->extensionName;
					$employee->photo->saveAs(App::getUploadDir().$name);
					$employee->photo = $name;
				}
				$employee->save(false);
				$personal->emp_id = $employee->emp_id; $personal->save(false);
				$employment->emp_id = $employee->emp_id; $employment->save(false);
				$payroll->emp_id = $employee->emp_id; $payroll->save(false);
				
       
                
                $employee->active_personal_id = $personal->id;
				$employee->active_employment_id = $employment->id;
				$employee->active_payroll_id = $payroll->id;
                }
				$employee->save(false);
				
				//create notice
				$notice->profile_id = $employee->emp_id;
				$notice->personal_profile_id = $personal->id;
				$notice->employment_profile_id = $employment->id;
				$notice->payroll_profile_id = $payroll->id;
				$notice->save(false);
				$this->redirect(array('review','id'=>$notice->id));
			}
		}
		
		//load form
		$this->render('prepare',array(
			'notice'=>$notice,
			'employee'=>$employee,
			'personal'=>$personal,
			'employment'=>$employment,
			'payroll'=>$payroll,
			'frm'=>$form
		));
	}
