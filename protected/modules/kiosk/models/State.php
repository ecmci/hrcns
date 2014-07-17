<?php

/**
 * This is the model class for table "state".
 *
 * The followings are the available columns in table 'state':
 * @property string $name_long
 * @property string $name_short
 */
class State extends CActiveRecord
{
	public static function getList(){
    $states = self::model()->findAll(array(
      'limit'=>20
    ));
    $data = array();
    foreach($states as $state) $data[] = $state->name_long;
    return $data; 
  }
  
  /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return State the static model class
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
		return 'state';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name_long', 'length', 'max'=>20),
			array('name_short', 'length', 'max'=>2),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('name_long, name_short', 'safe', 'on'=>'search'),
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
			'name_long' => 'Name Long',
			'name_short' => 'Name Short',
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

		$criteria->compare('name_long',$this->name_long,true);
		$criteria->compare('name_short',$this->name_short,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}