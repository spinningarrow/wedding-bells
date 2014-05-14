<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class ChangePassword extends CFormModel
{
	public $currentpassword;
	public $npassword;
	public $cpassword;
	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// username and password are required
			array('currentpassword, npassword, cpassword', 'required'),		
			array('currentpassword', 'validatep'),	
			// rememberMe needs to be a boolean
			array('npassword', 'length', 'min'=>6,'tooShort'=>'Password is too short (minimum is 6 characters).'),
			array('cpassword', 'compare','compareAttribute'=>'npassword'),
		);
	}

	public function validatep($attribute,$params)
	{
		$user = User::model()->findByPk(Yii::app()->user->getId());
		if($user->password !== SHA1($this->currentpassword.'rollerblade')){
			$this->addError('currentpassword','Incorrect Password');
		}
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'currentpassword' => 'Current Password',
			'npassword' => 'New Password',
			'cpassword' => 'Confirm Password',
		);
	}
}
