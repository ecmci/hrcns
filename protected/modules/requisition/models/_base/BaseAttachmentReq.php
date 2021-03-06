<?php

/**
 * This is the model base class for the table "attachment_req".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "AttachmentReq".
 *
 * Columns in table "attachment_req" available as properties of the model,
 * followed by relations of table "attachment_req" available as properties of the model.
 *
 * @property integer $idATTACHMENT_REQ
 * @property integer $REQUISITION_idREQUISITION
 * @property string $filename
 *
 * @property Requisition $rEQUISITIONIdREQUISITION
 */
abstract class BaseAttachmentReq extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'attachment_req';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'AttachmentReq|AttachmentReqs', $n);
	}

	public static function representingColumn() {
		return 'filename';
	}

	public function rules() {
		return array(
			array('REQUISITION_idREQUISITION, filename', 'required'),
			array('REQUISITION_idREQUISITION', 'numerical', 'integerOnly'=>true),
			array('filename', 'length', 'max'=>500),
			array('idATTACHMENT_REQ, REQUISITION_idREQUISITION, filename', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'rEQUISITIONIdREQUISITION' => array(self::BELONGS_TO, 'Requisition', 'REQUISITION_idREQUISITION'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'idATTACHMENT_REQ' => Yii::t('app', 'Id Attachment Req'),
			'REQUISITION_idREQUISITION' => null,
			'filename' => Yii::t('app', 'Filename'),
			'rEQUISITIONIdREQUISITION' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('idATTACHMENT_REQ', $this->idATTACHMENT_REQ);
		$criteria->compare('REQUISITION_idREQUISITION', $this->REQUISITION_idREQUISITION);
		$criteria->compare('filename', $this->filename, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}