<?php
class Navigation{
  public static function getMenuItems(){
    return array(
        array('label'=>"Notice",'url'=>array('/v2'),'visible'=>!Yii::app()->user->isGuest),
        array('label'=>"TAR",'url'=>array('/tar'),'visible'=>!Yii::app()->user->isGuest),
        array('label'=>"Hello, ".Yii::app()->user->getState('user').' ('.Helper::printEnumValue(Yii::app()->user->getState('hr_group')).')','url'=>array('#'),'itemOptions'=>array('class'=>'dropdown'),'linkOptions'=>array('id'=>'user-module','class'=>'dropdown-toggle','data-toggle'=>"dropdown"),
          'items'=>array( 
              //array('label'=>'Help','url'=>array('/site/help')),
              array('label'=>'Reset Password','url'=>array('/admin/hruser/passwordreset')),
              //array('label'=>'Try Version 2.0','url'=>array('/v2/notice')),
              array('label'=>'System Accounts Requests','visible'=>Yii::app()->user->getState('role') == 'ADMIN' ,'url'=>array('/itsystems/request')),
              array('label'=>'Manage System Users','visible'=>Yii::app()->user->getState('role') == 'ADMIN' ,'url'=>array('/admin/user/admin')),
              array('label'=>'','url'=>array('#'),'visible'=>Yii::app()->user->getState('role') == 'ADMIN','itemOptions'=>array('class'=>'divider')),
              array('label'=>'HR Notice Mgt','visible'=>Yii::app()->user->getState('role') == 'ADMIN'),
              array('label'=>'Manage HR Users','visible'=>Yii::app()->user->getState('role') == 'ADMIN','url'=>array('/admin/hruser/admin')),
              array('label'=>'Manage Positions','visible'=>Yii::app()->user->getState('role') == 'ADMIN','url'=>array('/admin/positions/admin')),
              array('label'=>'Manage Departments','visible'=>Yii::app()->user->getState('role') == 'ADMIN','url'=>array('/admin/departments/admin')),
              array('label'=>'Manage HR Required Documents','visible'=>Yii::app()->user->getState('role') == 'ADMIN' ,'url'=>array('/admin/hrdocuments/admin')),
              array('label'=>'Manage Carbon Copies','visible'=>Yii::app()->user->getState('role') == 'ADMIN' ,'url'=>array('/carboncopy/manage/admin')),
              array('label'=>'Technical Manual','url'=>Yii::app()->baseUrl.'/help/TM.pdf','visible'=>Yii::app()->user->getState('role') == 'ADMIN'),
              array('label'=>'','url'=>array('#'),'visible'=>Yii::app()->user->getState('role') == 'ADMIN','itemOptions'=>array('class'=>'divider')),
              array('label'=>'TAR Mgt','visible'=>Yii::app()->user->getState('role') == 'ADMIN'),
              array('label'=>'Manage TAR Users','visible'=>Yii::app()->user->getState('role') == 'ADMIN','url'=>array('/tar/manage/user')),
              array('label'=>'Manage Procedures Templates','visible'=>Yii::app()->user->getState('role') == 'ADMIN','url'=>array('/tar/manage/proceduretemplates')),
              array('label'=>'Manage Alerts Templates','visible'=>Yii::app()->user->getState('role') == 'ADMIN','url'=>array('/tar/manage/alerttemplates')),
              array('label'=>'Technical Manual','url'=>Yii::app()->baseUrl.'/help/TM.pdf','visible'=>Yii::app()->user->getState('role') == 'ADMIN'),              
              array('label'=>'','url'=>array('#'),'itemOptions'=>array('class'=>'divider')),
              array('label'=>'Logout','url'=>array('/site/logout')),              
              
          ),
          'visible'=>!Yii::app()->user->isGuest,
        ),
    );
  }
  
