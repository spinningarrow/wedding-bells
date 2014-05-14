<?php 
class SignupForm extends CFormModel
{
	public $email;
	public $password;
	public $cpassword;
	public $regno;
	public $name;
	public $Fname;
	public $Lname;
	public $category;
	public $address;
	public $pincode;
	public $contact;
	public $verifyCode;
	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// username and password are required
			array('email, password, cpassword, Fname, Lname, verifyCode', 'required', 'on'=>'customer'),
			array('regno, password, cpassword, name, category, email, verifyCode', 'required', 'on'=>'company'),
			array('Fname, Lname, name', 'length','max'=>80),
			array('email', 'email'),
			array('email', 'unique','attributeName' => 'username','className' => 'User','message'=>'An account with this email ID already exists'),
			array('regno', 'unique','attributeName' => 'regno','className' => 'Company','message'=>'An account with this registration number already exists'),
			array('password', 'length', 'min'=>6),
			array('pincode', 'numerical'),
			array('pincode', 'length','min'=>6,'message'=>'Pincode should be six digits','max'=>6),
			array('cpassword', 'compare','compareAttribute'=>'password'),
			array('contact', 'match', 'pattern'=>'/^([+]?[0-9 ]+)$/'),
			array('contact', 'length', 'min'=>7, 'max'=>14, 'message'=>'Invalid Contact Number','tooShort'=>'Contact Number is too Short','skipOnError'=>true),
			array('verifyCode', 'captcha', 'allowEmpty'=>!CCaptcha::checkRequirements()),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'cpassword' => 'Re-type password', // + Renamed from original
			'Fname' => 'First Name',
			'Lname' => 'Last Name',
			'verifyCode'=>'Verification Code',
			'contact' => 'Contact Number',
			'regno' => 'Registration Number'
		);
	}
}
?>
