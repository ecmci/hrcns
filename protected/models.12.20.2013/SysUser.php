<?php

/**
 * This is the model class for table "sys_user".
 *
 * The followings are the available columns in table 'sys_user':
 * @property integer $idUSER
 * @property string $username
 * @property string $password
 * @property string $f_name
 * @property string $l_name
 * @property string $m_name
 * @property integer $active
 *
 * The followings are the available model relations:
 * @property ReqUser $reqUser
 */
class SysUser extends CActiveRecord
{
	public $hr_access, $req_access;
  
  /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SysUser the static model class
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
		return 'sys_user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('username, password, f_name, l_name', 'required'),
      array('username', 'email'),
			array('active', 'numerical', 'integerOnly'=>true),
			array('username, f_name, l_name, m_name', 'length', 'max'=>45),
			array('password', 'length', 'max'=>100),
      array('hr_access, req_access', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('idUSER, username, password, f_name, l_name, m_name, active, hr_access, req_access', 'safe', 'on'=>'search'),
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
			'reqUser' => array(self::HAS_ONE, 'ReqUser', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'idUSER' => 'User ID',
			'username' => 'Username',
			'password' => 'Password',
			'f_name' => 'First Name',
			'l_name' => 'Last Name',
			'm_name' => 'Middle Name',
			'active' => 'Active',
      'hr_access' => 'Grant Access to HR Module',
      'req_access' => 'Grant Access to Requisition Module',
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
		$criteria->compare('password',$this->password,true);
		$criteria->compare('f_name',$this->f_name,true);
		$criteria->compare('l_name',$this->l_name,true);
		$criteria->compare('m_name',$this->m_name,true);
		$criteria->compare('active',$this->active);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}