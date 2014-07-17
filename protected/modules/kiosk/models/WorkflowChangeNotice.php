<?php

/**
 * This is the model class for table "hr_workflow_change_notice".
 *
 * The followings are the available columns in table 'hr_workflow_change_notice':
 * @property integer $id
 * @property integer $initiated_by
 * @property string $notice_type
 * @property string $notice_sub_type
 * @property string $summary_of_changes
 * @property string $reason
 * @property string $status
 * @property string $processing_group
 * @property integer $processing_user
 * @property integer $profile_id
 * @property integer $personal_profile_id
 * @property integer $employment_profile_id
 * @property integer $payroll_profile_id
 * @property integer $bom_id
 * @property integer $fac_adm_id
 * @property integer $mnl_id
 * @property integer $corp_id
 * @property string $timestamp_bom_signed
 * @property string $timestamp_fac_adm_signed
 * @property string $timestamp_mnl_signed
 * @property string $timestamp_corp_signed
 * @property integer $decision_bom
 * @property integer $decision_fac_adm
 * @property integer $decision_mnl
 * @property integer $decision_corp
 * @property string $comment_bom
 * @property string $comment_fac_adm
 * @property string $comment_mnl
 * @property string $comment_corp
 * @property string $attachments
 * @property string $attachment_bom
 * @property string $attachment_fac_adm
 * @property string $attachment_mnl
 * @property string $attachment_corp
 * @property string $effective_date
 * @property string $timestamp
 * @property string $last_updated_timestamp
 *
 * The followings are the available model relations:
 * @property HrEmployeePersonal $personalProfile
 * @property HrUser $processingUser
 * @property HrEmployeeEmployment $employmentProfile
 * @property HrEmployeePayroll $payrollProfile
 * @property ItSystemEmployeeRequest[] $itSystemEmployeeRequests
 */
class WorkflowChangeNotice extends CActiveRecord
{
	public static $SYSTEM = '32';
  public $facility_id;
  
  public function beforeSave(){
    if($this->isNewRecord){
      $this->initiated_by = $this->getInitiator();
      $this->notice_type = 'NEW_HIRE';
      $this->status = 'NEW';
      $this->processing_group = 'BOM';
      $this->attachments = serialize(array(''=>''));
      $this->timestamp = new CDbExpression('NOW()');
    }
    return parent::beforeSave();
  }
  
  public function afterSave(){
    $this->notify();
  }
  
  private function notify(){
    $c = new CDbCriteria;
    $c->select = 't.username';
    $c->join = 'left outer join hr_user u on u.user_id = t.idUSER';
    $c->compare('u.group','BOM');
    $c->compare('u.facility_handled_ids',$this->facility_id,true);
    $boms = User::model()->findAll($c);
    KioskApp::queueMail($boms,$this);
  } 
  
  private function getInitiator(){
    return self::$SYSTEM;    
  }
  
