<?php

/**
 * This is the model class for table "company".
 *
 * The followings are the available columns in table 'company':
 * @property integer $id
 * @property string $name
 * @property string $category
 * @property string $email_id
 * @property string $address
 * @property integer $pincode
 * @property string $country
 * @property integer $phone
 *
 * The followings are the available model relations:
 * @property Cake[] $cakes
 * @property Caterer[] $caterers
 * @property Decor[] $decors
 * @property Dress[] $dresses
 * @property Music[] $musics
 * @property Photographer[] $photographers
 * @property Venue[] $venues
 */
class Company extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Company the static model class
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
		return 'company';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, category, email_id, authenticated, regno', 'required'),
			array('email_id', 'email'),
			array('pincode, phone', 'numerical', 'integerOnly'=>true),
			array('name, email_id, address, country', 'length', 'max'=>80),
			array('category', 'length', 'max'=>20),
			
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, category, email_id, address, pincode, country, phone', 'safe', 'on'=>'search'),
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
			'cakes' => array(self::HAS_MANY, 'Cake', 'company_id'),
			'caterers' => array(self::HAS_MANY, 'Caterer', 'company_id'),
			'decors' => array(self::HAS_MANY, 'Decor', 'company_id'),
			'dresses' => array(self::HAS_MANY, 'Dress', 'company_id'),
			'musics' => array(self::HAS_MANY, 'Music', 'company_id'),
			'photographers' => array(self::HAS_MANY, 'Photographer', 'company_id'),
			'venues' => array(self::HAS_MANY, 'Venue', 'company_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'regno' => 'Registration Number',
			'category' => 'Category',
			'email_id' => 'Email',
			'address' => 'Address',
			'pincode' => 'Pincode',
			'country' => 'Country',
			'phone' => 'Phone',
			'authenticated' => 'Authenticated',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('category',$this->category,true);
		$criteria->compare('email_id',$this->email_id,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('pincode',$this->pincode);
		$criteria->compare('country',$this->country,true);
		$criteria->compare('phone',$this->phone);
		$criteria->compare('authenticated',$this->authenticated,true);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}