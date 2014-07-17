<?php

/**
 * This is the model class for table "it_system_employee_request".
 *
 * The followings are the available columns in table 'it_system_employee_request':
 * @property integer $id
 * @property integer $employee_id
 * @property integer $system_id
 * @property string $configurations
 * @property string $type
 * @property string $status
 * @property integer $active
 * @property integer $activated_by
 * @property integer $deactivated_by
 * @property string $activated_timestamp
 * @property string $deactivated_timestamp
 * @property string $notes
 * @property integer $hr_workflow_notice_id
 * @property string $timestamp
 *
 * The followings are the available model relations:
 * @property HrWorkflowChangeNotice $hrWorkflowNotice
 * @property ItSystem $system
 */
class Request extends CActiveRecord
{
	public $show_inactive, $from, $to, $requested, $note, $cfgs;
  public static $FLAG_DAYS = 2;
  
  public function process(){
    $this->configurations = $this->encodeConfigurations();
    return $this;
  }
  
  public function encodeConfigurations(){
    return CJSON::encode($this->formatCfgs());
  }
  
  public function printNotes(){
    if(empty($this->notes)) return;
    $data = '<table class="table table-bordered table-condensed detail-view">';
    foreach ($this->decodeTheNotes() as $key=>$value) {
      $data .= '<tr><th>'.$key.'</th><td><small>'.$value['user'].'</small>: <small>"'.$value['comment'].'"</small></td></tr>';  	
    }
    $data .= '</table>'; 
    return $data; 
  }
  
  public function decodeTheNotes(){
    return CJSON::decode($this->notes);
  }
  
  public static function isMyRequest(){
    return true;
  }
  
  public function printConfiguration(){
    $c = $this->parseConfiguration();
    $data = '<table class="table table-condensed table-bordered">';
    foreach ($c as $key=>$value) {
      $data .= "<tr><th>$key</th><td>$value</td></tr>";    	
    }
    $data .= '</table>';
    return $data;
  }
  
  public function parseConfiguration(){
    if(empty($this->cfgs))
      return CJSON::decode($this->configurations);
    else
    {
      return $this->formatCfgs();  
    }    
  }
  
  private function formatCfgs(){
    $data = array();
    foreach ($this->cfgs as $key=>$value) {
      $data[$value['property']] = $value['value'];    	
    }
    return $data;  
  }
  
  public function beforeSave(){
    if($this->isNewRecord)
      $this->timestamp = new CDbExpression('NOW()');
    $this->encodeNotes();

    switch($this->scenario){
      case 'process':
        $this->status = 'COMPLETE';
        $this->active = '0';
        if($this->type == 'NEW' or $this->type == 'MODIFY'){
          $this->activated_by = Yii::app()->user->getState('id');
          $this->activated_timestamp = new CDbExpression('NOW()'); 
        }
        if($this->type == 'DEACTIVATE'){
          $this->deactivated_by = Yii::app()->user->getState('id');
          $this->deactivated_timestamp = new CDbExpression('NOW()'); 
        }
      break;
      case 'cancel':
        $this->status = 'CANCELLED';
        $this->active = '0';
      break; 
    }
    return parent::beforeSave();
  }
  
  public function afterSave(){
    if($this->status == 'PENDING') $this->notify();
    return parent::afterSave();
  }
  
  private function notify(){
    $admins = User::model()->findAll("role = 'ADMIN'");
    ItSysHelper::queueMail($admins,$this);
  }
  
  private function encodeNotes(){
    if (!empty($this->note)){
      $now = date('Y-m-d H:i:s',time()); 
      $data[$now]['user'] = Yii::app()->user->name;
      $data[$now]['comment'] =  $this->note;
      $notes = $this->decodeNotes();
      $this->notes = CJSON::encode(array_merge($data,$notes)); 
    }else{

    }    
  }
  
  public function decodeNotes(){
    return empty($this->notes) ? array() : CJSON::decode($this->notes); 
  }
  
