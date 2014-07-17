<?php

/**
 * This is the model class for table "hr_employee".
 *
 * The followings are the available columns in table 'hr_employee':
 * @property integer $emp_id
 * @property string $last_name
 * @property string $first_name
 * @property string $middle_name
 * @property string $photo
 *
 * The followings are the available model relations:
 * @property HrEmployeePayroll[] $hrEmployeePayrolls
 * @property HrEmployeePersonal[] $hrEmployeePersonals
 */
abstract class Employee0 extends CActiveRecord
{

  public static function log($emp_id, $action , $comment){  
    $log_message = "EMPLOYEE: $action Employee Id $emp_id by user ".Yii::app()->user->name.' | User Comment: '.$comment;
    Yii::log($log_message,'info','app');  
  }
  
  public function afterFind(){
    $this->name = $this->getFullName();
    //$employment = $this->getEmploymentInfo();
    //$this->status = $employment->status;
    //$this->facility_id = $employment->facility_id;
    //$this->position_code = $employment->position_code;
    $this->has_active_change_notice = true;          
    return parent::afterFind();
  }
  
  private function getEmploymentInfo(){
    $c = new CDbCriteria;
    $c->select = "status, f.title as facility_id, p.name as position_code";
    
    $c->join = "left outer join facility f on f.idFACILITY = t.facility_id";
    $c->join .= " left outer join hr_position p on p.code = t.position_code";
    
    if($this->active_employment_id) // get the active profile
      $c->compare('id',$this->active_employment_id);
    else{ // get the latest profile
      $c->compare ('emp_id', $this->emp_id);
      $c->order = 'timestamp desc';      
    }
    return EmployeeEmployment::model()->find($c);
  }
  
  
  public static function renderGridviewButtonColumn($model,$row,$controller){
    $controller->widget('bootstrap.widgets.TbButtonGroup', array(
        'type'=>'primary', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
        'buttons'=>array(
           array('label'=>'Actions', 'items'=>array(
             array('label'=>'View Details', 'url'=>array('hr/employee/view','id'=>$model->emp_id),'icon'=>'eye-open'),
             //array('label'=>'Edit', 'url'=>array('hr/employee/update','id'=>$model->emp_id),'icon'=>'pencil'),
             '---',
             array('label'=>'New Change Notice Form', 'url'=>array('hr/workflowchangenotice/new','id'=>$model->emp_id),'icon'=>'cog'),
            ),
            'icon'=>'question-sign white',
            'htmlOptions'=>array('rel'=>'tooltip','title'=>'What do you want to do?'),
          ),
        ),
    )); 
  }
  
  public function renderGridPhoto($data, $row){
    return "
      <div class='thumbnail'>
        <a href='".Yii::app()->createUrl('hr/employee/view',array('id'=>$data->emp_id))."' rel='tooltip' title='Click to view ".$data->name."`s details'>
        <img src='".Yii::app()->baseUrl."/uploads/".$data->photo."' alt='".$data->name."' title='".$data->name."' style='width:75px;' />
        </a>
      </div>  
    ";
  }
  
  public function getFullName(){
    return strtoupper($this->last_name).', '.$this->first_name. ' '.$this->middle_name;
  }
  
  public static function getFullNameStatic($emp_id){
    return self::model()->find(array(
      'select'=>"concat(last_name,', ',first_name) as first_name",
      'condition'=>"emp_id = '$emp_id'",
    ))->first_name;
  }
  
  public function getFullNameWithID(){
    return strtoupper($this->last_name).', '.$this->first_name. ' '.$this->middle_name.' - '.$this->emp_id;
  }
  
 
  public static function getList(){
    $c = new CDbCriteria;
    $c->select = "emp.emp_id, concat(emp.last_name, ', ', emp.first_name) as emp_name";
    $c->join = 'left outer join hr_employee emp on emp.emp_id = t.emp_id';
    $c->addInCondition('t.facility_id',Yii::app()->user->getState('hr_facility_handled_ids'));
    $c->order = 'emp.last_name asc, emp.first_name asc'; 
    return CHtml::listdata(EmployeeEmployment::model()->findAll($c),'emp_id','emp_name'); 
  }
  
