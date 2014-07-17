<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property integer $idUSER
 * @property string $username
 * @property string $password
 * @property string $f_name
 * @property string $l_name
 * @property string $m_name
 * @property integer $GROUP_idGROUP
 * @property integer $FACILITY_idFACILITY
 *
 * The followings are the available model relations:
 * @property Requisition[] $requisitions
 * @property Requisition[] $requisitions1
 * @property Requisition[] $requisitions2
 * @property Requisition[] $requisitions3
 * @property Requisition[] $requisitions4
 * @property Group $gROUPIdGROUP
 * @property Facility $fACILITYIdFACILITY
 * @property UserFacility[] $userFacilities
 */
class User extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return User the static model class
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
		return 'user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('username, password, f_name, l_name, GROUP_idGROUP, FACILITY_idFACILITY', 'required'),
			array('username, password, f_name, l_name, GROUP_idGROUP', 'required'),
			array('username','email'),
			array('GROUP_idGROUP, FACILITY_idFACILITY', 'numerical', 'integerOnly'=>true),
			array('username, f_name, l_name, m_name', 'length', 'max'=>45),
			array('password', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('idUSER, username, password, f_name, l_name, m_name, GROUP_idGROUP, FACILITY_idFACILITY', 'safe', 'on'=>'search'),
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
			'requisitions' => array(self::HAS_MANY, 'Requisition', 'USER_idUSER_sign_req'),
			'requisitions1' => array(self::HAS_MANY, 'Requisition', 'USER_idUSER_sign_admin'),
			'requisitions2' => array(self::HAS_MANY, 'Requisition', 'USER_idUSER_sign_corp'),
			'requisitions3' => array(self::HAS_MANY, 'Requisition', 'USER_idUSER_sign_purch'),
			'requisitions4' => array(self::HAS_MANY, 'Requisition', 'USER_idUSER_sign_rcvr'),
			'gROUPIdGROUP' => array(self::BELONGS_TO, 'Group', 'GROUP_idGROUP'),
			//'fACILITYIdFACILITY' => array(self::BELONGS_TO, 'Facility', 'FACILITY_idFACILITY'),
			//'userFacilities' => array(self::HAS_MANY, 'UserFacility', 'USER_idFACILITY'),
			'userFacilities' => array(self::HAS_MANY, 'UserFacility', 'USER_idUSER'),
			//'userFacilities' => array(self::HAS_MANY, 'UserFacility', array('USER_idUSER'=>'idUSER'),'select'=>'userFacilities.FACILITY_idFACILITY','with'=>'facility'),
			'myFacilities' => array(self::HAS_MANY, 'Facility', 'FACILITY_idFACILITY','through'=>'userFacilities'),
		);
	}
	
	public function getMyFacilities($option=''){		
		$my_facilities = $this->myFacilities;		
		if($option=='string'){
			$str = "";
			foreach($my_facilities as $facility){
				$str .= $facility->title.", ";
			}
			return $str;
		}else if($option=='result_set'){
			return $my_facilities;
		}else{
			$arr = array();
			foreach($my_facilities as $facility){
				$arr[$facility->idFACILITY] = $facility->acronym." - ".$facility->title;
			}
			return $arr;
		}
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'idUSER' => 'User ID',
			'username' => 'Username (Valid Email Address)',
			'password' => 'Password',
			'f_name' => 'First Name',
			'l_name' => 'Last Name',
			'm_name' => 'Middle Name',
			'GROUP_idGROUP' => 'Group',
			'FACILITY_idFACILITY' => 'Facility',
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

		$criteria->compare('idUSER',$this->idUSER);
		$criteria->compare('username',$this->username,true);
		//$criteria->compare('password',$this->password,true);
		$criteria->compare('f_name',$this->f_name,true);
		$criteria->compare('l_name',$this->l_name,true);
		//$criteria->compare('m_name',$this->m_name,true);
		$criteria->compare('GROUP_idGROUP',$this->GROUP_idGROUP);
		if(!empty($this->FACILITY_idFACILITY)){
			$criteria->join = 'left join user_facility uf on uf.USER_idUSER = t.idUSER';
			$criteria->compare('uf.FACILITY_idFACILITY',$this->FACILITY_idFACILITY);
		}

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	/** @return actions to perform before saving ie: hash password
         */
	public function beforeSave()
	{
		$this->password = md5($this->password);
		return true;
	}
	
	public function validatePassword($password)
    {
        //return $this->hashPassword($password,$this->salt)===$this->password;
		return md5($password)===$this->password;
    }
	
	public function getFullname()
	{
		return $this->f_name  . ' ' . $this->l_name ;
	}
	
	public function getGroup()
	{
		return $this->gROUPIdGROUP->description;
	}
}