  /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return WorkflowChangeNotice the static model class
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
		return 'hr_workflow_change_notice';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('initiated_by, profile_id, personal_profile_id, employment_profile_id, payroll_profile_id', 'required'),
			array('initiated_by, processing_user, profile_id, personal_profile_id, employment_profile_id, payroll_profile_id, bom_id, fac_adm_id, mnl_id, corp_id, decision_bom, decision_fac_adm, decision_mnl, decision_corp', 'numerical', 'integerOnly'=>true),
			array('notice_type, status', 'length', 'max'=>10),
			array('notice_sub_type', 'length', 'max'=>20),
			array('reason', 'length', 'max'=>256),
			array('processing_group', 'length', 'max'=>7),
			array('attachment_bom, attachment_fac_adm, attachment_mnl, attachment_corp', 'length', 'max'=>128),
			array('summary_of_changes, timestamp_bom_signed, timestamp_fac_adm_signed, timestamp_mnl_signed, timestamp_corp_signed, comment_bom, comment_fac_adm, comment_mnl, comment_corp, attachments, effective_date, timestamp, last_updated_timestamp', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, initiated_by, notice_type, notice_sub_type, summary_of_changes, reason, status, processing_group, processing_user, profile_id, personal_profile_id, employment_profile_id, payroll_profile_id, bom_id, fac_adm_id, mnl_id, corp_id, timestamp_bom_signed, timestamp_fac_adm_signed, timestamp_mnl_signed, timestamp_corp_signed, decision_bom, decision_fac_adm, decision_mnl, decision_corp, comment_bom, comment_fac_adm, comment_mnl, comment_corp, attachments, attachment_bom, attachment_fac_adm, attachment_mnl, attachment_corp, effective_date, timestamp, last_updated_timestamp', 'safe', 'on'=>'search'),
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
			'personalProfile' => array(self::BELONGS_TO, 'HrEmployeePersonal', 'personal_profile_id'),
			'processingUser' => array(self::BELONGS_TO, 'HrUser', 'processing_user'),
			'employmentProfile' => array(self::BELONGS_TO, 'HrEmployeeEmployment', 'employment_profile_id'),
			'payrollProfile' => array(self::BELONGS_TO, 'HrEmployeePayroll', 'payroll_profile_id'),
			'itSystemEmployeeRequests' => array(self::HAS_MANY, 'ItSystemEmployeeRequest', 'hr_workflow_notice_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'initiated_by' => 'Initiated By',
			'notice_type' => 'Notice Type',
			'notice_sub_type' => 'Notice Sub Type',
			'summary_of_changes' => 'Summary Of Changes',
			'reason' => 'Reason',
			'status' => 'Status',
			'processing_group' => 'Processing Group',
			'processing_user' => 'Processing User',
			'profile_id' => 'Profile',
			'personal_profile_id' => 'Personal Profile',
			'employment_profile_id' => 'Employment Profile',
			'payroll_profile_id' => 'Payroll Profile',
			'bom_id' => 'Bom',
			'fac_adm_id' => 'Fac Adm',
			'mnl_id' => 'Mnl',
			'corp_id' => 'Corp',
			'timestamp_bom_signed' => 'Timestamp Bom Signed',
			'timestamp_fac_adm_signed' => 'Timestamp Fac Adm Signed',
			'timestamp_mnl_signed' => 'Timestamp Mnl Signed',
			'timestamp_corp_signed' => 'Timestamp Corp Signed',
			'decision_bom' => 'Decision Bom',
			'decision_fac_adm' => 'Decision Fac Adm',
			'decision_mnl' => 'Decision Mnl',
			'decision_corp' => 'Decision Corp',
			'comment_bom' => 'Comment Bom',
			'comment_fac_adm' => 'Comment Fac Adm',
			'comment_mnl' => 'Comment Mnl',
			'comment_corp' => 'Comment Corp',
			'attachments' => 'Attachments',
			'attachment_bom' => 'Attachment Bom',
			'attachment_fac_adm' => 'Attachment Fac Adm',
			'attachment_mnl' => 'Attachment Mnl',
			'attachment_corp' => 'Attachment Corp',
			'effective_date' => 'Effective Date',
			'timestamp' => 'Timestamp',
			'last_updated_timestamp' => 'Last Updated Timestamp',
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
		$criteria->compare('initiated_by',$this->initiated_by);
		$criteria->compare('notice_type',$this->notice_type,true);
		$criteria->compare('notice_sub_type',$this->notice_sub_type,true);
		$criteria->compare('summary_of_changes',$this->summary_of_changes,true);
		$criteria->compare('reason',$this->reason,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('processing_group',$this->processing_group,true);
		$criteria->compare('processing_user',$this->processing_user);
		$criteria->compare('profile_id',$this->profile_id);
		$criteria->compare('personal_profile_id',$this->personal_profile_id);
		$criteria->compare('employment_profile_id',$this->employment_profile_id);
		$criteria->compare('payroll_profile_id',$this->payroll_profile_id);
		$criteria->compare('bom_id',$this->bom_id);
		$criteria->compare('fac_adm_id',$this->fac_adm_id);
		$criteria->compare('mnl_id',$this->mnl_id);
		$criteria->compare('corp_id',$this->corp_id);
		$criteria->compare('timestamp_bom_signed',$this->timestamp_bom_signed,true);
		$criteria->compare('timestamp_fac_adm_signed',$this->timestamp_fac_adm_signed,true);
		$criteria->compare('timestamp_mnl_signed',$this->timestamp_mnl_signed,true);
		$criteria->compare('timestamp_corp_signed',$this->timestamp_corp_signed,true);
		$criteria->compare('decision_bom',$this->decision_bom);
		$criteria->compare('decision_fac_adm',$this->decision_fac_adm);
		$criteria->compare('decision_mnl',$this->decision_mnl);
		$criteria->compare('decision_corp',$this->decision_corp);
		$criteria->compare('comment_bom',$this->comment_bom,true);
		$criteria->compare('comment_fac_adm',$this->comment_fac_adm,true);
		$criteria->compare('comment_mnl',$this->comment_mnl,true);
		$criteria->compare('comment_corp',$this->comment_corp,true);
		$criteria->compare('attachments',$this->attachments,true);
		$criteria->compare('attachment_bom',$this->attachment_bom,true);
		$criteria->compare('attachment_fac_adm',$this->attachment_fac_adm,true);
		$criteria->compare('attachment_mnl',$this->attachment_mnl,true);
		$criteria->compare('attachment_corp',$this->attachment_corp,true);
		$criteria->compare('effective_date',$this->effective_date,true);
		$criteria->compare('timestamp',$this->timestamp,true);
		$criteria->compare('last_updated_timestamp',$this->last_updated_timestamp,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}