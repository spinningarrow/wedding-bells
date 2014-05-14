<?php

/**
 * This is the model class for table "venue".
 *
 * The followings are the available columns in table 'venue':
 * @property integer $id
 * @property integer $company_id
 * @property string $name
 * @property string $category
 * @property integer $capacity
 * @property integer $price
 * @property string $description
 * @property string $status
 *
 * The followings are the available model relations:
 * @property Company $company
 * @property Wedding[] $weddings
 */
class Venue extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Venue the static model class
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
		return 'venue';
	}

	/** 
	 * Extracts the address from the venue description
	 * and returns both, the description and the address
	 * @param string $description the value of the description field of a Venue
	 * @return array associative array containing the 'description' and 'address' if found, otherwise NULL
	 */
	public static function splitDescription($description) {

		// Normalize white space in the description
		$description = preg_replace("/[\\s]+/", " ", $description);

		// Get the part of description before the address (# denotes the end of the description)
		$address_regex = "/(.+.)#[\\s]?address[:]?[\\s]?(.+?)[\\s]*$/i";
		preg_match($address_regex, $description, $matches); // [1] = description; [2] = address

		// Return values as associative array
		return (isset($matches[0])) ? array(
			'description' => $matches[1],
			'address' => $matches[2]
		) : NULL;
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('company_id, name, category, capacity, price, status', 'required'),
			array('price', 'numerical', 'integerOnly'=>true,'min'=>1,'tooSmall'=>'Price has to be positive'),			
			array('capacity', 'numerical', 'integerOnly'=>true,'min'=>10,'max'=>1000),
			array('name, category', 'length', 'max'=>80),
			array('status', 'length', 'max'=>8),
			array('description', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, company_id, name, category, capacity, price, description, status', 'safe', 'on'=>'search'),
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
			'weddings' => array(self::HAS_MANY, 'Wedding', 'venue_id'),
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
			'category' => 'Category',
			'capacity' => 'Capacity',
			'price' => 'Price (in SGD)',
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
		$criteria->compare('category',$this->category,true);
		$criteria->compare('capacity',$this->capacity);
		$criteria->compare('price',$this->price);
		$criteria->compare('status',$this->status,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}