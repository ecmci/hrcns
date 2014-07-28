<?php

/**
 * This is the model class for table "tar_procedure_checklist".
 *
 * The followings are the available columns in table 'tar_procedure_checklist':
 * @property integer $id
 * @property string $data
 * @property integer $completed_steps
 * @property integer $total_steps
 * @property integer $procedure_checklist_tpl_id
 * @property integer $log_case_id
 *
 * The followings are the available model relations:
 * @property TarProcedureChecklistTpl $procedureChecklistTpl
 * @property TarLog $logCase
 */
class TarProcedureChecklist extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TarProcedureChecklist the static model class
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
		return 'tar_procedure_checklist';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('data, completed_steps, total_steps, procedure_checklist_tpl_id, log_case_id', 'required'),
			array('completed_steps, total_steps, procedure_checklist_tpl_id, log_case_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, data, completed_steps, total_steps, procedure_checklist_tpl_id, log_case_id', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'procedureChecklistTpl' => array(self::BELONGS_TO, 'TarProcedureChecklistTpl', 'procedure_checklist_tpl_id'),
			'logCase' => array(self::BELONGS_TO, 'TarLog', 'log_case_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'data' => 'Data',
			'completed_steps' => 'Completed Steps',
			'total_steps' => 'Total Steps',
			'procedure_checklist_tpl_id' => 'Procedure Checklist Tpl',
			'log_case_id' => 'Log Case',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('data',$this->data,true);
		$criteria->compare('completed_steps',$this->completed_steps);
		$criteria->compare('total_steps',$this->total_steps);
		$criteria->compare('procedure_checklist_tpl_id',$this->procedure_checklist_tpl_id);
		$criteria->compare('log_case_id',$this->log_case_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}