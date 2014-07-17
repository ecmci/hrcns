<?php

/**
 * This is the model class for table "hr_employee_basic_archive".
 *
 * The followings are the available columns in table 'hr_employee_basic_archive':
 * @property integer $emp_id
 * @property string $last_name
 * @property string $first_name
 * @property string $middle_name
 * @property string $photo
 * @property integer $active_personal_id
 * @property integer $active_employment_id
 * @property integer $active_payroll_id
 * @property string $timestamp
 */
class EmployeeBasicInfoArchive extends Employee
{

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'hr_employee_basic_archive';
	}

}                                           