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
 * @property string $w4_status
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
 * @property HrWorkflowChangeNotice[] $hrWorkflowChangeNotices
 */
class Payroll extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Payroll the static model class
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
			array('emp_id, fed_expt, fed_add, state_expt, state_add, rate_type, rate_proposed', 'required'),
			array('emp_id, is_pto_eligible, is_approved', 'numerical', 'integerOnly'=>true),
			array('fed_expt, state_expt', 'length', 'max'=>3),
			array('fed_add, state_add, rate_proposed, rate_recommended, rate_approved, deduc_health_amt, deduc_dental_amt, deduc_other_amt', 'length', 'max'=>10),
			array('rate_type', 'length', 'max'=>6),
			array('w4_status', 'length', 'max'=>39),
			array('deduc_health_code, deduc_dental_code, deduc_other_code', 'length', 'max'=>32),
			array('pto_effective_date, rate_effective_date, timestamp', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, emp_id, is_pto_eligible, pto_effective_date, fed_expt, fed_add, state_expt, state_add, rate_type, w4_status, rate_proposed, rate_recommended, rate_approved, rate_effective_date, deduc_health_code, deduc_health_amt, deduc_dental_code, deduc_dental_amt, deduc_other_code, deduc_other_amt, is_approved, timestamp', 'safe', 'on'=>'search'),
		);
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
			'hrWorkflowChangeNotices' => array(self::HAS_MANY, 'HrWorkflowChangeNotice', 'payroll_profile_id'),
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
			'is_pto_eligible' => 'Is Pto Eligible',
			'pto_effective_date' => 'Pto Effective Date',
			'fed_expt' => 'Fed Expt',
			'fed_add' => 'Fed Add',
			'state_expt' => 'State Expt',
			'state_add' => 'State Add',
			'rate_type' => 'Rate Type',
			'w4_status' => 'W4 Status',
			'rate_proposed' => 'Rate Proposed',
			'rate_recommended' => 'Rate Recommended',
			'rate_approved' => 'Rate Approved',
			'rate_effective_date' => 'Rate Effective Date',
			'deduc_health_code' => 'Deduc Health Code',
			'deduc_health_amt' => 'Deduc Health Amt',
			'deduc_dental_code' => 'Deduc Dental Code',
			'deduc_dental_amt' => 'Deduc Dental Amt',
			'deduc_other_code' => 'Deduc Other Code',
			'deduc_other_amt' => 'Deduc Other Amt',
			'is_approved' => 'Is Approved',
			'timestamp' => 'Timestamp',
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
		$criteria->compare('w4_status',$this->w4_status,true);
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