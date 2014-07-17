<?php

/**
 * This is the model class for table "hr_employee_license".
 *
 * The followings are the available columns in table 'hr_employee_license':
 * @property integer $id
 * @property integer $emp_id
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
class License extends CActiveRecord
{
	public $alert, $attachments, $due_weeks_from_now, $due_months_from_now, $expiring_from, $expiring_until;
  
  
  public function printAttachments($model, $row){
    if(empty($model->attachment)) return;
    $aa = $model->attachment;
    $data = '<ul>';     
    foreach ($aa as $key=>$value) {
      $file = explode('License_attachments_cum_uploader_',$value);
      $link = Helper::getBaseUploadsUrl().$value;
      $name = LicenseApp::truncate($file[1]);
      $data .= "<li>".CHtml::link($name,$link,array('target'=>'_blank'))."</li>";  	
    }
    $data .= '</ul>';
    return $data;
  }
  
  public function beforeSave(){
    if($this->isNewRecord) { $this->submitted_by = Yii::app()->user->getState('id'); }
    $this->saveAttachments();
    $this->encodeAttachments();                      
    return parent::beforeSave();
  }
  
  private function saveAttachments(){
    if(empty($this->attachments))return;
    $a = $this->attachment; 
    $a[] = $this->attachments;
    $this->attachment = $a;
    Yii::log(print_r($a,true),'error','app');     
  }
  
  private function decodeAttachments(){
    $this->attachment = CJSON::decode($this->attachment);   
  }
  
  private function encodeAttachments(){
    $this->attachment = CJSON::encode($this->attachment);   
  }
  
  public function afterFind(){
    $this->alert = (strtotime(date('Y-m-d',time())) >= strtotime($this->date_of_expiration)) ? '1' : '0';
    $this->decodeAttachments();
    return parent::afterFind();
  }
  
  /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return License the static model class
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
			array('emp_id', 'numerical', 'integerOnly'=>true),
			array('name, serial_number', 'length', 'max'=>128),
			array('timestamp,attachments', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('expiring_from, expiring_until, due_weeks_from_now, due_months_from_now, id, emp_id, name, serial_number, date_issued, date_of_expiration, attachment, timestamp', 'safe', 'on'=>'search'),
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
			'emp' => array(self::BELONGS_TO, 'Employee', 'emp_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'emp_id' => 'Employee',
			'name' => 'Name',
			'serial_number' => 'Serial Number',
			'date_issued' => 'Date Issued',
			'date_of_expiration' => 'Date Of Expiration',
			'attachment' => 'Attachment',
			'timestamp' => 'Timestamp',
      'due_weeks_from_now' => 'Expiring Weeks From Now',
      'due_months_from_now' => 'Expiring Months From Now',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search($pagination=10)
	{
		$criteria=new CDbCriteria;

    $criteria->with = 'emp';

		$criteria->compare('t.id',$this->id);
		$criteria->compare('t.emp_id',$this->emp_id,true);

    $criteria->compare('emp.first_name',$this->emp_id,true,'OR');
    $criteria->compare('emp.last_name',$this->emp_id,true,'OR');

		$criteria->compare('t.name',$this->name,true);
		$criteria->compare('t.serial_number',$this->serial_number,true);
		$criteria->compare('t.date_issued',$this->date_issued,true);
		$criteria->compare('t.date_of_expiration',$this->date_of_expiration,true);

    $now = time();
    if(!empty($this->due_weeks_from_now)){
      $start = strtotime("+ $this->due_weeks_from_now weeks",$now);
      $end = strtotime("+ 6 days",$start);
      $criteria->addBetweenCondition('date_of_expiration',date('Y-m-d',$start),date('Y-m-d',$end),'OR'); 
    }
    
    if(!empty($this->due_months_from_now)){
      $this_month = date('m',$now);
      $target_month = strtotime("+ $this->due_months_from_now months",$now);
      $criteria->addCondition("( date_of_expiration >= CURDATE() and MONTH(date_of_expiration) = '".date('m',$target_month)."' )");
    }
    
    if(!empty($this->expiring_from) and !empty($this->expiring_until)){
      $criteria->addBetweenCondition('date_of_expiration',$this->expiring_from,$this->expiring_until,'OR');
    }elseif(!empty($this->expiring_from) and empty($this->expiring_until)){
      $criteria->addCondition("date_of_expiration >= '".$this->expiring_from."'");
    }elseif(empty($this->expiring_from) and !empty($this->expiring_until)){
      $criteria->addCondition("date_of_expiration <= '".$this->expiring_until."'");
    }else{}
    
    
    //Yii::log(print_r($criteria,true),'error','app');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
      'sort'=>array(
        'class'=>'CSort',
        'defaultOrder'=>'date_of_expiration asc',
      ),
      'pagination'=>array(
        'pageSize'=>$pagination,
      ),
		));
	}
}