<?php

/**
 * This is the model class for table "hr_employee".
 *
 * The followings are the available columns in table 'hr_employee':
 * @property integer $emp_id
 * @property string $last_name
 * @property string $first_name
 * @property string $middle_name
 * @property string $photo
 * @property integer $active_personal_id
 * @property integer $active_employment_id
 * @property integer $active_payroll_id
 * @property string $timestamp
 *
 * The followings are the available model relations:
 * @property HrEmployeeBasicArchive[] $hrEmployeeBasicArchives
 * @property HrEmployeeEmployment[] $hrEmployeeEmployments
 * @property HrEmployeeLicense[] $hrEmployeeLicenses
 * @property HrEmployeePayroll[] $hrEmployeePayrolls
 * @property HrEmployeePersonal[] $hrEmployeePersonals
 */
class Employee extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Employee the static model class
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
		return 'hr_employee';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('last_name, first_name', 'required'),
			array('active_personal_id, active_employment_id, active_payroll_id', 'numerical', 'integerOnly'=>true),
			array('last_name, first_name, middle_name, photo', 'length', 'max'=>128),
			array('timestamp', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('emp_id, last_name, first_name, middle_name, photo, active_personal_id, active_employment_id, active_payroll_id, timestamp', 'safe', 'on'=>'search'),
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
			'hrEmployeeBasicArchives' => array(self::HAS_MANY, 'HrEmployeeBasicArchive', 'emp_id'),
			'hrEmployeeEmployments' => array(self::HAS_MANY, 'HrEmployeeEmployment', 'emp_id'),
			'hrEmployeeLicenses' => array(self::HAS_MANY, 'HrEmployeeLicense', 'emp_id'),
			'hrEmployeePayrolls' => array(self::HAS_MANY, 'HrEmployeePayroll', 'emp_id'),
			'hrEmployeePersonals' => array(self::HAS_MANY, 'HrEmployeePersonal', 'emp_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'emp_id' => 'Emp',
			'last_name' => 'Last Name',
			'first_name' => 'First Name',
			'middle_name' => 'Middle Name',
			'photo' => 'Photo',
			'active_personal_id' => 'Active Personal',
			'active_employment_id' => 'Active Employment',
			'active_payroll_id' => 'Active Payroll',
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

		$criteria->compare('emp_id',$this->emp_id);
		$criteria->compare('last_name',$this->last_name,true);
		$criteria->compare('first_name',$this->first_name,true);
		$criteria->compare('middle_name',$this->middle_name,true);
		$criteria->compare('photo',$this->photo,true);
		$criteria->compare('active_personal_id',$this->active_personal_id);
		$criteria->compare('active_employment_id',$this->active_employment_id);
		$criteria->compare('active_payroll_id',$this->active_payroll_id);
		$criteria->compare('timestamp',$this->timestamp,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}