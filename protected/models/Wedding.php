<?php

/**
 * This is the model class for table "wedding".
 *
 * The followings are the available columns in table 'wedding':
 * @property integer $wedding_id
 * @property string $type
 * @property integer $customer_id
 * @property string $name
 * @property string $date
 * @property integer $number_guests
 * @property integer $number_groomsmen
 * @property integer $number_bridesmaid
 * @property integer $venue_id
 * @property integer $caterer_id
 * @property integer $photographer_id
 * @property integer $music_id
 * @property integer $decor_id
 * @property integer $invitation_id
 * @property integer $cake_id
 * @property integer $bride_id
 * @property integer $groom_id
 * @property integer $bridesmaid_id
 * @property integer $groomsmen_id
 * @property string $status
 * @property integer $budget
 * @property integer $venue_priority
 * @property integer $caterer_priority
 * @property integer $photographer_priority
 * @property integer $music_priority
 * @property integer $decor_priority
 * @property integer $dress_priority
 * @property integer $invitation_priority
 * @property integer $cake_priority
 *
 * The followings are the available model relations:
 * @property Caterer $caterer
 * @property Photographer $photographer
 * @property Music $music
 * @property Decor $decor
 * @property Cake $cake
 * @property Dress $bride
 * @property Dress $groom
 * @property Dress $bridesmaid
 * @property Dress $groomsmen
 * @property Customer $customer
 * @property Venue $venue
 */
