<?php

/**
 * This is the model class for table "tar_log".
 *
 * The followings are the available columns in table 'tar_log':
 * @property integer $case_id
 * @property string $control_num
 * @property string $resident
 * @property string $medical_num
 * @property string $dx_code
 * @property string $admit_date
 * @property string $type
 * @property string $requested_dos_date_from
 * @property string $requested_dos_date_thru
 * @property string $applied_date
 * @property string $denied_deferred_date
 * @property string $approved_modified_date
 * @property string $backbill_date
 * @property double $aging_amount
 * @property string $notes
 * @property integer $is_closed
 * @property string $reason_for_closing
 * @property string $created_timestamp
 * @property integer $approved_care_id
 * @property integer $status_id
 * @property integer $created_by_user_id
 * @property integer $facility_id
 * @property string $resident_status
 *
 * The followings are the available model relations:
 * @property TarActivityTrail[] $tarActivityTrails
 * @property TarAlerts[] $tarAlerts
 * @property TarApprovedCare $approvedCare
 * @property TarStatus $status
 * @property TarUser $createdByUser
 * @property Facility $facility
 * @property TarProcedureChecklist[] $tarProcedureChecklists
 */
class TarLog extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TarLog the static model class
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
		return 'tar_log';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('resident, requested_dos_date_from, created_timestamp, status_id, created_by_user_id, facility_id', 'required'),
			array('is_closed, approved_care_id, status_id, created_by_user_id, facility_id', 'numerical', 'integerOnly'=>true),
			array('aging_amount', 'numerical'),
			array('control_num, resident, medical_num, dx_code, type, reason_for_closing, resident_status', 'length', 'max'=>45),
			array('admit_date, requested_dos_date_thru, applied_date, denied_deferred_date, approved_modified_date, backbill_date, notes', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('case_id, control_num, resident, medical_num, dx_code, admit_date, type, requested_dos_date_from, requested_dos_date_thru, applied_date, denied_deferred_date, approved_modified_date, backbill_date, aging_amount, notes, is_closed, reason_for_closing, created_timestamp, approved_care_id, status_id, created_by_user_id, facility_id, resident_status', 'safe', 'on'=>'search'),
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
			'tarActivityTrails' => array(self::HAS_MANY, 'TarActivityTrail', 'log_case_id'),
			'tarAlerts' => array(self::HAS_MANY, 'TarAlerts', 'log_case_id'),
			'approvedCare' => array(self::BELONGS_TO, 'TarApprovedCare', 'approved_care_id'),
			'status' => array(self::BELONGS_TO, 'TarStatus', 'status_id'),
			'createdByUser' => array(self::BELONGS_TO, 'TarUser', 'created_by_user_id'),
			'facility' => array(self::BELONGS_TO, 'Facility', 'facility_id'),
			'tarProcedureChecklists' => array(self::HAS_MANY, 'TarProcedureChecklist', 'log_case_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'case_id' => 'Case',
			'control_num' => 'Control Num',
			'resident' => 'Resident',
			'medical_num' => 'Medical Num',
			'dx_code' => 'Dx Code',
			'admit_date' => 'Admit Date',
			'type' => 'Type',
			'requested_dos_date_from' => 'Requested Dos Date From',
			'requested_dos_date_thru' => 'Requested Dos Date Thru',
			'applied_date' => 'Applied Date',
			'denied_deferred_date' => 'Denied Deferred Date',
			'approved_modified_date' => 'Approved Modified Date',
			'backbill_date' => 'Backbill Date',
			'aging_amount' => 'Aging Amount',
			'notes' => 'Notes',
			'is_closed' => 'Is Closed',
			'reason_for_closing' => 'Reason For Closing',
			'created_timestamp' => 'Created Timestamp',
			'approved_care_id' => 'Approved Care',
			'status_id' => 'Status',
			'created_by_user_id' => 'Created By User',
			'facility_id' => 'Facility',
			'resident_status' => 'Resident Status',
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

		$criteria->compare('case_id',$this->case_id);
		$criteria->compare('control_num',$this->control_num,true);
		$criteria->compare('resident',$this->resident,true);
		$criteria->compare('medical_num',$this->medical_num,true);
		$criteria->compare('dx_code',$this->dx_code,true);
		$criteria->compare('admit_date',$this->admit_date,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('requested_dos_date_from',$this->requested_dos_date_from,true);
		$criteria->compare('requested_dos_date_thru',$this->requested_dos_date_thru,true);
		$criteria->compare('applied_date',$this->applied_date,true);
		$criteria->compare('denied_deferred_date',$this->denied_deferred_date,true);
		$criteria->compare('approved_modified_date',$this->approved_modified_date,true);
		$criteria->compare('backbill_date',$this->backbill_date,true);
		$criteria->compare('aging_amount',$this->aging_amount);
		$criteria->compare('notes',$this->notes,true);
		$criteria->compare('is_closed',$this->is_closed);
		$criteria->compare('reason_for_closing',$this->reason_for_closing,true);
		$criteria->compare('created_timestamp',$this->created_timestamp,true);
		$criteria->compare('approved_care_id',$this->approved_care_id);
		$criteria->compare('status_id',$this->status_id);
		$criteria->compare('created_by_user_id',$this->created_by_user_id);
		$criteria->compare('facility_id',$this->facility_id);
		$criteria->compare('resident_status',$this->resident_status,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}