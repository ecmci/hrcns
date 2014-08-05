<?php
class App extends CHtml{
	public static function enumItem($model,$attribute){
		$attr=$attribute;
		self::resolveName($model,$attr);
		preg_match('/\((.*)\)/',$model->tableSchema->columns[$attr]->dbType,$matches);
		foreach(explode(',', $matches[1]) as $value) {
			$value=str_replace("'",null,$value);
			$values[$value]=Helper::printEnumValue(Yii::t('enumItem',$value));
		}
		return $values;  
	}
	
	public static function computeInDays($timestamp){
		$t = strtotime($timestamp);
    if(!$t) return '';
    $d = 0;
        $base_timestamp = abs(time() - strtotime($timestamp));
		if($base_timestamp >= 86400){ //days
			$d = floor($base_timestamp / 86400).' day(s) ago';
		}elseif($base_timestamp >= 3600){
			$d = floor($base_timestamp / 3600).' hour(s) ago';  
		}elseif($base_timestamp >= 60){
			$d = floor($base_timestamp / 60).' minute(s) ago';  
		}else{
			$d = $base_timestamp.' seconds ago';  
		}
		return $d; 
	}
    
    public static function printDatetime($datetime){
		$t = strtotime($datetime);
		return ($t) ? date('m/d/Y h:i A',$t) : '-'; 
	} 
	
	public static function printDate($date){
		$t = strtotime($date);		
		return ($t) ? date('m/d/Y',$t) : '-';
	} 
	
	public static function getUploadDir(){
		return Yii::getPathOfAlias('webroot').'/uploads/';
	} 
	
	public static function renderDatePickers(){
		Helper::includeJui();
		Yii::app()->clientScript->registerScript('datepickers',"
			$('.datepicker').datepicker({
			'dateFormat' : 'yy-mm-dd',
			 'changeMonth': true,
			 'changeYear': true,
             
			});			
		",CClientScript::POS_READY);
	}
	
	public static function printEnum($value=''){
		return ucwords(strtolower(str_replace('_',' ',$value)));
	}
}
?>
