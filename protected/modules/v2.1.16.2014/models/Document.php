<?php

/**
 * This is the model class for table "hr_employee_license".
 *
 * The followings are the available columns in table 'hr_employee_license':
 * @property integer $id
 * @property integer $emp_id
 * @property integer $submitted_by
 * @property string $name
 * @property string $serial_number
 * @property string $date_issued
 * @property string $date_of_expiration
 * @property string $attachment
 * @property string $timestamp
 *
 * The followings are the available model relations:
 * @property HrEmployee $emp
 */
class Document extends CActiveRecord
{
	/**
	 * checks if expired
	 */
	public function isExpired(){
		return time() >= strtotime($this->date_of_expiration);
	} 
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Document the static model class
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
		return 'hr_employee_license';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('emp_id, name, date_issued, date_of_expiration', 'required'),
			array('emp_id, submitted_by', 'numerical', 'integerOnly'=>true),
			array('name, serial_number', 'length', 'max'=>128),
			array('attachment', 'length', 'max'=>1024),
			array('timestamp', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, emp_id, submitted_by, name, serial_number, date_issued, date_of_expiration, attachment, timestamp', 'safe', 'on'=>'search'),
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
			'submitted_by' => 'Submitted By',
			'name' => 'Name',
			'serial_number' => 'Serial Number',
			'date_issued' => 'Date Issued',
			'date_of_expiration' => 'Date Of Expiration',
			'attachment' => 'Attachment',
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
		$criteria->compare('submitted_by',$this->submitted_by);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('serial_number',$this->serial_number,true);
		$criteria->compare('date_issued',$this->date_issued,true);
		$criteria->compare('date_of_expiration',$this->date_of_expiration,true);
		$criteria->compare('attachment',$this->attachment,true);
		$criteria->compare('timestamp',$this->timestamp,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
