<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class ResetForm extends CFormModel
{
	public $password;
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
			array('password,cpassword', 'required'),			
			// rememberMe needs to be a boolean
			array('password', 'length', 'min'=>6),
			array('cpassword', 'compare','compareAttribute'=>'password'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'password' => 'New Password',
			'cpassword' => 'Confirm Password',
		);
	}
}
