<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class JanrainUserIdentity extends CUserIdentity
{
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	private $_id;
	public $auth_key;

	public function __construct($username, $auth_key) {
		$this->username = $username;
	    $this->auth_key = $auth_key;
	}

	public function authenticate()
    {
        $user = User::model()->findByAttributes(array('auth_key'=>$this->auth_key));

        if ($user===null) { // No user found!
		    $this->errorCode=self::ERROR_USERNAME_INVALID; // although it's actually the auth key that is invalid
		}
		/*else if ($user->password !== sha1($this->password . $salt) ) { // Invalid password!
		    $this->errorCode=self::ERROR_PASSWORD_INVALID;
		}*/
		else { // Okay!
		    $this->errorCode=self::ERROR_NONE;
		    $this->_id=$user->id;
			$this->setState('role', $user->role);
			$this->setState('auth', 'janrain');
		}

		return !$this->errorCode;
	}

	public function getId()
    {
        return $this->_id;
    }
}
?>