<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
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

	public function authenticate()
    {
        $user = User::model()->findByAttributes(array('username'=>$this->username));
        if($user!==NULL && $user->role==='company'){
        $company = Company::model()->findByAttributes(array('id'=>$user->id));
    	}
        $salt = 'rollerblade'; // password salt

        if ($user===null) { // No user found!
		    $this->errorCode=self::ERROR_USERNAME_INVALID;
		}
		elseif ($user->password !== sha1($this->password . $salt) ) { // Invalid password!
		    $this->errorCode=self::ERROR_PASSWORD_INVALID;
		}
		elseif ($user->role === 'company' && $company->authenticated == 0){
			$this->errorCode=self::ERROR_NOT_AUTHENTICATED; // change this to a proper error
		}
		else { // Okay!
		    $this->errorCode=self::ERROR_NONE;
		    $this->_id=$user->id;
			$this->setState('role', $user->role);
		}

		return !$this->errorCode;
	}

	public function getId()
    {
        return $this->_id;
    }
}
?>