  public static function getMenuItems0(){
    return array(
      array('label'=>"Home",'url'=>array('/site/index'),
          //'visible'=>Yii::app()->user->isGuest,
        ),
        array('label'=>"Kiosk",'url'=>array('/kiosk/'),
          'visible'=>Yii::app()->user->isGuest,
        ),
//         array('label'=>"Change Notice Requests",'url'=>array('#'),'itemOptions'=>array('class'=>'dropdown'),'linkOptions'=>array('id'=>'change-notice-module','class'=>'dropdown-toggle','data-toggle'=>"dropdown"),
//           'items'=>array(
//               array('label'=>'New','itemOptions'=>array('class'=>'nav-header')),
//               array('label'=>'New Change Notice Form','url'=>array('/hr/workflowchangenotice/newforemployee/')),              
//               array('label'=>'','itemOptions'=>array('class'=>'divider')),
//               //array('label'=>'View','itemOptions'=>array('class'=>'nav-header')),              
//               array('label'=>'Search','url'=>array('/hr/workflowchangenotice')),
//               //array('label'=>'My Requests','url'=>'#'),   
//           ),
//           'visible'=>!Yii::app()->user->isGuest,
//         ),
//         array('label'=>"Employee",'url'=>array('#'),'itemOptions'=>array('class'=>'dropdown'),'linkOptions'=>array('id'=>'employee-module','class'=>'dropdown-toggle','data-toggle'=>"dropdown"),
//           'items'=>array(
//               array('label'=>'New','itemOptions'=>array('class'=>'nav-header')),
//               array('label'=>'New Hire Form','url'=>array('/hr/employee/create')),           
//               array('label'=>'','itemOptions'=>array('class'=>'divider')),
//               array('label'=>'Search','url'=>array('/hr/employee')),  
//           ),
//           'visible'=>!Yii::app()->user->isGuest,
//         ),
        array('label'=>"Help",'url'=>array('/site/help'),
          'visible'=>!Yii::app()->user->isGuest,
        ),
        array('label'=>"Hello, ".Yii::app()->user->getState('user').' ('.Helper::printEnumValue(Yii::app()->user->getState('hr_group')).')','url'=>array('#'),'itemOptions'=>array('class'=>'dropdown'),'linkOptions'=>array('id'=>'user-module','class'=>'dropdown-toggle','data-toggle'=>"dropdown"),
          'items'=>array( 
              //array('label'=>'Help','url'=>array('/site/help')),
              array('label'=>'Reset Password','url'=>array('/admin/hruser/passwordreset')),
              array('label'=>'Try Version 2.0','url'=>array('/v2/notice')),
              array('label'=>'System Accounts Requests','visible'=>Yii::app()->user->getState('role') == 'ADMIN' ,'url'=>array('/itsystems/request')),
              array('label'=>'Manage System Users','visible'=>Yii::app()->user->getState('role') == 'ADMIN' ,'url'=>array('/admin/user/admin')),
              array('label'=>'Manage HR Users','visible'=>Yii::app()->user->getState('role') == 'ADMIN','url'=>array('/admin/hruser/admin')),
              array('label'=>'Manage Positions','visible'=>Yii::app()->user->getState('role') == 'ADMIN','url'=>array('/admin/positions/admin')),
              array('label'=>'Manage Departments','visible'=>Yii::app()->user->getState('role') == 'ADMIN','url'=>array('/admin/departments/admin')),
              array('label'=>'Manage HR Required Documents','visible'=>Yii::app()->user->getState('role') == 'ADMIN' ,'url'=>array('/admin/hrdocuments/admin')),
              array('label'=>'Manage Carbon Copies','visible'=>Yii::app()->user->getState('role') == 'ADMIN' ,'url'=>array('/carboncopy/manage/admin')),
              array('label'=>'Technical Manual','url'=>Yii::app()->baseUrl.'/help/TM.pdf','visible'=>Yii::app()->user->getState('role') == 'ADMIN'),
              array('label'=>'Logout','url'=>array('/site/logout')),              
              
          ),
          'visible'=>!Yii::app()->user->isGuest,
        ),
        array('label'=>"Applicant Self-Service",'url'=>array('hr/employee/applicantselfservice'),
          'visible'=>false,
        ),
    );  
  }
}
?>
