<?php
class Report{
	/**
	 * Gets All Union Employee Bdays for the current year
	 */
	public static function getEmployeeBirthday($month){
		$data = Yii::app()->db->createCommand()
			->select('t.*, a.*,b.*')
			->from('hr_employee t')
			->leftJoin('hr_employee_personal a','a.id = t.active_personal_id')
			->leftJoin('hr_employee_employment b','b.id = t.active_employment_id')
			->where('b.facility_id in('.implode(',',Yii::app()->user->getState('hr_facility_handled_ids')).')')
			->andWhere('month(a.birthdate) = '.$month)
			->andWhere('b.date_of_termination = "0000-00-00"')
			->order('day(a.birthdate) asc')
			->queryAll();
		return new CArrayDataProvider($data, array(
			'pagination'=>array(
				'pageSize'=>1000,
			),
		));
	} 
	
	
	/**
	 * Gets All Union Employees
	 */ 
	public static function getUnionEmployees(){
		$data = Yii::app()->db->createCommand()
			->select('t.*, a.*, b.*, c.*,d.name as position, e.name as department')
			->from('hr_employee t')
			->leftJoin('hr_employee_personal a','a.id = t.active_personal_id')
			->leftJoin('hr_employee_employment b','b.id = t.active_employment_id')
			->leftJoin('hr_employee_payroll c','c.id = t.active_payroll_id')
			->leftJoin('hr_position d','d.code = b.position_code')
			->leftJoin('hr_department e','e.code = b.department_code')
			->where('b.facility_id in('.implode(',',Yii::app()->user->getState('hr_facility_handled_ids')).')')
			->andWhere('b.has_union = 1')
			->queryAll();
		return new CArrayDataProvider($data, array(
			'pagination'=>array(
				'pageSize'=>1000,
			),
		));
	}
}
?>
