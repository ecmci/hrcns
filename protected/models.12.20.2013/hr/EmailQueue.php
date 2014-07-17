<?php

/**
 * This is the model class for table "email_queue".
 *
 * The followings are the available columns in table 'email_queue':
 * @property integer $id
 * @property string $from
 * @property string $to
 * @property string $subject
 * @property string $message
 * @property integer $sent
 * @property string $sent_timestamp
 * @property string $queued_timestamp
 */
class EmailQueue extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return EmailQueue the static model class
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
		return 'email_queue';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('from, to, subject, message', 'required'),
			array('sent', 'numerical', 'integerOnly'=>true),
			array('from, to, subject', 'length', 'max'=>128),
			array('sent_timestamp, queued_timestamp', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, from, to, subject, message, sent, sent_timestamp, queued_timestamp', 'safe', 'on'=>'search'),
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
			'from' => 'From',
			'to' => 'To',
			'subject' => 'Subject',
			'message' => 'Message',
			'sent' => 'Sent',
			'sent_timestamp' => 'Sent Timestamp',
			'queued_timestamp' => 'Queued Timestamp',
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
		$criteria->compare('from',$this->from,true);
		$criteria->compare('to',$this->to,true);
		$criteria->compare('subject',$this->subject,true);
		$criteria->compare('message',$this->message,true);
		$criteria->compare('sent',$this->sent);
		$criteria->compare('sent_timestamp',$this->sent_timestamp,true);
		$criteria->compare('queued_timestamp',$this->queued_timestamp,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}