<?php

/**
 * This is the model class for table "tar_notification".
 *
 * The followings are the available columns in table 'tar_notification':
 * @property integer $id
 * @property string $from_user
 * @property string $to_user
 * @property string $subject
 * @property string $message
 * @property integer $sent
 * @property string $sent_datetime
 * @property integer $seen
 * @property string $seen_datetime
 * @property string $timestamp
 */
class TarNotification extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TarNotification the static model class
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
		return 'tar_notification';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('to_user, subject, message', 'required'),
			array('sent, seen', 'numerical', 'integerOnly'=>true),
			array('from_user, to_user, subject', 'length', 'max'=>45),
			array('sent_datetime, seen_datetime, timestamp', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, from_user, to_user, subject, message, sent, sent_datetime, seen, seen_datetime, timestamp', 'safe', 'on'=>'search'),
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
			'from_user' => 'From User',
			'to_user' => 'To User',
			'subject' => 'Subject',
			'message' => 'Message',
			'sent' => 'Sent',
			'sent_datetime' => 'Sent Datetime',
			'seen' => 'Seen',
			'seen_datetime' => 'Seen Datetime',
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
		$criteria->compare('from_user',$this->from_user,true);
		$criteria->compare('to_user',$this->to_user,true);
		$criteria->compare('subject',$this->subject,true);
		$criteria->compare('message',$this->message,true);
		$criteria->compare('sent',$this->sent);
		$criteria->compare('sent_datetime',$this->sent_datetime,true);
		$criteria->compare('seen',$this->seen);
		$criteria->compare('seen_datetime',$this->seen_datetime,true);
		$criteria->compare('timestamp',$this->timestamp,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}