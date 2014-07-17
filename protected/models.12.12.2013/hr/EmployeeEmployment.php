<?php

/**
 * This is the model class for table "hr_employee_employment".
 *
 * The followings are the available columns in table 'hr_employee_employment':
 * @property integer $id
 * @property integer $emp_id
 * @property string $status
 * @property string $date_of_hire
 * @property string $date_of_termination
 * @property integer $department_code
 * @property integer $position_code
 * @property string $start_date
 * @property string $end_date
 * @property string $contract_file
 * @property string $reports_to
 * @property integer $is_approved
 * @property string $timestamp
 */
class EmployeeEmployment extends CActiveRecord
{
	
  public $emp_name;
  
  public static function getInfo($model_employee){
    if($model_employee->active_employment_id){ // means there is already an approved profile
      //Yii::log('1','error','app');
      return self::model()->findByPk($model_employee->active_employment_id);    
    }else{ //return the most recent profile
      //Yii::log('0','error','app');
      return self::model()->find(array(
        'condition'=>"emp_id = '$model_employee->emp_id'",
        'order'=>'timestamp desc'
      )); 
    } 
  }
  
  
  public function beforeSave(){
    
    return parent::beforeSave();
  }
  
  
  /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return EmployeeEmployment the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName() 
	{
		return 'hr_employee_employment';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('facility_id','required','on'=>'selfservice'),
      
      array('status, date_of_hire, department_code, position_code, start_date, facility_id', 'required','on'=>'create'),
      array('start_date','validateStartDate','on'=>'create'),
      array('department_code','validateDeptCode'),

      array('status, date_of_hire, department_code, position_code, start_date, facility_id', 'required','on'=>'workflow_new'),
			array('start_date','validateStartDate','on'=>'workflow_new'),
      array('date_of_termination','validateTerminationDate','on'=>'workflow_new'),
      array('end_date','validateEndDate','on'=>'workflow_new'),

      array('emp_id, department_code, position_code, is_approved, facility_id', 'numerical', 'integerOnly'=>true),
			array('status', 'length', 'max'=>29),
			array('reports_to', 'length', 'max'=>128),
      array('contract_file', 'validateContractFile'),
			array('date_of_termination, end_date, timestamp, facility_id, active_employment_id, has_union, contract_file', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, emp_id, status, date_of_hire, date_of_termination, department_code, position_code, start_date, end_date, contract_file, reports_to, is_approved, timestamp, facility_id', 'safe', 'on'=>'search'),
		);
	}
  
  public function validateDeptCode(){
    if(!empty($this->department_code) and !empty($this->position_code)){
      $dept_code = Position::model()->find("code = '".$this->position_code."'")->dept_code;
      if($dept_code != $this->department_code){
        $this->addError('department_code','Invalid department for this position.');
      }
    }
  }
  
  public function validateContractFile(){
    if (empty($this->contract_file)) return true;
    $ext = trim(substr($this->contract_file, -3));
    $allowed = array('pdf','doc','docx');
    if(!in_array($ext,$allowed)){
      $this->addError('contract_file','File is unacceptable. Allowed extensions are '.implode(', ',$allowed).' only.');    
    }
  }
  
  public function validateEndDate(){
    if(isset($_POST['WorkflowChangeNotice']) and $_POST['WorkflowChangeNotice']['notice_type'] != 'TERMINATED' ) return;    
    $start= strtotime($this->start_date);
    $end = strtotime($this->end_date);
    if($end < $start){
      $this->addError('end_date','End Date must be on or after the start date.');
    }
  }
  
  public function validateTerminationDate(){    
    if(isset($_POST['WorkflowChangeNotice']) and $_POST['WorkflowChangeNotice']['notice_type'] != 'TERMINATED' ) return;  
    $hired = strtotime($this->date_of_hire);
    $terminated = strtotime($this->date_of_termination);
    if($terminated < $hired){
      $this->addError('date_of_termination','Date of Termination must be on or after the hire date.');
    }
  }
  
  public function validateStartDate(){
    $start = strtotime($this->start_date);
    $hired = strtotime($this->date_of_hire);
    if($start < $hired){
      $this->addError('start_date','Start date must be on or after the hire date.');
    }
  }

  /**
  * @return array relational rules.
  */
  public function relations()
  {
    // NOTE: you may need to adjust the relation name and the related
    // class name for the relations automatically generated below.
    return array(
      'emp' => array(self::BELONGS_TO, 'Employee', 'emp_id'),
      'facility' => array(self::BELONGS_TO, 'Facility', 'facility_id'),
      'departmentCode' => array(self::BELONGS_TO, 'Department', 'department_code'),
      'positionCode' => array(self::BELONGS_TO, 'Position', 'position_code'),

    );
  }

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'emp_id' => 'Emp',
      'facility_id'=>'Facility',
			'status' => 'Status',
			'date_of_hire' => 'Date Of Hire',
			'date_of_termination' => 'Date Of Termination',
			'department_code' => 'Department Code',
			'position_code' => 'Position Code',
			'start_date' => 'Start Date',
			'end_date' => 'End Date',
			'contract_file' => 'Contract File',
			'reports_to' => 'Reports To',
			'is_approved' => 'Approved Profile?',
			'timestamp' => 'Last Updated',
      'departmentCode' => 'Department',
			'positionCode' => 'Position',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('emp_id',$this->emp_id);    
    $criteria->compare('facility_id',$this->facility_id);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('date_of_hire',$this->date_of_hire,true);
		$criteria->compare('date_of_termination',$this->date_of_termination,true);
		$criteria->compare('department_code',$this->department_code);
		$criteria->compare('position_code',$this->position_code);
		$criteria->compare('start_date',$this->start_date,true);
		$criteria->compare('end_date',$this->end_date,true);
		$criteria->compare('contract_file',$this->contract_file,true);
		$criteria->compare('reports_to',$this->reports_to,true);
		$criteria->compare('is_approved',$this->is_approved);
		$criteria->compare('timestamp',$this->timestamp,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}