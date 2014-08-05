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
	public $facility_id, $status, $department_code, $position_code, $include_terminated_employees,$date_of_hire, $date_of_termination;
	
	/**
	 * Override parent beforeSave()
	 */ 
	public function beforeSave(){
		$this->photo = empty($this->photo) ? 'avatar.jpg' : $this->photo;
		return parent::beforeSave();
	}
	
	/**
	 * Quick search
	 */
	public function quickSearch(){
		$c = new CDbCriteria;
		$c->join = 'left outer join hr_employee_employment a on a.emp_id = t.emp_id';
		$c->compare('t.emp_id',$this->emp_id,true);
		$c->compare('t.last_name',$this->emp_id,true,'OR');
		$c->compare('t.first_name',$this->emp_id,true,'OR');
		
		//filter only those belonging to user's facility
		$c->addInCondition('a.facility_id',Yii::app()->user->getState('hr_facility_handled_ids'));
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$c,
		));
	}
	
	/**
	 * Gets the employees for current user's assigned facilities
	 */ 
	public static function getList(){
		$c = new CDbCriteria;
		$c->select = "emp.emp_id, concat(emp.last_name, ', ', emp.first_name) as emp_name";
		$c->join = 'left outer join hr_employee emp on emp.emp_id = t.emp_id';
		$c->addInCondition('t.facility_id',Yii::app()->user->getState('hr_facility_handled_ids'));
		$c->order = 'emp.last_name asc, emp.first_name asc'; 
		return CHtml::listdata(Employment::model()->findAll($c),'emp_id','emp_name'); 
	}
	
	
	/**
	 * Returns full name of the employee	 * 	 
	 * @return full name of the employee
	 */
	 public function getFullName(){
		 return $this->last_name.', '.$this->first_name;
	 }
	 
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
			array('last_name, first_name', 'required','except'=>array('search')),
			array('active_personal_id, active_employment_id, active_payroll_id', 'numerical', 'integerOnly'=>true),
			array('last_name, first_name, middle_name, photo', 'length', 'max'=>128),
			array('timestamp', 'safe'),
			array('photo', 'file', 'allowEmpty'=>true,'mimeTypes'=>array('image/jpeg','image/png')),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('date_of_hire, date_of_termination, include_terminated_employees, facility_id, status, department_code, position_code, emp_id, last_name, first_name, middle_name', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		/*
		return array(
			'personal' => array(self::HAS_ONE, 'Personal', 'id'),
			'employment' => array(self::HAS_ONE, 'Employment', 'id'),
			'payroll' => array(self::HAS_ONE, 'Payroll', 'id'),
		);
		*/
		return array(
			'personal' => array(self::BELONGS_TO, 'Personal', 'active_personal_id'),
			'employment' => array(self::BELONGS_TO, 'Employment', 'active_employment_id'),
			'payroll' => array(self::BELONGS_TO, 'Payroll', 'active_payroll_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'emp_id' => 'Employee ID',
			'last_name' => 'Last Name',
			'first_name' => 'First Name',
			'middle_name' => 'Middle Name',
			'photo' => 'Photo',
			'active_personal_id' => 'Active Personal',
			'active_employment_id' => 'Active Employment',
			'active_payroll_id' => 'Active Payroll',
			'timestamp' => 'Timestamp',
			'status' => 'Employment Status',
			'position_code' => 'Position Title',
			'department_code' => 'Department',
			'facility_id' => 'Facility',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search($pagination=array('pageSize'=>'10'))
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		
		$criteria->with = array('employment');

		$criteria->compare('t.emp_id',$this->emp_id);
		$criteria->compare('t.last_name',$this->emp_id,true,'OR');
		$criteria->compare('t.first_name',$this->emp_id,true,'OR');
		$criteria->compare('t.middle_name',$this->emp_id,true,'OR');
		
		$criteria->compare('t.last_name',$this->last_name,true,'OR');
		$criteria->compare('t.first_name',$this->first_name,true,'OR');
		$criteria->compare('t.middle_name',$this->middle_name,true,'OR');
		
		$criteria->compare('employment.status',$this->status,true);
		$criteria->compare('employment.position_code',$this->position_code);
		$criteria->compare('employment.department_code',$this->department_code);
		
		if($this->include_terminated_employees == '1') {
			$criteria->addCondition('employment.date_of_termination IS NOT NULL AND employment.date_of_termination != "0000-00-00"');
		}else{
			$criteria->addCondition('employment.date_of_termination IS NULL OR employment.date_of_termination = "0000-00-00"');
		}
		
		//FILTER: show only those belonging to user's facility
		if(!empty($this->facility_id)){
			$criteria->compare('employment.facility_id',$this->facility_id);
		}else{
			$criteria->addInCondition('employment.facility_id',Yii::app()->user->getState('hr_facility_handled_ids'));
		}


		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>$pagination
		));
	}
}
