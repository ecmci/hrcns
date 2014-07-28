<?php

/**
 * This is the model class for table "tar_user".
 *
 * The followings are the available columns in table 'tar_user':
 * @property integer $id
 * @property integer $is_active
 *
 * The followings are the available model relations:
 * @property TarLog[] $tarLogs
 * @property TarUserFacility[] $tarUserFacilities
 * @property TarUserGroup[] $tarUserGroups
 */
class TarUser extends CActiveRecord
{
	public $facilities_handled;
  
  public static function getFacilityList(){
    $c = new CDbCriteria;
    $c->select = "t.facility_id as facility_id, a.title as user_id";
    $c->join = "join facility a on a.idFACILITY = t.facility_id";
    $c->compare('t.user_id',Yii::app()->user->getState('id'));
    return CHtml::listdata(TarUserFacility::model()->findAll($c),'facility_id','user_id');   
  }
  
  public function getHandledFacilities(){
    $c = new CDbCriteria;
    $c->select = "GROUP_CONCAT(b.title) as facility_id";
    $c->join = "join facility b on b.idFACILITY = t.facility_id";
    $c->compare('t.user_id',$this->id);
    $c->group = "t.user_id"; 
    $data = TarUserFacility::model()->find($c);
    return $data ? $data->facility_id : '-';
  }                                    
  
  public function getFullName(){
    return $this->parentUser->getFullName();
  }
  
  public function afterFind(){
    //populate facility handled
    $fs = TarUserFacility::model()->findAll(array('select'=>'facility_id','condition'=>"user_id = $this->id"));
    foreach($fs as $f){
      $this->facilities_handled[] = $f->facility_id;
    }
    return parent::afterFind();
  }
  
  
  protected function afterSave(){
    if($this->isNewRecord){
      foreach($this->facilities_handled as $facility_handled){
        $uf = new TarUserFacility;
        $uf->user_id = $this->id;
        $uf->facility_id = $facility_handled;
        $uf->save(false); 
        
        //notify by email
        $u = User::model()->findByPk($this->id);
        Helper::queueMail($u->username,'TAR Log | Account Created',"Hi ".$u->f_name.",\n\nYour account has been enabled for the TAR Log system. You may now login using your existing HR Notice creadentials.");
      }
    }else{
        
        TarUserFacility::model()->deleteAll("user_id = $this->id");
        
        foreach($this->facilities_handled as $facility_handled){
          $uf = new TarUserFacility;
          $uf->user_id = $this->id;
          $uf->facility_id = $facility_handled;
          if($uf->save(false)){
            //Yii::log('Savd!','error','app');
          }else{
            //Yii::log('Not saved!','error','app');
          }
        }
          
      }
    return parent::afterSave();
  }
  
  
  /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TarUser the static model class
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
		return 'tar_user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('is_active, facilities_handled, id, group_id', 'required'),
      array('id', 'validateUserID','on'=>'insert'),
			array('is_active', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, is_active', 'safe', 'on'=>'search'),
		);
	}
  
  public function validateUserID(){
    if(self::model()->exists("id = ".$this->id)){
      $this->addError('id','Already exists!');
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
			'parentUser'=>array(self::BELONGS_TO, 'User', 'id'),
      'group'=>array(self::BELONGS_TO, 'TarGroup', 'group_id'),
      'tarLogs' => array(self::HAS_MANY, 'TarLog', 'created_by_user_id'),
			'facilities' => array(self::HAS_MANY, 'TarUserFacility', 'user_id'),
			'tarUserGroups' => array(self::HAS_MANY, 'TarUserGroup', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'System User',
			'is_active' => 'Is Active',
      'group_id' => 'Group',
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

		$criteria->compare('t.id',$this->id);
		$criteria->compare('t.is_active',$this->is_active);
    $criteria->compare('t.group_ids',$this->group_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}