  public function beforeValidate(){
    
    return parent::beforeValidate();
  }
  
  
  /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Employee the static model class
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
		return 'hr_employee';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()                  
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
      array('update_reason', 'required', 'on'=>'update'),
      array('photo', 'file', 'allowEmpty' => true, 'types' => 'jpg, jpeg, gif, png'),
			array('last_name, first_name', 'required'),
			array('last_name, first_name, middle_name', 'length', 'max'=>128),      
      array('photo,update_reason', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('name, emp_id, status, position_code, SSN, date_of_hire, facility_id, department_code', 'safe', 'on'=>'search'),
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
//         'hrEmployeeEmployments' => array(self::HAS_MANY, 'EmployeeEmployment', 'emp_id'),
//         'hrEmployeePayrolls' => array(self::HAS_MANY, 'EmployeePayroll', 'emp_id'),
//         'hrEmployeePersonals' => array(self::HAS_MANY, 'EmployeePersonal', 'emp_id'),
        
        'employmentProfile' => array(self::BELONGS_TO, 'EmployeeEmployment' , 'active_employment_id'),
        //'personalProfile' => array(self::HAS_ONE, 'EmployeePersonalInfo' , 'id'),
        //'payrollProfile' => array(self::HAS_ONE, 'EmployeePayroll' , 'id'),
        
    );
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'emp_id' => 'Employee ID',
			'last_name' => 'Last Name',
			'first_name' => 'First Name',
			'middle_name' => 'Middle Name',
			'photo' => 'Photo',
      
      'facility_id' => 'Facility',
      'department_code' => 'Department',
      'position_code' => 'Position',
      'SSN' => 'Social Security Number',

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

    //load relations
    $criteria->with = 'employmentProfile';

    // parent search
		$criteria->compare('t.emp_id',$this->emp_id,true);
		$criteria->compare('t.last_name',$this->last_name,true,'OR');
		$criteria->compare('t.first_name',$this->first_name,true,'OR');
   
    
    // employment search
 		$criteria->compare('employmentProfile.facility_id',$this->facility_id);
    $criteria->compare('employmentProfile.position_code',$this->position_code);
    $criteria->compare('employmentProfile.status',$this->status);

    // sort
    $criteria->order = 't.last_name asc, t.first_name asc';

    //Yii::log('EMPLOYEE CRIT:'.print_r($criteria,true),'info','app');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
  
  public static $sql_join_profiles_latest_version = "
    left outer join hr_employee_personal personal on (personal.emp_id = t.emp_id and personal.id= (select id from hr_employee_personal where emp_id = t.emp_id order by timestamp desc limit 1))
    left outer join hr_employee_employment employment on (employment.emp_id = t.emp_id and employment.id= (select id from hr_employee_employment where emp_id = t.emp_id order by timestamp desc limit 1))
    left outer join hr_employee_payroll payroll on (payroll.emp_id = t.emp_id and payroll.id= (select id from hr_employee_payroll where emp_id = t.emp_id order by timestamp desc limit 1))  
  ";
  
  public static $sql_join_profiles_active = "
    left outer join hr_employee_personal personal on personal.id = t.active_personal_id
    left outer join hr_employee_employment employment on employment.id = t.active_employment_id 
    left outer join hr_employee_payroll payroll on payroll.id = t.active_payroll_id
  ";
  
  // alphas
  public $name;
  public $has_active_change_notice;
  public $update_reason;
  
  
  //foreigners
	public $birthdate;
	public $gender;
	public $marital_status;
	public $SSN;
	public $number;
	public $building;
	public $street;
	public $zip_code;
	public $telephone;
	public $cellphone;
	public $email;
  
  public $facility_id;
  public $status;
  public $date_of_hire;
  public $date_of_termination;
  public $department_code;
  public $position_code; 
  public $start_date;
  public $end_date;

  
  public $is_pto_eligible;
  public $pto_effective_date;
  public $fed_expt;
  public $fed_add;
  public $state_expt;
  public $state_add;
  public $rate_type;
  public $rate_proposed;
  public $rate_recommended;
  public $rate_approved;
  public $rate_effective_date;
  public $deduc_health_code;
  public $deduc_health_amt;
  public $deduc_dental_code;
  public $deduc_dental_amt;
  public $deduc_other_code;
  public $deduc_other_amt;
}
