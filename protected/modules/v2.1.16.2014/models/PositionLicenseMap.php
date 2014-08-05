<?php

/**
 * This is the model class for table "hr_position_license_map".
 *
 * The followings are the available columns in table 'hr_position_license_map':
 * @property integer $id
 * @property integer $position_code
 * @property string $license_name
 * @property string $default_expiration
 *
 * The followings are the available model relations:
 * @property HrPosition $positionCode
 */
class PositionLicenseMap extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PositionLicenseMap the static model class
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
		return 'hr_position_license_map';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('position_code, license_name', 'required'),
			array('position_code', 'numerical', 'integerOnly'=>true),
			array('license_name, default_expiration', 'length', 'max'=>128),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, position_code, license_name, default_expiration', 'safe', 'on'=>'search'),
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
			'position' => array(self::BELONGS_TO, 'Position', 'position_code'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'position_code' => 'Position Code',
			'license_name' => 'License Name',
			'default_expiration' => 'Default Expiration',
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
		$criteria->compare('position_code',$this->position_code);
		$criteria->compare('license_name',$this->license_name,true);
		$criteria->compare('default_expiration',$this->default_expiration,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