class Wedding extends CActiveRecord
{

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Wedding the static model class
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
		return 'wedding';
	}

	////////////// ADD DOCUMENTATION
	public static function dressType($product_type, $name = false, $generic = false) {
		if (in_array($product_type, array("bride", "groom", "bridesmaid", "groomsmen"))) {
			if ($name && !$generic) {
				return "dress: " . $product_type;
			}
			if ($generic) {
				return 'dress';
			}
			return $product_type; //. "_dress";
		}
		return $product_type;
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(

 			// + required when adding a new wedding
			array(
				'name, date, number_guests, type', 
				'required', 
				'on' => 'add'),

			// + required for the priority selection page
			array(
				'budget', 
				'required', 
				'on' => 'prioritySelection'), 

			//array('customer_id, name, date, number_guests, number_groomsmen, number_bridesmaid, status, budget', 'required'),
			array('customer_id, number_guests, number_groomsmen, number_bridesmaid, venue_id, caterer_id, photographer_id, music_id, decor_id, invitation_id, cake_id, bride_id, groom_id, bridesmaid_id, groomsmen_id, budget, venue_priority, caterer_priority, photographer_priority, music_priority, decor_priority, dress_priority, invitation_priority, cake_priority', 'numerical', 'integerOnly'=>true),

			array('name', 'length', 'max'=>80),
			array('status', 'length', 'max'=>9),
			array('budget', 'numerical', 'min' => 1000, 'max'=>100000, 'tooBig'=>'The budget cannot be greater than 100000','tooSmall'=>'The budget cannot be less than 1000', 'on' => 'prioritySelection'),
			array('number_groomsmen, number_bridesmaid', 'numerical', 'min' => 0, 'max'=>10, 'tooBig'=>'Maximum is 10','tooSmall'=>'Minimum is 0', 'on' => 'prioritySelection'),

			array('number_guests', 'numerical', 'min' => 25, 'max' => 700,'tooSmall'=>'The number of guests are too less.','tooBig'=>'The number of guests are too many.', 'on' => 'add'),
			
			// Check dates
			array('date', 'date', 'format' => 'yyyy/M/d', 'on' => 'add'), // check date is in proper format
			array('date', 'validateDateOnAdd', 'on' => 'add', 'skipOnError' => true), // custom validator, skip if previous date validation fails
			
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('wedding_id, customer_id, name, date, number_guests, number_groomsmen, number_bridesmaid, venue_id, caterer_id, photographer_id, music_id, decor_id, invitation_id, cake_id, bride_id, groom_id, bridesmaid_id, groomsmen_id, status, budget, venue_priority, caterer_priority, photographer_priority, music_priority, decor_priority, dress_priority, invitation_priority, cake_priority', 'safe', 'on'=>'search'),
			);
	}

	// Custom validator for dates on the add wedding page
	public function validateDateOnAdd($attribute, $params) {
		
		$value = $this->$attribute; // took centuries to figure out how to get this

		$difference = (strtotime($value) - time()) / (60 * 60 * 24); // number of days between today and the wedding

		if ($difference < 0) {
			$this->addError($attribute, 'You unfortunately cannot add a wedding that is in the past.');
		}

		elseif ($difference < 14) {
			$this->addError($attribute, 'You cannot add a wedding that is less than two weeks away.');
		}

		elseif ($difference > 365) {
			$this->addError($attribute, 'You cannot add a wedding that is more than a year away.');
		}
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'caterer' => array(self::BELONGS_TO, 'Caterer', 'caterer_id'),
			'photographer' => array(self::BELONGS_TO, 'Photographer', 'photographer_id'),
			'music' => array(self::BELONGS_TO, 'Music', 'music_id'),
			'decor' => array(self::BELONGS_TO, 'Decor', 'decor_id'),
			'cake' => array(self::BELONGS_TO, 'Cake', 'cake_id'),
			'bride' => array(self::BELONGS_TO, 'Dress', 'bride_id'),
			'groom' => array(self::BELONGS_TO, 'Dress', 'groom_id'),
			'bridesmaid' => array(self::BELONGS_TO, 'Dress', 'bridesmaid_id'),
			'groomsmen' => array(self::BELONGS_TO, 'Dress', 'groomsmen_id'),
			'customer' => array(self::BELONGS_TO, 'Customer', 'customer_id'),
			'venue' => array(self::BELONGS_TO, 'Venue', 'venue_id'),
			);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'wedding_id' => 'Wedding',
			'type' => 'Type',
			'customer_id' => 'Customer',
			'name' => 'Name',
			'date' => 'Date',
			'number_guests' => 'Number of guests',
			'number_groomsmen' => 'Number of groomsmen',
			'number_bridesmaid' => 'Number of bridesmaids',
			'venue_id' => 'Venue',
			'caterer_id' => 'Caterer',
			'photographer_id' => 'Photographer',
			'music_id' => 'Music',
			'decor_id' => 'Decor',
			'invitation_id' => 'Invitation',
			'cake_id' => 'Cake',
			'bride_id' => 'Bride',
			'groom_id' => 'Groom',
			'bridesmaid_id' => 'Bridesmaid',
			'groomsmen_id' => 'Groomsmen',
			'status' => 'Status',
			'budget' => 'Budget',
			'venue_priority' => 'Venue Priority',
			'caterer_priority' => 'Caterer Priority',
			'photographer_priority' => 'Photographer Priority',
			'music_priority' => 'Music Priority',
			'decor_priority' => 'Decor Priority',
			'dress_priority' => 'Dress Priority',
			'invitation_priority' => 'Invitation Priority',
			'cake_priority' => 'Cake Priority',
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

		$criteria->compare('wedding_id',$this->wedding_id);
		$criteria->compare('type',$this->type);
		$criteria->compare('customer_id',$this->customer_id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('date',$this->date,true);
		$criteria->compare('number_guests',$this->number_guests);
		$criteria->compare('number_groomsmen',$this->number_groomsmen);
		$criteria->compare('number_bridesmaid',$this->number_bridesmaid);
		$criteria->compare('venue_id',$this->venue_id);
		$criteria->compare('caterer_id',$this->caterer_id);
		$criteria->compare('photographer_id',$this->photographer_id);
		$criteria->compare('music_id',$this->music_id);
		$criteria->compare('decor_id',$this->decor_id);
		$criteria->compare('invitation_id',$this->invitation_id);
		$criteria->compare('cake_id',$this->cake_id);
		$criteria->compare('bride_id',$this->bride_id);
		$criteria->compare('groom_id',$this->groom_id);
		$criteria->compare('bridesmaid_id',$this->bridesmaid_id);
		$criteria->compare('groomsmen_id',$this->groomsmen_id);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('budget',$this->budget);
		$criteria->compare('venue_priority',$this->venue_priority);
		$criteria->compare('caterer_priority',$this->caterer_priority);
		$criteria->compare('photographer_priority',$this->photographer_priority);
		$criteria->compare('music_priority',$this->music_priority);
		$criteria->compare('decor_priority',$this->decor_priority);
		$criteria->compare('dress_priority',$this->dress_priority);
		$criteria->compare('invitation_priority',$this->invitation_priority);
		$criteria->compare('cake_priority',$this->cake_priority);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			));
	}

	// ------------------------------------------
	// + Budget allocation algorithm
	// ------------------------------------------
	function allocateBudget() {

		$connection = Yii::app()->db;
		
		$budget = $this->budget;
		$priorities = array(
			"Venue" => $this->venue_priority === NULL ? -1 : $this->venue_priority, 
			"Caterer" => $this->caterer_priority === NULL ? -1 : $this->caterer_priority, 
			"Photographer" => $this->photographer_priority === NULL ? -1 : $this->photographer_priority, 
			"Music" => $this->music_priority === NULL ? -1 : $this->music_priority, 
			"Decor" => $this->decor_priority === NULL ? -1 : $this->decor_priority, 
			"BrideDress" => $this->dress_priority === NULL ? -1 : $this->dress_priority,
			"GroomDress" => $this->dress_priority === NULL ? -1 : $this->dress_priority,
			"MaidDress" => $this->dress_priority === NULL ? -1 : $this->dress_priority,
			"MenDress" => $this->dress_priority === NULL ? -1 : $this->dress_priority,
			"Invitations" => $this->invitation_priority === NULL ? -1 : $this->invitation_priority, 
			"Cakes" => $this->cake_priority === NULL ? -1 : $this->cake_priority
			);
		
		$Database["Caterer"] = CHtml::listData(Caterer::model()->findAllBySQL('select * from caterer where status="enabled" and '.$this->number_guests.'>=min_pax order by price_per_pax'),'id','price_per_pax');
		$Database["Venue"] = CHtml::listData(Venue::model()->findAllBySQL('select * from venue where status="enabled" and id not in (select venue_id from wedding where status = "confirmed" and date = \''.$this->date.'\' and venue_id IS NOT NULL) and capacity>='.$this->number_guests.' order by price'),'id','price');
		$Database["Photographer"] = CHtml::listData(Photographer::model()->findAllBySQL('select * from photographer where status="enabled" order by price'),'id','price');
		$Database["Music"] = CHtml::listData(Music::model()->findAllBySQL('select * from music where status="enabled" order by price'),'id','price');
		$Database["Decor"] = CHtml::listData(Decor::model()->findAllBySQL('select * from decor where status="enabled" order by price'),'id','price');
		$Database["BrideDress"] = CHtml::listData(Dress::model()->findAllBySQL('select * from dress where status="enabled" and category="bride" order by price'),'id','price');
		$Database["GroomDress"] = CHtml::listData(Dress::model()->findAllBySQL('select * from dress where status="enabled" and category="groom" order by price'),'id','price');
		$Database["MaidDress"] = CHtml::listData(Dress::model()->findAllBySQL('select * from dress where status="enabled" and category="bridesmaid" order by price'),'id','price');
		$Database["MenDress"] = CHtml::listData(Dress::model()->findAllBySQL('select * from dress where status="enabled" and category="groomsman" order by price'),'id','price');
		$Database["Invitations"] = array(200, 300, 400, 500, 600, 700, 800, 900, 1000);
		$Database["Cakes"] = CHtml::listData(Cake::model()->findAllBySQL('select * from cake where status="enabled" order by price'),'id','price');
		
$average[0] = array(
	"Venue" => $connection->createCommand('select (min(price)+avg(price))/2 from Venue where status="enabled" and id not in (select venue_id from wedding where status = "confirmed" and date = \''.$this->date.'\' and venue_id IS NOT NULL) and capacity>='.$this->number_guests)->queryScalar(), 
	"Caterer" => $connection->createCommand('select (min(price_per_pax)+avg(price_per_pax))/2 from caterer where status="enabled" and '.$this->number_guests.'>=min_pax')->queryScalar(), 
	"Photographer" => $connection->createCommand('select (min(price)+avg(price))/2 from Photographer where status="enabled"')->queryScalar(), 
	"Music" => $connection->createCommand('select (min(price)+avg(price))/2 from music where status="enabled"')->queryScalar(), 
	"Decor" => $connection->createCommand('select (min(price)+avg(price))/2 from decor where status="enabled"')->queryScalar(), 
	"BrideDress" => $connection->createCommand('select (min(price)+avg(price))/2 from dress where category="bride" and status="enabled"')->queryScalar(),
	"GroomDress" => $connection->createCommand('select (min(price)+avg(price))/2 from dress where category="groom" and status="enabled"')->queryScalar(),
	"MaidDress" => $connection->createCommand('select (min(price)+avg(price))/2 from dress where category="bridesmaid" and status="enabled"')->queryScalar(),
	"MenDress" => $connection->createCommand('select (min(price)+avg(price))/2 from dress where category="groomsman" and status="enabled"')->queryScalar(),
	"Invitations" => 400, 
	"Cakes" => $connection->createCommand('select (min(price)+avg(price))/2 from cake where status="enabled"')->queryScalar()
	);

$average[1] = array(
	"Venue" => $connection->createCommand('select avg(price) from Venue where status="enabled" and id not in (select venue_id from wedding where status = "confirmed" and date = \''.$this->date.'\' and venue_id IS NOT NULL) and capacity>='.$this->number_guests)->queryScalar(), 
	"Caterer" => $connection->createCommand('select avg(price_per_pax) from caterer where status="enabled" and '.$this->number_guests.'>=min_pax')->queryScalar(), 
	"Photographer" => $connection->createCommand('select avg(price) from Photographer where status="enabled"')->queryScalar(), 
	"Music" => $connection->createCommand('select avg(price) from music where status="enabled"')->queryScalar(), 
	"Decor" => $connection->createCommand('select avg(price) from decor where status="enabled"')->queryScalar(), 
	"BrideDress" => $connection->createCommand('select avg(price) from dress where category="bride" and status="enabled"')->queryScalar(),
	"GroomDress" => $connection->createCommand('select avg(price) from dress where category="groom" and status="enabled"')->queryScalar(),
	"MaidDress" => $connection->createCommand('select avg(price) from dress where category="bridesmaid" and status="enabled"')->queryScalar(),
	"MenDress" => $connection->createCommand('select avg(price) from dress where category="groomsman" and status="enabled"')->queryScalar(),
	"Invitations" => 600, 
	"Cakes" => $connection->createCommand('select avg(price) from cake where status="enabled"')->queryScalar()
	);

$average[2] = array(
	"Venue" => $connection->createCommand('select (max(price)+avg(price))/2 from venue where status="enabled" and id not in (select venue_id from wedding where status = "confirmed" and date = \''.$this->date.'\' and venue_id IS NOT NULL) and capacity>='.$this->number_guests)->queryScalar(), 
	"Caterer" => $connection->createCommand('select (max(price_per_pax)+avg(price_per_pax))/2 from caterer where status="enabled" and '.$this->number_guests.'>=min_pax')->queryScalar(), 
	"Photographer" => $connection->createCommand('select (max(price)+avg(price))/2 from Photographer where status="enabled"')->queryScalar(), 
	"Music" => $connection->createCommand('select (max(price)+avg(price))/2 from music where status="enabled"')->queryScalar(), 
	"Decor" => $connection->createCommand('select (max(price)+avg(price))/2 from decor where status="enabled"')->queryScalar(), 
	"BrideDress" => $connection->createCommand('select (max(price)+avg(price))/2 from dress where category="bride" and status="enabled"')->queryScalar(),
	"GroomDress" => $connection->createCommand('select (max(price)+avg(price))/2 from dress where category="groom" and status="enabled"')->queryScalar(),
	"MaidDress" => $connection->createCommand('select (max(price)+avg(price))/2 from dress where category="bridesmaid" and status="enabled"')->queryScalar(),
	"MenDress" => $connection->createCommand('select (max(price)+avg(price))/2 from dress where category="groomsman" and status="enabled"')->queryScalar(),
	"Invitations" => 800, 
	"Cakes" => $connection->createCommand('select (max(price)+avg(price))/2 from cake where status="enabled"')->queryScalar()
	);

$min = array(
	"Venue" => $connection->createCommand('select min(price) from venue where status="enabled" and id not in (select venue_id from wedding where status = "confirmed" and date = \''.$this->date.'\' and venue_id IS NOT NULL) and capacity>='.$this->number_guests)->queryScalar(), 
	"Caterer" => $connection->createCommand('select min(price_per_pax) from caterer where status="enabled" and '.$this->number_guests.'>=min_pax')->queryScalar(), 
	"Photographer" => $connection->createCommand('select min(price) from Photographer where status="enabled"')->queryScalar(), 
	"Music" => $connection->createCommand('select min(price) from music where status="enabled"')->queryScalar(), 
	"Decor" => $connection->createCommand('select min(price) from decor where status="enabled"')->queryScalar(), 
	"BrideDress" => $connection->createCommand('select min(price) from dress where category="bride" and status="enabled"')->queryScalar(),
	"GroomDress" => $connection->createCommand('select min(price) from dress where category="groom" and status="enabled"')->queryScalar(),
	"MaidDress" => $connection->createCommand('select min(price) from dress where category="bridesmaid" and status="enabled"')->queryScalar(),
	"MenDress" => $connection->createCommand('select min(price) from dress where category="groomsman" and status="enabled"')->queryScalar(),
	"Invitations" => 200, 
	"Cakes" => $connection->createCommand('select min(price) from cake where status="enabled"')->queryScalar()
	);

$max = array(
	"Venue" => $connection->createCommand('select max(price) from venue where status="enabled" and id not in (select venue_id from wedding where status = "confirmed" and date = \''.$this->date.'\' and venue_id IS NOT NULL) and capacity>='.$this->number_guests)->queryScalar(), 
	"Caterer" => $connection->createCommand('select max(price_per_pax) from caterer where status="enabled" and '.$this->number_guests.'>=min_pax')->queryScalar(), 
	"Photographer" => $connection->createCommand('select max(price) from Photographer where status="enabled"')->queryScalar(), 
	"Music" => $connection->createCommand('select max(price) from music where status="enabled"')->queryScalar(), 
	"Decor" => $connection->createCommand('select max(price) from decor where status="enabled"')->queryScalar(), 
	"BrideDress" => $connection->createCommand('select max(price) from dress where category="bride" and status="enabled"')->queryScalar(),
	"GroomDress" => $connection->createCommand('select max(price) from dress where category="groom" and status="enabled"')->queryScalar(),
	"MaidDress" => $connection->createCommand('select max(price) from dress where category="bridesmaid" and status="enabled"')->queryScalar(),
	"MenDress" => $connection->createCommand('select max(price) from dress where category="groomsman" and status="enabled"')->queryScalar(),
	"Invitations" => 1000, 
	"Cakes" => $connection->createCommand('select max(price) from cake where status="enabled"')->queryScalar()
	);

$number = array(
	"Venue" => 1, 
	"Caterer"=>$this->number_guests, 
	"Photographer"=>1, 
	"Music"=>1, 
	"Decor"=>1, 
	"BrideDress"=>1, 
	"GroomDress"=>1, 
	"MaidDress" =>$this->number_bridesmaid, 
	"MenDress"=>$this->number_groomsmen, 
	"Invitations" =>$this->number_guests, 
	"Cakes" => 1,
	);

$exists = array(
	"Venue" => $this->venue_priority === NULL ? 0 : 1, 
	"Caterer"=>$this->caterer_priority === NULL ? 0 : 1, 
	"Photographer"=>$this->photographer_priority === NULL ? 0 : 1, 
	"Music"=>$this->music_priority === NULL ? 0 : 1, 
	"Decor"=>$this->decor_priority === NULL ? 0 : 1, 
	"BrideDress"=>$this->dress_priority === NULL ? 0 : 1, 
	"GroomDress"=>$this->dress_priority === NULL ? 0 : 1, 
	"MaidDress" =>($this->dress_priority === NULL || $this->number_bridesmaid==0) ? 0 : 1, 
	"MenDress"=>($this->dress_priority === NULL || $this->number_groomsmen==0) ? 0 : 1,
	"Invitations" => 0, 
	"Cakes" => $this->cake_priority === NULL ? 0 : 1,
	);
// if($this->number_bridesmaid===0){
// 	$exists["MaidDress"] = 0;
// }
// if($this->number_groomsmen===0){
// 	$exists["GroomDress"] = 0;
// }
$Finalbudget = array(
	"Venue" => 0, 
	"Caterer"=>0, 
	"Photographer"=>0, 
	"Music"=>0, 
	"Decor"=>0, 
	"BrideDress"=>0, 
	"GroomDress"=>0, 
	"MaidDress" =>0, 
	"MenDress"=>0, 
	"Invitations" => 0, 
	"Cakes" => 0,
	);

$Avgbudget = array(
	"Venue" => 0, 
	"Caterer"=>0, 
	"Photographer"=>0, 
	"Music"=>0, 
	"Decor"=>0, 
	"BrideDress"=>0, 
	"GroomDress"=>0, 
	"MaidDress" =>0, 
	"MenDress"=>0, 
	"Invitations" => 0, 
	"Cakes" => 0,
	);

		//start of code
$this->reduction($priorities, $average, $min, $max, $number, $exists, $budget, $Finalbudget, $Avgbudget);
		// echo "<h1> ITERATION 1</h1>";
if($budget < 0) {
			// echo "<br>Budget too low";
}
		//after first check and execution
else {
		foreach($number as $k=>$ak){	
			if($exists[$k]!==0){
				foreach($Database[$k] as $value) {
						// echo $value."<br>";
					if($value === $Avgbudget[$k]) {
						$Finalbudget[$k] = $value;
						$budget -= $value * $number[$k];
						$exists[$k] = 0;
						$this->reduction($priorities, $average, $min, $max, $number, $exists, $budget, $Finalbudget, $Avgbudget);
							// echo "<h1> ITERATION ".$k."</h1>";
						break;
					}

					if($value>$Avgbudget[$k]) {

						$Finalbudget[$k] = $prev;
						$budget -= $prev*$number[$k];
						$exists[$k] = 0;
						$this->reduction($priorities, $average, $min, $max, $number, $exists, $budget, $Finalbudget, $Avgbudget);
							// echo "<h1> ITERATION ".$k."</h1>";
						break;
					}

					$prev = $value;
				}
			}

			if($budget < 0) {
					// echo "<br>Budget too low";
				break;
			}
		}	
}

$fbudget = 0;
		// echo "<h3>";
foreach($Finalbudget as $k => $ak) {
			// echo $k." = ".$ak."<br>";
	$fbudget += $ak*$number[$k];
}
		// echo "</h3>";
		// echo "<h1> Total money spent : ".$fbudget."</h1>";
		// echo "<h1> Money left : ".$budget."</h1>";
if($Finalbudget['Venue'] !== 0) {
	$this->venue_id = $connection->createCommand('select id from venue where status="enabled" and id not in (select venue_id from wedding where status = "confirmed" and date = \''.$this->date.'\' and venue_id IS NOT NULL) and '.$this->number_guests.'<= capacity and price = '.$Finalbudget['Venue'])->queryScalar();
}

if($Finalbudget['Caterer'] !== 0) {
	$this->caterer_id = $connection->createCommand('select id from caterer where status="enabled" and min_pax<='.$this->number_guests.' and price_per_pax = '.$Finalbudget['Caterer'])->queryScalar();
}

if($Finalbudget['Photographer'] !== 0) {
	$this->photographer_id = $connection->createCommand('select id from Photographer where status="enabled" and price = '.$Finalbudget['Photographer'])->queryScalar();
}

if($Finalbudget['Music'] !== 0) {
	$this->music_id = $connection->createCommand('select id from music where status="enabled" and price = '.$Finalbudget['Music'])->queryScalar();
}

if($Finalbudget['Decor'] !== 0) {
	$this->decor_id = $connection->createCommand('select id from decor where status="enabled" and price = '.$Finalbudget['Decor'])->queryScalar();
}

if($Finalbudget['BrideDress'] !== 0) {
	$this->bride_id = $connection->createCommand('select id from dress where status="enabled" and price = '.$Finalbudget['BrideDress'].' and category = "bride"')->queryScalar();
}

if($Finalbudget['GroomDress'] !== 0) {
	$this->groom_id = $connection->createCommand('select id from dress where status="enabled" and price = '.$Finalbudget['GroomDress'].' and category = "groom"')->queryScalar();
}

if($Finalbudget['MaidDress'] !== 0) {
	$this->bridesmaid_id = $connection->createCommand('select id from dress where status="enabled" and price = '.$Finalbudget['MaidDress'].' and category = "bridesmaid"')->queryScalar();
}

if($Finalbudget['MenDress'] !== 0) {
	$this->groomsmen_id = $connection->createCommand('select id from dress where status="enabled" and price = '.$Finalbudget['MenDress'].' and category = "groomsman"')->queryScalar();
}

if($Finalbudget['Cakes'] !== 0) {
	$this->cake_id = $connection->createCommand('select id from cake where status="enabled" and price = '.$Finalbudget['Cakes'])->queryScalar();
}
	
} // end allocateBudget

