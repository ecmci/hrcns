<?php

/**
 * This is the model class for table "hr_employee_payroll".
 *
 * The followings are the available columns in table 'hr_employee_payroll':
 * @property integer $id
 * @property integer $emp_id
 * @property integer $is_pto_eligible
 * @property string $pto_effective_date
 * @property string $fed_expt
 * @property string $fed_add
 * @property string $state_expt
 * @property string $state_add
 * @property string $rate_type
 * @property string $rate_proposed
 * @property string $rate_recommended
 * @property string $rate_approved
 * @property string $rate_effective_date
 * @property string $deduc_health_code
 * @property string $deduc_health_amt
 * @property string $deduc_dental_code
 * @property string $deduc_dental_amt
 * @property string $deduc_other_code
 * @property string $deduc_other_amt
 * @property integer $is_approved
 * @property string $timestamp
 *
 * The followings are the available model relations:
 * @property HrEmployee $emp
 */
class EmployeePayroll extends CActiveRecord
{
	
  public function beforeValidate(){
    $this->fed_expt = $this->fed_add = '00';
    $this->state_expt = $this->state_add = '00';
    return parent::beforeValidate();
  }
  
  // temp vars
  public $last_rate_proposed, $last_rate_recommended, $last_rate_approved, $reason, $last_wage_increase_date, $increase;
 
  // foreigners
  public $emp_status;
   
  public function validatePtoEligibility($emp_status=''){
    $valid = true;
    if($this->is_pto_eligible == '0' and $emp_status == 'FULL_TIME'){
      $valid = false;
      $this->addError('is_pto_eligible','A FULL_TIME employee needs to be eligible for PTO.');
      $this->addError('pto_effective_date','PTO Effective Date is required.');  
    }
    return $valid;  
  }
  
  public static function getReasonList(){
    return array(
      'Probation'=>'Probation',
      'Annual'=>'Annual',
      'Status Change'=>'Status Change',
      'Other'=>'Other',
    );
  }
  
  public function afterFind(){
    $this->last_rate_proposed = $this->rate_proposed;
    $this->last_rate_recommended = $this->rate_recommended;
    $this->last_rate_approved = $this->rate_approved;
    $this->last_wage_increase_date = $this->rate_effective_date;
    $this->pto_effective_date = (isset($this->pto_effective_date) and  $this->pto_effective_date != '0000-00-00') ? $this->pto_effective_date : ''; 
    return parent::afterFind();
  }
  
  public static function getInfo($model_employee){
    if($model_employee->active_payroll_id) // means there is already an approved profile
      return self::model()->findByPk($model_employee->active_payroll_id);    
    else //return the most recent profile
      return self::model()->find(array(
        'condition'=>"emp_id = '$model_employee->emp_id'",
        'order'=>'timestamp desc'
      ));  
  }
  
  /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return EmployeePayroll the static model class
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
		return 'hr_employee_payroll';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('rate_type, rate_effective_date, rate_proposed, fed_expt, state_expt, fed_add, state_add, w4_status', 'required'),
      
      array('rate_approved', 'required','on'=>'endorse'),
      array('rate_approved', 'validateApprovedRate','on'=>'create,endorse'),
      array('rate_proposed', 'validateProposedRate','on'=>'create,endorse'),
      array('pto_effective_date', 'validatePtoEffectiveDate','on'=>'create,endorse'),
      array('rate_effective_date', 'validateRateEffectiveDate','on'=>'create,endorse'),
      array('is_pto_eligible', 'validatePtoEligibilityTest','on'=>'create,endorse'),      
     
            
      //array('reason', 'required','on'=>'workflow_new'),
      array('rate_approved', 'validateApprovedRate','on'=>'workflow_new'),
      array('rate_proposed', 'validateProposedRate','on'=>'workflow_new'),
      array('pto_effective_date', 'validatePtoEffectiveDate','on'=>'workflow_new'),
      array('rate_effective_date', 'validateRateEffectiveDate','on'=>'workflow_new'),
      array('reason', 'safe','on'=>'workflow_new'),

