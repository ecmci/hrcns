<?php

/**
 * This is the model class for table "tar_alerts".
 *
 * The followings are the available columns in table 'tar_alerts':
 * @property integer $id
 * @property string $data
 * @property integer $log_case_id
 * @property integer $alerts_tpl_id
 *
 * The followings are the available model relations:
 * @property TarLog $logCase
 * @property TarAlertsTpl $alertsTpl
 */
class TarAlerts extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TarAlerts the static model class
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
		return 'tar_alerts';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('log_case_id, alerts_tpl_id', 'required'),
			array('log_case_id, alerts_tpl_id', 'numerical', 'integerOnly'=>true),
			array('data', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, data, log_case_id, alerts_tpl_id', 'safe', 'on'=>'search'),
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
			'logCase' => array(self::BELONGS_TO, 'TarLog', 'log_case_id'),
			'alertsTpl' => array(self::BELONGS_TO, 'TarAlertsTpl', 'alerts_tpl_id'),
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
			'log_case_id' => 'Log Case',
			'alerts_tpl_id' => 'Alerts Tpl',
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
		$criteria->compare('log_case_id',$this->log_case_id);
		$criteria->compare('alerts_tpl_id',$this->alerts_tpl_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}