//function to reduce the budget problem in every iteration
function reduction($priorities,$average,$min,$max,$number,&$exists,&$budget,&$Finalbudget,&$Avgbudget){
	while(1){
		$sum=0;
		$change = false;
		foreach ($number as $k=>$ak){
			if($exists[$k]!==0){	
				$sum+=($average[$priorities[$k]][$k]*$ak);
				// echo "Average of ".$k." : ".$average[$priorities[$k]][$k]."<br>";
				// echo "Sum upto ".$k." : ".$sum.'<br>';
			}
		}
		// echo "<br> Sum = ".$sum."<br>";
		if($sum!==0){
			foreach($number as $k=>$ak){	
				if($exists[$k]!==0){		
					$percentage[$k]=($average[$priorities[$k]][$k]*$ak*100)/$sum;
					// echo $percentage[$k]." ".$average[$priorities[$k]][$k]*$ak.'<br>';
					$Avgbudget[$k]=($percentage[$k]*$budget)/(100*$number[$k]);
				}
				else {
					$Avgbudget[$k]=0;	
				}
				// echo $k." ".$Avgbudget[$k]."<br>";
			}
		}
		foreach($number as $k=>$ak){
			if($exists[$k]!==0){
				if($Avgbudget[$k]<=$min[$k]){
					// echo "Entered less than minimum loop of ".$k. " Avg Budget  : ".$Avgbudget[$k]." Min : ".$min[$k]."<br>";
					$change = true;
					$Finalbudget[$k]=$min[$k];
					$budget-=$min[$k]*$number[$k];
					$exists[$k]=0;
				}
				if($Avgbudget[$k]>=$max[$k]){
					// echo "Entered greater than maximum loop of ".$k. " Avg Budget  : ".$Avgbudget[$k]." Max : ".$max[$k]."<br>";
					$change = true;
					$Finalbudget[$k]=$max[$k];
					$budget-=$max[$k]*$number[$k];
					$exists[$k]=0;
				}
			}
			// echo $k." ".$Finalbudget[$k]."<br>";
		}
		// echo "Budget : ".$budget.'<br>';
		if(!$change){
			break;
		}
	}
}
}