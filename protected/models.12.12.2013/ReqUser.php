<?php

/**
 * This is the model class for table "req_user".
 *
 * The followings are the available columns in table 'req_user':
 * @property integer $user_id
 * @property integer $group
 * @property string $facility_handled_ids
 *
 * The followings are the available model relations:
 * @property Group $group0
 * @property SysUser $user
 */
class ReqUser extends CActiveRecord
{
	
  public function beforeSave(){
    $this->facility_handled_ids = !empty($this->facility_handled_ids) ? implode(',',$this->facility_handled_ids) : '0';
    return parent::beforeSave();
  }
  
  /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ReqUser the static model class
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
		return 'req_user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('group', 'required'),
			array('user_id, group', 'numerical', 'integerOnly'=>true),
			//array('facility_handled_ids', 'length', 'max'=>512),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('user_id, group, facility_handled_ids', 'safe'),
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
			'group0' => array(self::BELONGS_TO, 'Group', 'group'),
			'user' => array(self::BELONGS_TO, 'SysUser', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'user_id' => 'User',
			'group' => 'Group',
			'facility_handled_ids' => 'Facilities Handled',
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

		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('group',$this->group);
		$criteria->compare('facility_handled_ids',$this->facility_handled_ids,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}