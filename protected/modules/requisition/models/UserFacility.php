<?php



class UserFacility extends BaseUserFacility
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}