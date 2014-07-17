<?php

/**
 * This is the model class for table "hr_position".
 *
 * The followings are the available columns in table 'hr_position':
 * @property integer $code
 * @property string $name
 * @property string $job_description
 *
 * The followings are the available model relations:
 * @property HrEmployeeEmployment[] $hrEmployeeEmployments
 */
class Position0 extends CActiveRecord
{
	
  public static function getList($value='code',$title='name'){
    $criteria = new CDbCriteria;
    $criteria->order = 'name asc';
    return CHtml::listdata(self::model()->findAll($criteria),$value,$title);
  }
  
  /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Position the static model class
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
		return 'hr_position';
	}

  /**
   * @return array validation rules for model attributes.
   */
  public function rules()
  {
      // NOTE: you should only define rules for those attributes that
      // will receive user inputs.
      return array(
          array('code, name, job_code, dept_code', 'required'),
          array('code, job_code, dept_code', 'numerical', 'integerOnly'=>true),
          array('name', 'length', 'max'=>16),
          array('job_description', 'safe'),
          // The following rule is used by search().
          // Please remove those attributes that should not be searched.
          array('code, name, job_code, dept_code, job_description', 'safe', 'on'=>'search'),
      );
  }
  
  public function validateCode(){
    if(self::model()->exists("code = '$this->code'")){
      $this->addError('code','Code already exists!');
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
			'hrEmployeeEmployments' => array(self::HAS_MANY, 'HrEmployeeEmployment', 'position_code'),
		);
	}

  /**
  * @return array customized attribute labels (name=>label)
  */
  public function attributeLabels()
  {
    return array(
        'code' => 'Code',
        'name' => 'Name',
        'job_code' => 'Job Code',
        'dept_code' => 'Dept Code',
        'job_description' => 'Job Description',
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

		$criteria->compare('code',$this->code);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('job_description',$this->job_description,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}