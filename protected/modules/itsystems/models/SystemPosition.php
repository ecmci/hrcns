<?php

/**
 * This is the model class for table "it_system_position".
 *
 * The followings are the available columns in table 'it_system_position':
 * @property integer $id
 * @property integer $system_id
 * @property integer $position_id
 *
 * The followings are the available model relations:
 * @property HrPosition $position
 * @property ItSystem $system
 */
class SystemPosition extends CActiveRecord       
{
	public static function getSystemsForPosition($position_id){
    $systems = self::model()->find("position_id = '$position_id'");
    return empty($systems) ?  null : $systems->system_id;   
  }
  
  public function getSystemNames(){
    $sys = System::model()->findAll( array( 'condition'=>"id in (".implode(',',$this->system_id).")" ) );
    $list = array();
    foreach ($sys as $key=>$value) {
      $list[] = $value->name;    	
    }  
    return implode('<br/>',$list);
  }
  
  public function beforeSave(){
    $this->system_id = CJSON::encode($this->system_id);
    return parent::beforeSave();
  }
  
  public function afterFind(){
    $this->system_id = CJSON::decode($this->system_id);
    return parent::beforeSave();  
  }
  
  /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SystemPosition the static model class
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
		return 'it_system_position';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('system_id, position_id', 'required'),
			array('position_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, system_id, position_id', 'safe', 'on'=>'search'),
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
			'position' => array(self::BELONGS_TO, 'Position', 'position_id'),
			'system' => array(self::BELONGS_TO, 'ItSystem', 'system_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'system_id' => 'Uses The Following Systems...',
			'position_id' => 'Position...',
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
		$criteria->compare('system_id',$this->system_id);
		$criteria->compare('position_id',$this->position_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}