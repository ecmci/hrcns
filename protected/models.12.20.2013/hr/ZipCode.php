<?php

/**
 * This is the model class for table "zip_code".
 *
 * The followings are the available columns in table 'zip_code':
 * @property integer $zip_code
 * @property string $type
 * @property string $primary_city
 * @property string $acceptable_cities
 * @property string $unacceptable_cities
 * @property string $state
 * @property string $county
 * @property string $timezone
 * @property string $area_codes
 * @property string $latitude
 * @property string $longitude
 * @property string $world_region
 * @property string $country
 * @property string $decommissioned
 * @property string $estimated_population
 * @property string $notes
 */
class ZipCode extends CActiveRecord
{
  
  
  /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ZipCode the static model class
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
		return 'zip_code';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('zip_code', 'required'),
			array('zip_code', 'numerical', 'integerOnly'=>true),
			array('type, primary_city, acceptable_cities, unacceptable_cities, state, county, timezone, area_codes, latitude, longitude, world_region, country, decommissioned, estimated_population, notes', 'length', 'max'=>512),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('zip_code, type, primary_city, acceptable_cities, unacceptable_cities, state, county, timezone, area_codes, latitude, longitude, world_region, country, decommissioned, estimated_population, notes', 'safe', 'on'=>'search'),
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
			'zip_code' => 'Zip Code',
			'type' => 'Type',
			'primary_city' => 'Primary City',
			'acceptable_cities' => 'Acceptable Cities',
			'unacceptable_cities' => 'Unacceptable Cities',
			'state' => 'State',
			'county' => 'County',
			'timezone' => 'Timezone',
			'area_codes' => 'Area Codes',
			'latitude' => 'Latitude',
			'longitude' => 'Longitude',
			'world_region' => 'World Region',
			'country' => 'Country',
			'decommissioned' => 'Decommissioned',
			'estimated_population' => 'Estimated Population',
			'notes' => 'Notes',
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

		$criteria->compare('zip_code',$this->zip_code);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('primary_city',$this->primary_city,true);
		$criteria->compare('acceptable_cities',$this->acceptable_cities,true);
		$criteria->compare('unacceptable_cities',$this->unacceptable_cities,true);
		$criteria->compare('state',$this->state,true);
		$criteria->compare('county',$this->county,true);
		$criteria->compare('timezone',$this->timezone,true);
		$criteria->compare('area_codes',$this->area_codes,true);
		$criteria->compare('latitude',$this->latitude,true);
		$criteria->compare('longitude',$this->longitude,true);
		$criteria->compare('world_region',$this->world_region,true);
		$criteria->compare('country',$this->country,true);
		$criteria->compare('decommissioned',$this->decommissioned,true);
		$criteria->compare('estimated_population',$this->estimated_population,true);
		$criteria->compare('notes',$this->notes,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}