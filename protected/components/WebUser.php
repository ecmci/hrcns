<?php 
class WebUser extends CWebUser
{
    /**
     * Overrides a Yii method that is used for roles in controllers (accessRules).
     *
     * @param string $operation Name of the operation required (here, a role).
     * @param mixed $params (opt) Parameters for this operation, usually the object to access.
     * @return bool Permission granted?
     */
    public function checkAccess($operation, $params=array())
    {
      $user_group = Yii::app()->user->getState('hr_group');
      
      if ($user_group === AccessRules::$SYS_ADM) {
        return true; // admin role has access to everything
      }
      
      // allow access if the operation request is the current user's role
      return ($operation === $user_group);
    }
    
   
    
}