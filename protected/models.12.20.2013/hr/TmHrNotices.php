<?php

/**
 * This is the model class for table "tm_hr_notices".
 *
 * The followings are the available columns in table 'tm_hr_notices':
 * @property integer $id
 * @property integer $facility_id
 * @property integer $employee_id
 * @property string $type
 * @property string $rate_type
 * @property integer $cancel
 * @property integer $decline
 */
class TmHrNotices extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TmHrNotices the static model class
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
		return 'tm_hr_notices';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, facility_id, employee_id, type, rate_type, cancel, decline', 'required'),
			array('id, facility_id, employee_id, cancel, decline', 'numerical', 'integerOnly'=>true),
			array('type', 'length', 'max'=>1),
			array('rate_type', 'length', 'max'=>2),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, facility_id, employee_id, type, rate_type, cancel, decline', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'facility_id' => 'Facility',
			'employee_id' => 'Employee',
			'type' => 'Type',
			'rate_type' => 'Rate Type',
			'cancel' => 'Cancel',
			'decline' => 'Decline',
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
		$criteria->compare('facility_id',$this->facility_id);
		$criteria->compare('employee_id',$this->employee_id);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('rate_type',$this->rate_type,true);
		$criteria->compare('cancel',$this->cancel);
		$criteria->compare('decline',$this->decline);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}