			array('emp_id, is_pto_eligible, is_approved', 'numerical', 'integerOnly'=>true),
      array('rate_proposed, rate_recommended, rate_approved, deduc_health_amt, deduc_dental_amt, deduc_other_amt,fed_expt, fed_add, state_expt, state_add', 'numerical'),
			array('fed_expt, fed_add, state_expt, state_add, rate_proposed, rate_recommended, rate_approved, deduc_health_amt, deduc_dental_amt, deduc_other_amt', 'length', 'max'=>10),
			array('rate_type', 'length', 'max'=>6),
			array('deduc_health_code, deduc_dental_code, deduc_other_code', 'length', 'max'=>32),
			array('timestamp', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, emp_id, is_pto_eligible, pto_effective_date, fed_expt, fed_add, state_expt, state_add, rate_type, rate_proposed, rate_recommended, rate_approved, rate_effective_date, deduc_health_code, deduc_health_amt, deduc_dental_code, deduc_dental_amt, deduc_other_code, deduc_other_amt, is_approved, timestamp', 'safe', 'on'=>'search'),
		);
	}
  
  public function validatePtoEligibilityTest(){
    if($this->is_pto_eligible == '0' and $this->emp_status == 'FULL_TIME'){
      $this->addError('is_pto_eligible','A FULL_TIME employee needs to be eligible for PTO.');
      $this->addError('pto_effective_date','PTO Effective Date is required.');
    }
  }
  
  public function validateRateEffectiveDate(){
    if(empty($this->rate_effective_date) or $this->rate_effective_date == '0000-00-00'){
      $this->addError('rate_effective_date','Rate Effective Date is required.');  
    }
  }
  
  public function validateProposedRate(){
    if($this->rate_proposed <= 0){
      $this->addError('rate_proposed','Proposed Rate must be greater than zero.');  
    }
  }
  
  public function validatePtoEffectiveDate(){
    if($this->is_pto_eligible == '1' and (empty($this->pto_effective_date) or $this->pto_effective_date == '0000-00-00')){
      $this->addError('pto_effective_date','PTO Effective Date is required.');  
    }
  }
  
  public function validateApprovedRate(){    
    if(Yii::app()->user->getState('hr_group') == 'CORP' and empty($this->rate_approved)){
      $this->addError('rate_approved','Approved Rate is required.');
    }
    if(Yii::app()->user->getState('hr_group') == 'CORP' and $this->rate_approved <= 0){
      $this->addError('rate_approved','Approved Rate must be greater than zero.');  
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
			'emp' => array(self::BELONGS_TO, 'HrEmployee', 'emp_id'),
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
			'is_pto_eligible' => 'Is Eligible for PTO?',
			'pto_effective_date' => 'PTO Effective Date',
			'fed_expt' => 'Fed Expt',
			'fed_add' => 'Fed Add',
			'state_expt' => 'State Expt',
			'state_add' => 'State Add',
			'rate_type' => 'Type',
			'rate_proposed' => 'Proposed Rate',
			'rate_recommended' => 'Recommended Rate',
			'rate_approved' => 'Approved Rate',
			'rate_effective_date' => 'Rate Effective Date',
			'deduc_health_code' => 'Health Code',
			'deduc_health_amt' => 'Health Amt',
			'deduc_dental_code' => 'Dental Code',
			'deduc_dental_amt' => 'Dental Amt',
			'deduc_other_code' => 'Other Code',
			'deduc_other_amt' => 'Other Amt',
			'is_approved' => 'Profile Approved?',
			'timestamp' => 'Last Updated',
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
		$criteria->compare('is_pto_eligible',$this->is_pto_eligible);
		$criteria->compare('pto_effective_date',$this->pto_effective_date,true);
		$criteria->compare('fed_expt',$this->fed_expt,true);
		$criteria->compare('fed_add',$this->fed_add,true);
		$criteria->compare('state_expt',$this->state_expt,true);
		$criteria->compare('state_add',$this->state_add,true);
		$criteria->compare('rate_type',$this->rate_type,true);
		$criteria->compare('rate_proposed',$this->rate_proposed,true);
		$criteria->compare('rate_recommended',$this->rate_recommended,true);
		$criteria->compare('rate_approved',$this->rate_approved,true);
		$criteria->compare('rate_effective_date',$this->rate_effective_date,true);
		$criteria->compare('deduc_health_code',$this->deduc_health_code,true);
		$criteria->compare('deduc_health_amt',$this->deduc_health_amt,true);
		$criteria->compare('deduc_dental_code',$this->deduc_dental_code,true);
		$criteria->compare('deduc_dental_amt',$this->deduc_dental_amt,true);
		$criteria->compare('deduc_other_code',$this->deduc_other_code,true);
		$criteria->compare('deduc_other_amt',$this->deduc_other_amt,true);
		$criteria->compare('is_approved',$this->is_approved);
		$criteria->compare('timestamp',$this->timestamp,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}