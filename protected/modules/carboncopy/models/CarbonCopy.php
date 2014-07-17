<?php

/**
 * This is the model class for table "hr_workflow_change_carbon_copy_recipient".
 *
 * The followings are the available columns in table 'hr_workflow_change_carbon_copy_recipient':
 * @property integer $id
 * @property string $workflow_notice_status
 * @property string $recipient_email
 */
class CarbonCopy extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CarbonCopy the static model class
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
		return 'hr_workflow_change_carbon_copy_recipient';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('workflow_notice_status, recipient_email', 'required'),
			array('workflow_notice_status', 'length', 'max'=>32),
			array('recipient_email', 'length', 'max'=>128),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, workflow_notice_status, recipient_email', 'safe', 'on'=>'search'),
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
			'workflow_notice_status' => 'When Change Notice is at status...',
			'recipient_email' => 'Carbon Copy Recipient...',
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
		$criteria->compare('workflow_notice_status',$this->workflow_notice_status,true);
		$criteria->compare('recipient_email',$this->recipient_email,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}