  public function afterFind(){
    $this->requested = floor((time() - strtotime($this->timestamp)) / (60*60*24));
    return parent::afterFind();
  }
 
  public function getDays(){    
    return $this->requested > 0 ? $this->requested.' days ago' : 'Today';
  }
  
  public function submitRequest(){
    foreach($this->system_id as $sys){
      $request = new self;
      $request->attributes = $this->attributes;
      $request->note = $this->note;
      $request->system_id = $sys;
      //Yii::log('$request: '.print_r($request->attributes,true),'error','app');
      $request->save(false);  
    }
    return true;    
  }
  
  /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Request the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'it_system_employee_request';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()  
	{
		return array(
			array('employee_id, system_id', 'required'),
			array('employee_id, active, activated_by, deactivated_by, hr_workflow_notice_id', 'numerical', 'integerOnly'=>true),
			array('type', 'length', 'max'=>10),
			array('status', 'length', 'max'=>9),
			array('show_inactive, note, notes, cfgs, from, to, activated_timestamp, deactivated_timestamp, timestamp', 'safe'),
			array('id, employee_id, system_id, configurations, type, status, active, activated_by, deactivated_by, activated_timestamp, deactivated_timestamp, notes, hr_workflow_notice_id, timestamp', 'safe', 'on'=>'search'),
      
      //process
      array('cfgs', 'required', 'on'=>'process'),
      array('cfgs', 'validateCfgs', 'on'=>'process'),
      
      //cancel
      array('id', 'validateCancellation', 'on'=>'cancel'),
      
		);
	}
  
  public function validateCancellation(){
    if($this->status != 'PENDING'){
      $this->addError('id','Request is already '.$this->status.' .');
    }
    
  } 
  
  public function validateCfgs(){
    if (empty($this->cfgs)) return;
    foreach ($this->cfgs as $key=>$value) {
      if(empty($value['property']) or empty($value['value']) ){
          $this->addError('cfgs','Some pair-value fields are missing.');
          break;
      }	
    }  
  }

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
      'employee'=>array(self::BELONGS_TO,'Employee','employee_id'),
      'system'=>array(self::BELONGS_TO,'System','system_id'),
      'activatedBy'=>array(self::BELONGS_TO,'User','activated_by'),
      'deactivatedBy'=>array(self::BELONGS_TO,'User','deactivated_by'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'employee_id' => 'Employee',
			'system_id' => 'System',
			'configurations' => 'Configurations',
			'type' => 'Type',
			'status' => 'Status',
			'active' => 'Active Request',
			'activated_by' => 'Processed By',
			'deactivated_by' => 'Deactivated By',
			'activated_timestamp' => 'Activated',
			'deactivated_timestamp' => 'Deactivated',
			'notes' => 'Notes',
			'hr_workflow_notice_id' => 'Hr Workflow Notice',
			'timestamp' => 'Requested',
      'cfgs' => 'Configurations',
      'property' => 'Property / Setting',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search($pagesize=10)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('employee_id',$this->employee_id);
		$criteria->compare('system_id',$this->system_id);
		$criteria->compare('configurations',$this->configurations,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('hr_workflow_notice_id',$this->hr_workflow_notice_id);
    
    if(!empty($this->from) and !empty($this->to)){
      $criteria->addBetweenCondition('timestamp',$this->from, $this->to.' 23:55:00');  
    }elseif(!empty($this->from) and empty($this->to)){
      $criteria->compare('timestamp','>= '.$this->from);
    }elseif(empty($this->from) and !empty($this->to)){
      $criteria->compare('timestamp','<= '.$this->to.' 23:55:00');
    }else{}
    
    if(empty($this->show_inactive)) 
      $criteria->compare('active','1');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
      'sort'=>array(
        'class'=>'CSort',
        'defaultOrder'=>'employee_id asc, timestamp asc'
      ),
      'pagination'=>array(
        'pageSize'=>$pagesize
      ),
		));
	}
}