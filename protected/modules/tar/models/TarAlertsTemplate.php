<?php

/**
 * This is the model class for table "tar_alerts_tpl".
 *
 * The followings are the available columns in table 'tar_alerts_tpl':
 * @property integer $id
 * @property string $name
 * @property string $data_struct
 *
 * The followings are the available model relations:
 * @property TarAlerts[] $tarAlerts
 */
class TarAlertsTemplate extends CActiveRecord
{
	/**
	 * Override parent and do extra stuff
	 */
  protected function afterFind(){
    $this->data_struct = CJSON::decode($this->data_struct);
    return parent::afterFind();
  }
  
  /**
	 * Override parent and do extra stuff
	 */
  protected function beforeSave(){
    $this->data_struct = CJSON::encode($this->data_struct);
    return parent::beforeSave();
  }     
  
  /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TarAlertsTpl the static model class
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
		return 'tar_alerts_tpl';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, data_struct', 'required'),
			array('name', 'length', 'max'=>45),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, data_struct', 'safe', 'on'=>'search'),
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
			'tarAlerts' => array(self::HAS_MANY, 'TarAlerts', 'alerts_tpl_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'data_struct' => 'Data Struct',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('data_struct',$this->data_struct,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}