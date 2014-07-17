<?php
class Security{
	public static $CONTROLLER_RULES = array(
		'notice'=>array(
			array('allow',  // allow auth users
				'actions'=>array('index','getrequiredattachments','upload','search','printreport'),
				'users'=>array('@'),
			),
			array('allow',  // allow auth users
				'actions'=>array('prepare'),
				'users'=>array('@'),
				'expression'=>'Security::canPrepareNotice()',
			),
			array('allow',  // allow auth users
				'actions'=>array('view','review','sign','print','cancel'),
				'users'=>array('@'),
				'expression'=>'Security::canViewNotice()',
			),
			array('allow',  // allow auth users
				'actions'=>array('edit'),
				'users'=>array('@'),
				'expression'=>'Security::canEditNotice()',
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		),
		'employee'=>array(
			array('allow',  // allow auth users
				'actions'=>array('search','printreport'),
				'users'=>array('@'),
			),
			array('allow',  // allow auth users
				'actions'=>array('view'),
				'users'=>array('@'),
				'expression'=>'Security::canViewEmployee()',
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		),
		'report'=>array(
			array('allow',  // allow auth users
				'actions'=>array('index','view'),
				'users'=>array('@'),
			),
			array('allow',  // allow auth users
				'actions'=>array('create','update','delete','admin'),
				'users'=>array('@'),
				'expression'=>'Yii::app()->user->getState("role") == "ADMIN"',
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		),
		'position_license_map'=>array(
			array('allow',  // allow auth users
				'actions'=>array('getmappedlicenses'),
				'users'=>array('@'),
			),
			array('allow',  // allow auth users
				'actions'=>array('index','view','create','update','delete','admin'),
				'users'=>array('@'),
				'expression'=>'Yii::app()->user->getState("role") == "ADMIN"',
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		),
	);
	
	public static function canViewEmployee(){
		$params = Yii::app()->controller->actionParams;
		$employee = Employee::model()->findByPk($params['id']);
		
		// POLICY: BOMs cannot view Facility Admins (25) and DONS (6)
		$restricted_positions = array('25','6');
		if('BOM' == Yii::app()->user->getState('hr_group') and in_array($employee->employment->position_code,$restricted_positions)){
			return false;
		}
		
		//POLICY: Users can only see those which belong to their facility
		$hr_facility_handled_ids = Yii::app()->user->getState('hr_facility_handled_ids');
		if(!in_array($employee->employment->facility_id,$hr_facility_handled_ids)){
			return false;
		}
		
		return true;
	}
	
	public static function canEditNotice(){
		// POLICY: Edit own notice or by groups with elevated access
		
		$params = Yii::app()->controller->actionParams;
		$notice = Notice::model()->findByPk($params['id']);
		$auth_groups = array('MNL','CORP','BOM');

		if(in_array(Yii::app()->user->getState('hr_group'),$auth_groups)){
			return true;
		}
				
		return (Yii::app()->user->getState('id') == $notice->initiated_by);
	}
	
	public static function canViewNotice(){
		$params = Yii::app()->controller->actionParams;
		$notice = Notice::model()->findByPk($params['id']);
		
		//POLICY: Users can only see those which belong to their facility
		$hr_facility_handled_ids = Yii::app()->user->getState('hr_facility_handled_ids');
		if(!in_array($notice->employment->facility_id,$hr_facility_handled_ids)){
			return false;
		}
		
		// POLICY: BOMs cannot view Facility Admins (25) and DONS (6)
		$restricted_positions = array('25','6');
		if('BOM' == Yii::app()->user->getState('hr_group') and in_array($notice->employment->position_code,$restricted_positions)){
			return false;
		}
		return true;
	}
	
	public static function canPrepareNotice(){
		$params = Yii::app()->controller->actionParams;

		// POLICY: BOMs cannot prepare a new change notice for Facility Admins (25), DONS (6) and other employees belonging to other facilities
		if('c' == $params['f'] and 'BOM' == Yii::app()->user->getState('hr_group')){
			$restricted_positions = array('25','6');
			$employee = Employee::model()->findByPk($params['e']);
			if(in_array($employee->employment->position_code,$restricted_positions)) return false;
			if(!in_array($employee->employment->facility_id,Yii::app()->user->getState('hr_facility_handled_ids'))) return false;
		}
		
		return true;
	}

	public static function getControllerRules($controller){
		return self::$CONTROLLER_RULES[$controller];
	}
}
?>
