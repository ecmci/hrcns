<?php

/**
 * This is the model class for table "hr_user".
 *
 * The followings are the available columns in table 'hr_user':
 * @property integer $user_id
 * @property string $group
 * @property string $facility_handled_ids
 * @property integer $can_override_routing
 *
 * The followings are the available model relations:
 * @property HrWorkflowChangeNotice[] $hrWorkflowChangeNotices
 */
class HrcnsUser extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return HrcnsUser the static model class
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
		return 'hr_user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id', 'required'),
			array('user_id, can_override_routing', 'numerical', 'integerOnly'=>true),
			array('group', 'length', 'max'=>7),
			array('facility_handled_ids', 'length', 'max'=>512),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('user_id, group, facility_handled_ids, can_override_routing', 'safe', 'on'=>'search'),
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
			'hrWorkflowChangeNotices' => array(self::HAS_MANY, 'HrWorkflowChangeNotice', 'processing_user'),
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
			'facility_handled_ids' => 'Facility Handled Ids',
			'can_override_routing' => 'Can Override Routing',
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
		$criteria->compare('group',$this->group,true);
		$criteria->compare('facility_handled_ids',$this->facility_handled_ids,true);
		$criteria->compare('can_override_routing',$this->can_override_routing);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}