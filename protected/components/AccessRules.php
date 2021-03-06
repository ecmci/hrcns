<?php
class AccessRules{
  //user group definitions : ENUM in MYSQL
  public static $EMP = 'EMP';
  public static $BOM = 'BOM';
  public static $FAC_ADM = 'FAC_ADM';
  public static $MNL = 'MNL';
  public static $CORP = 'CORP';
  public static $SYS_ADM = 'SYS_ADM';

    
  public static $rules = array(
    'site'=>array(
  			array('allow', 
  				'actions'=>array('index','uploader','upload','test','upload','help'),
  				'users'=>array('@'),
  				),
        array('allow', 
  				'actions'=>array('error','login','logout','cronpoolemail','cron','disclaimer'),
  				'users'=>array('*'),
  				),
  			array('deny', 
  				'users'=>array('*'),
  				),
  		), // end site
      
      // EMPLOYEE MGT
      'employee'=>array(
        array('allow', 
  				'actions'=>array('applicantselfservice'),
  				'users'=>array('*'),
  				),
        array('allow', 
  				'actions'=>array('create','view','index','admin','printreport','modify'),
  				'roles'=>array('BOM','FAC_ADM','CORP','MNL'),
  				),
        array('allow', 
  				'actions'=>array('delete','import'),
  				'roles'=>array('SYS_ADM'),
  				),
  			array('deny', 
  				'users'=>array('*'),
  				),
      ),
      
      
      
      // change notice requests
      'workflowchangenotice'=>array(
        array('allow', 
  				'actions'=>array('new','newforemployee','view','admin','index','sign','decline','getquick','printreport','print','requiredocs','getdeptcode','redo','routebacktobom'),
  				'roles'=>array('BOM','FAC_ADM','MNL','CORP','SYS_ADMIN'),
  				),
  		array('allow', 
  				'actions'=>array('finalize'),
  				'roles'=>array('CORP'),
  				),
        array('allow', 
  				'actions'=>array('test'),
  				'roles'=>array('SYS_ADMIN'),
  				),
        array('allow', 
  				'actions'=>array('override'),
  				'users'=>array('@'),
          'expression'=>'Yii::app()->user->getState("hr_can_override_routing") == "1"',
          //'expression'=>'$this->canOverride()',
  				),
        array('allow', 
  				'actions'=>array('endorse'),
  				'roles'=>array('BOM','FAC_ADM','CORP'),
  				),
        array('deny', 
  				'users'=>array('*'),
  				), 
      ),
      
      //USER_ADMIN_2
      'sys_user'=>array(
  			array('allow',  // allow all users to perform 'index' and 'view' actions
  				'actions'=>array('view','create','update','admin','delete'),
  				'users'=>array('@'),
  			),
  			array('deny',  // deny all users
  				'users'=>array('*'),
  			),
  		),
      
      //Sitewide user
      'user'=>array(
  			array('allow',  // allow all users to perform 'index' and 'view' actions
  				'actions'=>array('index', 'view','create','update','admin','delete'),
  				'users'=>array('@'),
          'expression'=>'Yii::app()->user->getState("role") == "ADMIN"',
  			),
  			array('deny',  // deny all users
  				'users'=>array('*'),
  			),
  		),
      
      //USER ADMIN      
      'admin_hruser'=>array(
  			array('allow', 
  				'actions'=>array('accountrecovery'),
  				'users'=>array('*'),
  				),
        array('allow', 
  				'actions'=>array('passwordreset'),
  				'users'=>array('@'),
  				),
        array('allow', 
  				'actions'=>array('index','view','admin','create','update','delete'),
  				'users'=>array('@'),
          'expression'=>'Yii::app()->user->getState("role") == "ADMIN"',
  				),
  			array('deny', 
  				'users'=>array('*'),
  				),
  		),//end hruser
      
      //POSITION ADMIN      
      'positions'=>array(
        array('allow', 
  				'actions'=>array('view','admin','create','update','delete'),
  				'users'=>array('@'),
          'expression'=>'Yii::app()->user->getState("role") == "ADMIN"', 
  				),
  			array('deny', 
  				'users'=>array('*'),
  				),
  		),//end position
      
      //DEPT ADMIN      
      'departments'=>array(
        array('allow', 
  				'actions'=>array('view','admin','create','update','delete'),
  				'users'=>array('@'),
          'expression'=>'Yii::app()->user->getState("role") == "ADMIN"', 
  				),
  			array('deny', 
  				'users'=>array('*'),
  				),
  		),//end dept
      
      //HR DOCUMENTS ADMIN
      'hrdocuments'=>array(
			array('allow',  
				'actions'=>array('create','update','delete','admin','view'),
				'users'=>array('@'),
        'expression'=>'Yii::app()->user->getState("role") == "ADMIN"',
			),
			array('deny',  
				'users'=>array('*'),
			),
		),
  );
  
  public static function getRules($controller){
    return self::$rules[$controller];
  }
  
  public static function canSee($field=''){
	switch($field){
		case 'rate_type' :
		case 'rate_proposed' :
		case 'rate_recommended' :
		case 'rate_approved':
		case 'rate_effective_date' :
			$allowed_group = array(self::$CORP,self::$MNL,self::$FAC_ADM); 
			return in_array(Yii::app()->user->getState('hr_group'),$allowed_group);
		break;
	} 
  }
}
?>
