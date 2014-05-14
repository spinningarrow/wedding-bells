<?php

/**
 * This is the model class for table "dress".
 *
 * The followings are the available columns in table 'dress':
 * @property integer $id
 * @property integer $company_id
 * @property string $name
 * @property string $category
 * @property integer $price
 * @property string $description
 * @property string $status
 *
 * The followings are the available model relations:
 * @property Company $company
 * @property Wedding[] $weddings
 * @property Wedding[] $weddings1
 * @property Wedding[] $weddings2
 * @property Wedding[] $weddings3
 */
class Dress extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Dress the static model class
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
		return 'dress';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('company_id, name, category, price', 'required'),
			array('company_id, price', 'numerical', 'integerOnly'=>true),
			array('name, category', 'length', 'max'=>80),
			array('status', 'length', 'max'=>8),
			array('description', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, company_id, name, category, price, description, status', 'safe', 'on'=>'search'),
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
			'weddings' => array(self::HAS_MANY, 'Wedding', 'bridesmaid_id'),
			'weddings1' => array(self::HAS_MANY, 'Wedding', 'groomsmen_id'),
			'weddings2' => array(self::HAS_MANY, 'Wedding', 'bride_id'),
			'weddings3' => array(self::HAS_MANY, 'Wedding', 'groom_id'),
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
			'price' => 'Price',
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
		$criteria->compare('price',$this->price);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('status',$this->status,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}