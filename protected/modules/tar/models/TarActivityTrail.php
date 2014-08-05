<?php

/**
 * This is the model class for table "tar_activity_trail".
 *
 * The followings are the available columns in table 'tar_activity_trail':
 * @property integer $id
 * @property string $action
 * @property string $message
 * @property string $timestamp
 * @property integer $log_case_id
 *
 * The followings are the available model relations:
 * @property TarLog $logCase
 */
class TarActivityTrail extends CActiveRecord
{
	
  /**
	 * Override parent after find
	 */
  protected function afterFind(){
    $this->timestamp = date('m/d/Y h:i A',strtotime($this->timestamp));
    return parent::afterFind();
  }
  
  /**
	 * Logger Interface
	 */
  public static function log($action,$message='',$case_id){
    $model = new self;
    $model->action = $action;
    $model->message = $message;
    $model->log_case_id = $case_id;
    $model->save(false);
  }     
  
  /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TarActivityTrail the static model class
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
		return 'tar_activity_trail';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('action, message, timestamp, log_case_id', 'required'),
			array('log_case_id', 'numerical', 'integerOnly'=>true),
			array('action, timestamp', 'length', 'max'=>45),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, action, message, timestamp, log_case_id', 'safe', 'on'=>'search'),
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
			'logCase' => array(self::BELONGS_TO, 'TarLog', 'log_case_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'action' => 'Action',
			'message' => 'Message',
			'timestamp' => 'Timestamp',
			'log_case_id' => 'Log Case',
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
		$criteria->compare('action',$this->action,true);
		$criteria->compare('message',$this->message,true);
		$criteria->compare('timestamp',$this->timestamp,true);
		$criteria->compare('log_case_id',$this->log_case_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
  
  public function getActivity()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('action',$this->action,true);
		$criteria->compare('message',$this->message,true);
		$criteria->compare('timestamp',$this->timestamp,true);
		$criteria->compare('log_case_id',$this->log_case_id);
    
    $criteria->order = 'timestamp desc';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
      'pagination'=>false,
		));
	}
}