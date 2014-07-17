<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	 
  	private $_id;
  	private $_group;
 
    public function authenticateCOMING(){
      
    
    }
 
    public function authenticate()
    {
        $username=strtolower($this->username);
        $user=User::model()->find('LOWER(username)=?',array($username));
        if($user===null){
            Yii::log("LOGIN: $username log in failed from ".$_SERVER['REMOTE_ADDR'],'error','app');
            $this->errorCode=self::ERROR_USERNAME_INVALID;
         }else if(md5($this->password) != $user->password){
            Yii::log("LOGIN: $username log in failed from ".$_SERVER['REMOTE_ADDR'],'error','app');
            $this->errorCode=self::ERROR_PASSWORD_INVALID;
        }else
        {
            //store user's identity info in a session
            $this->_id=$user->idUSER;
            $this->username=$user->username;
            $this->setState('user', $user->f_name);	
            
            // session vars for requisition module
            $group = Group::model()->findByPk($user->GROUP_idGROUP);
            $this->setState('id', $this->_id);			
            $this->setState('role', $user->role); //sets the role for this user
            $this->setState('group_id', $group->idGROUP);
            $this->_group = $group->title;
            
            // session vars for hr module
            $hr_group = HrUser::model()->find("user_id = '$user->idUSER'");
            $this->setState('hr_group', isset($hr_group) ? $hr_group->group : '0');
            $this->setState('hr_facility_handled_ids', isset($hr_group) ? $hr_group->facility_handled_ids : '0');
            $this->setState('hr_can_override_routing', isset($hr_group) ? $hr_group->can_override_routing : '0');
            
            //module access
            $this->setState('hr_group', isset($hr_group) ? $hr_group->group : '0');
            
            Yii::log("LOGIN: $username logged in successfully from ".$_SERVER['REMOTE_ADDR'],'error','app');
            
            $this->errorCode=self::ERROR_NONE;
        }
        return $this->errorCode==self::ERROR_NONE;
    }
 
    public function getId()
    {
        return $this->_id;
    }
	
    public function getIdGroup()
    {
        return $this->_group;
    }
	 
	 /*
	public function authenticate()
	{
		$users=array(
			// username => password
			'sly'=>'sly',
			//'admin'=>'admin',
		);
		if(!isset($users[$this->username]))
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		else if($users[$this->username]!==$this->password)
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
		else
			$this->errorCode=self::ERROR_NONE;
		return !$this->errorCode;
	}
	*/
}