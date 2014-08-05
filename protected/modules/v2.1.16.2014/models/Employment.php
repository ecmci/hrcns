<?php

/**
 * This is the model class for table "hr_employee_employment".
 *
 * The followings are the available columns in table 'hr_employee_employment':
 * @property integer $id
 * @property integer $emp_id
 * @property integer $facility_id
 * @property string $status
 * @property string $date_of_hire
 * @property string $date_of_termination
 * @property integer $department_code
 * @property integer $position_code
 * @property string $start_date
 * @property string $end_date
 * @property string $contract_file
 * @property integer $has_union
 * @property string $reports_to
 * @property integer $is_approved
 * @property string $timestamp
 *
 * The followings are the available model relations:
 * @property Facility $facility
 * @property HrDepartment $departmentCode
 * @property HrPosition $positionCode
 * @property HrEmployee $emp
 * @property HrWorkflowChangeNotice[] $hrWorkflowChangeNotices
 */
class Employment extends CActiveRecord
{
	public $years_in_union, $emp_name;
	
	/**
	 * Override parent beforeSave
	 */
	public function beforeSave(){
		$this->department_code = Position::model()->findByPk($this->position_code)->dept_code;
		return parent::beforeSave();
	}
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Employment the static model class
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
			//all scenario
			array('position_code, facility_id, status', 'required'),
			array('emp_id, facility_id, department_code, position_code, has_union, is_approved', 'numerical', 'integerOnly'=>true),
			array('status', 'length', 'max'=>29),
			array('contract_file', 'length', 'max'=>256),
			array('reports_to', 'length', 'max'=>128),
			array('years_in_union, date_of_hire, date_of_termination, start_date, end_date, timestamp', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('years_in_union, id, emp_id, facility_id, status, date_of_hire, date_of_termination, department_code, position_code, start_date, end_date, contract_file, has_union, reports_to, is_approved, timestamp', 'safe', 'on'=>'search'),
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
			'facility' => array(self::BELONGS_TO, 'Facility', 'facility_id'),
			'department' => array(self::BELONGS_TO, 'Department', 'department_code'),
			'position' => array(self::BELONGS_TO, 'Position', 'position_code'),
			'employee' => array(self::BELONGS_TO, 'Employee', 'emp_id'),
			'hrWorkflowChangeNotices' => array(self::HAS_MANY, 'HrWorkflowChangeNotice', 'employment_profile_id'),
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
			'facility_id' => 'Facility',
			'status' => 'Status',
			'date_of_hire' => 'Date Of Hire',
			'date_of_termination' => 'Date Of Termination',
			'department_code' => 'Department Code',
			'position_code' => 'Position Title',
			'start_date' => 'Start Date',
			'end_date' => 'End Date',
			'contract_file' => 'Contract File',
			'has_union' => 'Is Union',
			'reports_to' => 'Reports To',
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
		$criteria->compare('facility_id',$this->facility_id);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('date_of_hire',$this->date_of_hire,true);
		$criteria->compare('date_of_termination',$this->date_of_termination,true);
		$criteria->compare('department_code',$this->department_code);
		$criteria->compare('position_code',$this->position_code);
		$criteria->compare('start_date',$this->start_date,true);
		$criteria->compare('end_date',$this->end_date,true);
		$criteria->compare('contract_file',$this->contract_file,true);
		$criteria->compare('has_union',$this->has_union);
		$criteria->compare('reports_to',$this->reports_to,true);
		$criteria->compare('is_approved',$this->is_approved);
		$criteria->compare('timestamp',$this->timestamp,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
