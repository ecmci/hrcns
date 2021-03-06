<?php

/**
 * This is the model class for table "hr_workflow_notice_type_attachment_required".
 *
 * The followings are the available columns in table 'hr_workflow_notice_type_attachment_required':
 * @property string $notice_type
 * @property string $document
 */
class HrDocuments extends CActiveRecord
{

  
  /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Documents the static model class
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
		return 'hr_workflow_notice_type_attachment_required';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('notice_type, document', 'required'),
			array('notice_type', 'length', 'max'=>128),
			array('document', 'length', 'max'=>256),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('notice_type, notice_sub_type, document', 'safe'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'notice_type' => 'When Notice Type is...',
			'document' => 'Required Document',
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

		$criteria->compare('notice_type',$this->notice_type,true);
		$criteria->compare('document',$this->document,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}