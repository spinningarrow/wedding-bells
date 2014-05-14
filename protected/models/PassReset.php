<?php

/**
 * This is the model class for table "pass_reset".
 *
 * The followings are the available columns in table 'pass_reset':
 * @property integer $user_id
 * @property string $confirm_code
 * @property string $expiry
 *
 * The followings are the available model relations:
 * @property User $user
 */
class PassReset extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PassReset the static model class
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
		return 'pass_reset';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, confirm_code, expiry', 'required'),
			array('user_id', 'numerical', 'integerOnly'=>true),
			array('confirm_code', 'length', 'max'=>256),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('user_id, confirm_code, expiry', 'safe', 'on'=>'search'),
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
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'user_id' => 'User',
			'confirm_code' => 'Confirm Code',
			'expiry' => 'Expiry',
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

		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('confirm_code',$this->confirm_code,true);
		$criteria->compare('expiry',$this->expiry,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}