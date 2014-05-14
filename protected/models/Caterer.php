<?php

/**
 * This is the model class for table "caterer".
 *
 * The followings are the available columns in table 'caterer':
 * @property integer $id
 * @property integer $company_id
 * @property string $name
 * @property string $cuisine
 * @property integer $number_of_courses
 * @property integer $price_per_pax
 * @property integer $min_pax
 * @property string $description
 * @property string $status
 *
 * The followings are the available model relations:
 * @property Company $company
 * @property Wedding[] $weddings
 */
class Caterer extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Caterer the static model class
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
		return 'caterer';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('company_id, name, price_per_pax, min_pax, status', 'required'),
			array('company_id, number_of_courses, price_per_pax, min_pax', 'numerical', 'integerOnly'=>true),
			array('name, cuisine', 'length', 'max'=>80),
			array('status', 'length', 'max'=>8),
			array('description', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, company_id, name, cuisine, number_of_courses, price_per_pax, min_pax, description, status', 'safe', 'on'=>'search'),
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
			'company' => array(self::BELONGS_TO, 'Company', 'company_id'),
			'weddings' => array(self::HAS_MANY, 'Wedding', 'caterer_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'company_id' => 'Company ID',
			'name' => 'Name',
			'cuisine' => 'Cuisine',
			'number_of_courses' => 'Number Of Courses',
			'price_per_pax' => 'Price Per Pax',
			'min_pax' => 'Min Pax',
			'description' => 'Description',
			'status' => 'Status',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search($company_id)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('company_id',$company_id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('cuisine',$this->cuisine,true);
		$criteria->compare('number_of_courses',$this->number_of_courses);
		$criteria->compare('price_per_pax',$this->price_per_pax);
		$criteria->compare('min_pax',$this->min_pax);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('status',$this->status,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}