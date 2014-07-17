<?php
Yii::import('application.models.hr._base.Employee0');
class Employee extends Employee0{
  public static function model($className=__CLASS__) {
		return parent::model($className);
	}
  
  public function rules()                  
	{
		return array(
      array('update_reason', 'required', 'on'=>'update'),
      array('photo', 'validatePhoto'),
			array('last_name, first_name', 'required'),
			array('last_name, first_name, middle_name', 'length', 'max'=>128),      
      array('photo,update_reason', 'safe'),

			array('name, emp_id, status, position_code, SSN, date_of_hire, facility_id, department_code', 'safe', 'on'=>'search'),
		);
	}
  
  public function validatePhoto(){
    if(empty($this->photo)) return true;
    $ext = trim(substr($this->photo, -3));
    $allowed = array('jpg');
    if(!in_array($ext,$allowed)){
      $this->addError('photo','File is unacceptable. Allowed extensions are '.implode(', ',$allowed).' only.');    
    }      
  }
  
   public static function getList(){
    $c = new CDbCriteria;
    $c->select = "emp.emp_id, concat(emp.last_name, ', ', emp.first_name) as emp_name";
    $c->join = 'left outer join hr_employee emp on emp.emp_id = t.emp_id';
    $c->addInCondition('t.facility_id',Yii::app()->user->getState('hr_facility_handled_ids'));

	//restrict who can see admins and dons
    if(!AccessRules::canSee('rate_approved')){
		$c->addCondition("t.position_code != 25");//admin
		$c->addCondition("t.position_code != 6");//don
	}
	
    $c->order = 'emp.last_name asc, emp.first_name asc'; 
    return CHtml::listdata(EmployeeEmployment::model()->findAll($c),'emp_id','emp_name'); 
  }
  
  public function search()
	{
		$criteria=new CDbCriteria;

    //load relations
    $criteria->with = 'employmentProfile';

    // parent search
		$criteria->compare('employmentProfile.emp_id',$this->emp_id);
		$criteria->compare('t.last_name',$this->last_name,true,'OR');
		$criteria->compare('t.first_name',$this->first_name,true,'OR');
   
    //restrict who can see admins and dons
    if(!AccessRules::canSee('rate_approved')){
		$criteria->addCondition("employmentProfile.position_code != 25");//admin
		$criteria->addCondition("employmentProfile.position_code != 6");//don
	}
    
    // employment search
    $criteria->compare('employmentProfile.position_code',$this->position_code);
    $criteria->compare('employmentProfile.status',$this->status);

    // sort
    $criteria->order = 't.last_name asc, t.first_name asc';
    
    //filter own facility assigned by default
    if(empty($this->facility_id)){
      $criteria->addInCondition('employmentProfile.facility_id',Yii::app()->user->getState('hr_facility_handled_ids'));
    }else{
      $criteria->compare('employmentProfile.facility_id',$this->facility_id);  
    }

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
      'pagination' => array('pageSize' => 10),
		));
	}
}
?>
