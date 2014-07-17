<?php

/**
 * This is the model class for table "hr_user".
 *
 * The followings are the available columns in table 'hr_user':
 * @property integer $user_id
 * @property string $group
 * @property string $facility_handled_ids
 */
class HrUser extends CActiveRecord
{
	
  public $facility_handled, $email, $new_password, $repeat_password;
  
  // define
  public static $BOM = 'BOM';
  public static $FAC_ADM = 'FAC_ADM';
  public static $MNL = 'MNL';
  public static $CORP = 'CORP';
 
   public static function getMyFacilities($print=false){
      $list = array();
      $fs = Facility::model()->findAll(array('select'=>'description', 'condition'=>'idFACILITY IN('.implode(',',Yii::app()->user->getState('hr_facility_handled_ids')).')'));
      foreach($fs as $f){
        $list[] = $f->description;
      }
      return ($print) ? implode(', ',$list) : $list;
    }
 

  /* PRE-PROCESSING */  
  public function beforeValidation(){
    //$this->facility_handled_ids = !empty($this->facility_handled_ids) ? implode(',',$this->facility_handled_ids) : NULL;
    return parent::beforeValidation();
  }
  
  public function afterValidation(){

    return parent::afterValidation();
  }
  
  public function beforeSave(){
    $this->facility_handled_ids = !empty($this->facility_handled_ids) ? implode(',',$this->facility_handled_ids) : '0';
    return parent::beforeSave();
  }
  
  public function afterFind(){
    $f = Facility::model()->findAll(array(
      'select'=>'title',
      'condition'=>'idFACILITY in ('.$this->facility_handled_ids.')',
      'order'=>'title asc'
    ));
    $this->facility_handled = implode('<br/>',$f);
    $this->facility_handled_ids = !empty($this->facility_handled_ids) ? explode(',',$this->facility_handled_ids) : array();
    return parent::afterFind();
  }
  
  
  /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return HrUser the static model class
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
      array('group', 'required'),
      
      array('email', 'required', 'on'=>'recovery'),
      array('email', 'email', 'on'=>'recovery'),
      array('email', 'emailExists', 'on'=>'recovery'),
      
      array('new_password, repeat_password', 'required', 'on'=>'pwreset'),
      array('new_password, repeat_password', 'length', 'min'=>6, 'max'=>40,'on'=>'pwreset'),
      array('new_password', 'compare', 'compareAttribute'=>'repeat_password','message'=>"Passwords don't match!", 'on'=>'pwreset'),
			
      array('user_id, group, facility_handled_ids', 'required', 'on'=>'new'),
      array('facility_handled_ids', 'hasFacilities', 'on'=>'new'),      
      array('user_id', 'validateUserId', 'on'=>'new'),
			
      array('user_id', 'numerical', 'integerOnly'=>true),
			array('group', 'length', 'max'=>7),
      array('can_override_routing, email, facility_handled_ids', 'safe'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('user_id, group, facility_handled_ids', 'safe', 'on'=>'search'),
		);
	}
  
  /* MY VALIDATORS */
  public function hasFacilities(){
    if(!is_array($this->facility_handled_ids)) {
      $this->addError('facility_handled_ids','Facilities Handled is required.');  
    }
  }
  
  public function emailExists(){
    if(!User::model()->exists("username = :username",array('username'=>$this->email))) {
      $this->addError('username','This email is not registered.');
    }  
  }
  
  public function validateUserId($attribute,$params){
    if(!$this->isNewRecord)return;
    if(HrUser::model()->exists("user_id = :user_id",array('user_id'=>$this->user_id))) {
      $this->addError('user_id','User already exists!');
    }
  }

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
      'user' => array(self::BELONGS_TO, 'User', 'user_id'),  
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'user_id' => 'User ID',
			'group' => 'Group',
			'facility_handled_ids' => 'Facilities Handled',
      'facility_handled' => 'Facilities Handled',
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
    $criteria->join = 'left join user u on u.idUSER = t.user_id';


		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('`group`',$this->group);
		$criteria->compare('facility_handled_ids',$this->facility_handled_ids,true);
    $criteria->compare('can_override_routing',$this->can_override_routing);

    $criteria->order = 'u.l_name asc';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}