<?php

/**
 * This is the model class for table "tar_messaging".
 *
 * The followings are the available columns in table 'tar_messaging':
 * @property integer $id
 * @property integer $from_user_id
 * @property integer $to_user_id
 * @property string $message
 * @property integer $is_seen
 * @property string $seen_datetime
 * @property string $timestamp
 */
class TarMessaging extends CActiveRecord
{
	public $send_email = true;
  public $is_cron_triggered = false;
  
  public function markSeen(){
    $this->is_seen = '1';
    $this->seen_datetime = new CDbExpression('NOW()');
    return $this;
  }
  
  protected function afterFind(){
    return parent::afterFind();
  }
  
  protected function beforeSave(){
    if($this->isNewRecord){
      $this->from_user_id = (!$this->is_cron_triggered) ? Yii::app()->user->getState('id') : $this->from_user_id;
    }
    return parent::beforeSave();
  }
  
  protected function afterSave(){
    if($this->isNewRecord){
      $u = User::model()->findByPk($this->to_user_id);
      if($this->send_email and !$this->is_cron_triggered)
        Helper::queueMail($u->username,'TAR | New Message from '.Yii::app()->user->getState('user'),$this->message);
    }
    return parent::afterSave();
  }
  
  
  /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TarMessaging the static model class
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
		return 'tar_messaging';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('to_user_id, message,', 'required'),
			array('from_user_id, to_user_id, is_seen', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, from_user_id, to_user_id, message, is_seen, seen_datetime, timestamp', 'safe', 'on'=>'search'),
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
      'sender' => array(self::BELONGS_TO, 'User', 'from_user_id'),
      'recipient' => array(self::BELONGS_TO, 'User', 'to_user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'from_user_id' => 'From',
			'to_user_id' => 'To',
			'message' => 'Message',
			'is_seen' => 'Seen',
			'seen_datetime' => 'Seen Date',
			'timestamp' => 'Sent Date',
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
		$criteria->compare('from_user_id',$this->from_user_id);
		$criteria->compare('to_user_id',$this->to_user_id);
		$criteria->compare('message',$this->message,true);
		$criteria->compare('is_seen',$this->is_seen);
		$criteria->compare('seen_datetime',$this->seen_datetime,true);
		$criteria->compare('timestamp',$this->timestamp,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
  
  public function getMessages()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('from_user_id',$this->from_user_id);
		$criteria->compare('to_user_id',Yii::app()->user->getState('id'));
		$criteria->compare('message',$this->message,true);
		$criteria->compare('is_seen',$this->is_seen);
		$criteria->compare('seen_datetime',$this->seen_datetime,true);
		$criteria->compare('timestamp',$this->timestamp,true);
    
    $criteria->order = "timestamp desc";

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}