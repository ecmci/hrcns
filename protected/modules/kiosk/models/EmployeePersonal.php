<?php

/**
 * This is the model class for table "hr_employee_personal".
 *
 * The followings are the available columns in table 'hr_employee_personal':
 * @property integer $id
 * @property integer $emp_id
 * @property string $birthdate
 * @property string $gender
 * @property string $marital_status
 * @property string $SSN
 * @property string $number
 * @property string $building
 * @property string $street
 * @property string $city
 * @property string $state
 * @property integer $zip_code
 * @property string $telephone
 * @property string $cellphone
 * @property string $email
 * @property integer $is_approved
 * @property string $timestamp
 *
 * The followings are the available model relations:
 * @property HrEmployee $emp
 * @property HrWorkflowChangeNotice[] $hrWorkflowChangeNotices
 */
class EmployeePersonal extends CActiveRecord
{
	public $month, $day, $year;
  
  
  public function beforeValidate(){
    $this->encodeDOB(); 
    return parent::beforeValidate();
  }
  
  private function encodeDOB(){
    if(empty($this->year) or empty($this->year) or empty($this->year) ) return;
    $this->birthdate = "$this->year-$this->month-$this->day";
  }
  /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return EmployeePersonal the static model class
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
		return 'hr_employee_personal';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('birthdate, SSN, street, city, state, zip_code, telephone, marital_status, gender, month, day, year', 'required'),
			array('birthdate','validateDob'),
      array('emp_id, zip_code, is_approved', 'numerical', 'integerOnly'=>true),
			array('gender', 'length', 'max'=>8),
			array('marital_status, number', 'length', 'max'=>16),
			array('SSN, building, street, city, state, telephone, cellphone, email', 'length', 'max'=>128),
			array('timestamp', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, emp_id, birthdate, gender, marital_status, SSN, number, building, street, city, state, zip_code, telephone, cellphone, email, is_approved, timestamp', 'safe', 'on'=>'search'),
		);
	}
  
  public function validateDob(){
    if(empty($this->year))  {
      $this->addError('birthdate','Birthday year is required.');  
    }
    if(empty($this->month))  {
      $this->addError('birthdate','Birthday month is required.');  
    }
    if(empty($this->day))  {
      $this->addError('birthdate','Birthday day is required.');  
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
			'hrWorkflowChangeNotices' => array(self::HAS_MANY, 'HrWorkflowChangeNotice', 'personal_profile_id'),
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
			'birthdate' => 'Birthdate',
			'gender' => 'Gender',
			'marital_status' => 'Marital Status',
			'SSN' => 'Ssn',
			'number' => 'Number',
			'building' => 'Building',
			'street' => 'Street',
			'city' => 'City',
			'state' => 'State',
			'zip_code' => 'Zip Code',
			'telephone' => 'Telephone',
			'cellphone' => 'Cellphone',
			'email' => 'Email',
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
		$criteria->compare('birthdate',$this->birthdate,true);
		$criteria->compare('gender',$this->gender,true);
		$criteria->compare('marital_status',$this->marital_status,true);
		$criteria->compare('SSN',$this->SSN,true);
		$criteria->compare('number',$this->number,true);
		$criteria->compare('building',$this->building,true);
		$criteria->compare('street',$this->street,true);
		$criteria->compare('city',$this->city,true);
		$criteria->compare('state',$this->state,true);
		$criteria->compare('zip_code',$this->zip_code);
		$criteria->compare('telephone',$this->telephone,true);
		$criteria->compare('cellphone',$this->cellphone,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('is_approved',$this->is_approved);
		$criteria->compare('timestamp',$this->timestamp,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}