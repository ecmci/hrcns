<?php 
Yii::import('application.controllers.hr.Employee1Controller');
class EmployeeController extends Employee1Controller{
  public function actionModify($id){
    $this->redirect(Yii::app()->createUrl('hr/workflowchangenotice/redo/id/'.$id));
  }
	public function actionView($id)
	{
		$model = $this->loadModel($id);
		$employment = EmployeeEmployment::model()->findByPk($model->active_employment_id);
		//restrict when viewing admin and don    
		switch($employment->position_code){
			case '25': case '6':
				if( !AccessRules::canSee('rate_approved')){
					throw new CHttpException(400,'You are not authorized to view this resource.');
				}
			break;
		}
			
		$this->render('view2',array(
			'model'=>$model,
		));
	}
/* corrects KC's employee positions */  
public function actionCreateKCKCKCKCKC(){
		try{
			//echo $_SERVER['DOCUMENT_ROOT'];
			$file = fopen($_SERVER['DOCUMENT_ROOT'].'/hrcns/kc.csv','r');
			if($file){
				while($line = fgetcsv($file)){
					EmployeeEmployment::model()->updateByPk($line[0],array('position_code'=>$line[1]));
				}
			}
			fclose($file);
		}catch(Exception $ex){
			echo $ex->getMessage();
		}
}

  /* imports a pre-processed CSV */
  public function actionCreate000000000(){
    echo '<pre>';
    $csvImport = '/var/www/hrcns/uploads/EASY-EC-CSV-formatted.csv';
    $skip_row = 0;
    $last_emp_id = 1;
    $facility_id = 1;
    $default_position_id = 54;
    $is_pto_eligible = 1;
    $imported = 0;
    $sys_admin_id = 23;
    try{
      $csv = fopen($csvImport,'r');
      if($csv != FALSE){
        while($data = fgetcsv($csv,1024,",")){
          //print_r($data); exit();
          if($skip_row++ == 0) continue;
          $employee = new Employee;
          $personal = new EmployeePersonalInfo;
          $employment = new EmployeeEmployment;
          $payroll = new EmployeePayroll;
          
          $employment->emp_id = $last_emp_id;
          $employment->facility_id = $facility_id;
          $employment->status = 'FULL_TIME';
          $employment->date_of_hire = $data[20].'-'.$data[18].'-'.$data[19];
          $employment->department_code = $data[23];
          $employment->position_code = $default_position_id;
          $employment->start_date = $employment->date_of_hire;
          
          
          $payroll->emp_id = $last_emp_id;
          $payroll->is_pto_eligible = $is_pto_eligible;
          $payroll->pto_effective_date = $employment->date_of_hire;
          $payroll->fed_expt = '00';
          $payroll->fed_add = '0.00';
          $payroll->state_expt = '00';
          $payroll->state_add = '0.00';
          $payroll->rate_type = $data[24] == 'S' ? 'SALARY' : 'HOURLY';
          $payroll->rate_approved = $data[25];
          $payroll->rate_proposed = $payroll->rate_approved;
          $payroll->rate_recommended = $payroll->rate_approved;
          $payroll->rate_effective_date = $employment->date_of_hire;
          
          
          $personal->emp_id = $last_emp_id;
          $personal->birthdate = $data[7].'-'.$data[5].'-'.$data[6];
          $personal->gender = $data[3];
          $personal->marital_status = ($data[10] == 'M') ? 'Married' : 'Single';
          $personal->SSN = str_replace('-','',$data[11]);
          $personal->street = $data[12];
          $personal->city = $data[14];
          $personal->state = $data[15];
          $personal->zip_code = $data[16];
          $personal->telephone = $data[17];
         

          $employee->emp_id = $last_emp_id;
          $employee->first_name = ucwords(strtolower($data[2]));
          $employee->middle_name = ucwords(strtolower($data[3]));
          $employee->last_name = ucwords(strtolower($data[1]));
          
          
          $employee->save(false);
          $payroll->save(false);
          $employment->save(false);
          $personal->save(false);          
          $employee->active_personal_id = $personal->id;
          $employee->active_employment_id = $employment->id;
          $employee->active_payroll_id = $payroll->id;
          $employee->save(false);
          
          $workflow = new WorkflowChangeNotice;
          $workflow->initiated_by = $sys_admin_id;
          $workflow->notice_type = 'CHANGE';
          $workflow->reason = 'Manual Import From Easy';
          $workflow->status = 'APPROVED';
          $workflow->processing_group = 'CORP';
          $workflow->profile_id = $employee->emp_id;
          $workflow->personal_profile_id = $personal->id;
          $workflow->employment_profile_id = $employment->id;
          $workflow->payroll_profile_id = $payroll->id;
          $workflow->effective_date = date('Y-m-d H:i:s',time());
          $workflow->last_updated_timestamp = $workflow->effective_date;
          $workflow->attachments = serialize(array(''=>''));
          $workflow->save(false);
          
          $last_emp_id++;
          $imported++;
        }
        fclose($csv); 
      }else{
        throw new Exception('Failed to open CSV file.');
      }
    }catch(Exception $ex){
      echo $ex->getMessage();
    }
    echo '</pre>';
    echo "IMPORTED: $imported";     
  }
  
  //reformat Easy's export file to proper CSV
  public function actionCreate0(){
    echo '<table border="1">';
    try{
      $newCsv = array();
      $csv = fopen('/var/www/hrcns/uploads/EASY-EC-CSV.csv','r');
      if($csv != FALSE){
        while($data = fgetcsv($csv,1024,",")){
          $data[0] = str_replace(array('"'),'',$data[0]);
          $d = explode(',',$data[0]);
          //print_r($d);
          $newCsv[] = $d;
        }
        fclose($csv);
        //$new_csv = fopen('/var/www/hrcns/uploads/EASY-EC-CSV-formatted.csv','w');
        foreach($newCsv as $nc){
          //fputcsv($new_csv, $nc);
          echo '<tr>';
          echo '<td>'.$nc[0].'</td>';
          echo '<td>'.$nc[1].'</td>';
          echo '<td>'.$nc[2].'</td>';
          echo '<td>'.$nc[3].'</td>';
          echo '<td>'.date('Y-m-d',strtotime($nc[4])).'</td>';
          echo '<td>'.$nc[5].'</td>';
          echo '<td>'.$nc[6].'</td>';
          echo '<td>'.$nc[7].'</td>';
          echo '<td>'.$nc[8].'</td>';
          echo '<td>'.$nc[9].'</td>';
          echo '<td>'.$nc[10].'</td>';
          echo '<td>'.$nc[11].'</td>';
          echo '<td>'.$nc[12].'</td>';
          echo '<td>'.$nc[13].'</td>';
          echo '</tr>';
        }
        //fclose($new_csv);  
      }else{
        throw new Exception('Failed to open CSV file.');
      }
    }catch(Exception $ex){
      echo $ex->getMessage();
    }
    echo '</table>';
  }
}
?>
