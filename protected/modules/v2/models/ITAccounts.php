<?php

/**
 * This is the model class for table "it_system_employee_request".
 *
 * The followings are the available columns in table 'it_system_employee_request':
 * @property integer $id
 * @property integer $employee_id
 * @property integer $system_id
 * @property string $configurations
 * @property string $type
 * @property string $status
 * @property integer $active
 * @property integer $activated_by
 * @property integer $deactivated_by
 * @property string $activated_timestamp
 * @property string $deactivated_timestamp
 * @property string $notes
 * @property integer $hr_workflow_notice_id
 * @property string $timestamp
 *
 * The followings are the available model relations:
 * @property HrWorkflowChangeNotice $hrWorkflowNotice
 * @property ItSystem $system
 */
class ITAccounts extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ITAccounts the static model class
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
		return 'it_system_employee_request';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('employee_id, system_id, timestamp', 'required'),
			array('employee_id, system_id, active, activated_by, deactivated_by, hr_workflow_notice_id', 'numerical', 'integerOnly'=>true),
			array('configurations', 'length', 'max'=>1024),
			array('type', 'length', 'max'=>10),
			array('status', 'length', 'max'=>9),
			array('activated_timestamp, deactivated_timestamp, notes', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, employee_id, system_id, configurations, type, status, active, activated_by, deactivated_by, activated_timestamp, deactivated_timestamp, notes, hr_workflow_notice_id, timestamp', 'safe', 'on'=>'search'),
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
			'hrWorkflowNotice' => array(self::BELONGS_TO, 'HrWorkflowChangeNotice', 'hr_workflow_notice_id'),
			'system' => array(self::BELONGS_TO, 'System', 'system_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'employee_id' => 'Employee',
			'system_id' => 'System',
			'configurations' => 'Configurations',
			'type' => 'Type',
			'status' => 'Status',
			'active' => 'Active',
			'activated_by' => 'Activated By',
			'deactivated_by' => 'Deactivated By',
			'activated_timestamp' => 'Activated Timestamp',
			'deactivated_timestamp' => 'Deactivated Timestamp',
			'notes' => 'Notes',
			'hr_workflow_notice_id' => 'Hr Workflow Notice',
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
		$criteria->compare('employee_id',$this->employee_id);
		$criteria->compare('system_id',$this->system_id);
		$criteria->compare('configurations',$this->configurations,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('active',$this->active);
		$criteria->compare('activated_by',$this->activated_by);
		$criteria->compare('deactivated_by',$this->deactivated_by);
		$criteria->compare('activated_timestamp',$this->activated_timestamp,true);
		$criteria->compare('deactivated_timestamp',$this->deactivated_timestamp,true);
		$criteria->compare('notes',$this->notes,true);
		$criteria->compare('hr_workflow_notice_id',$this->hr_workflow_notice_id);
		$criteria->compare('timestamp',$this->timestamp,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
