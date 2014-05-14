<?php

class SiteController extends Controller
{

	// + Enable access rules (copied from UserController)
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	// + Access rules
	public function accessRules()
	{
		return array(
			array('deny', // logged-in users can't login again
				'actions' => array('login'),
				'users' => array('@'),
			),
			array('deny', // logged-in users can't login again
				'actions' => array('signup', 'Csignup'),
				'users' => array('@'),
				'message' => 'You cannot sign up as you are already logged in to the website.',
			),
			array('allow',
				'actions' => array('index','error', 'page', 'contact', 'login', 'logout', 'captcha','signup','Csignup','confirmation','pendingApproval','validate','activated','forgotPassword','reset','displayReset','janrainLogin'),
				'users' => array('*'),
			),
			array('allow',
				'actions' => array('profile','changePassword','updateC','passConfirm'),
				'users' => array('@'),
				'expression' => 'isset($user->role) && ($user->role === "customer")',
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
				'testLimit' => 1, // + make CAPTCHA refresh every time (no idea why this wasn't already there)
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */

	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->render('index');
	}

	public function actionPendingApproval($name){
		$this->render('pending',array('name'=>$name));
	}

	public function actionProfile()
	{
		$customer = Customer::model()->with('id0')->findByPk(Yii::app()->user->getId());
		$this->render('viewcustomerprofile',array('model'=>$customer,
		));
	}

	public function actionChangePassword()
	{
		$user = User::model()->findByPk(Yii::app()->user->getId());
		$model = new ChangePassword;
		if(isset($_POST['ChangePassword']))
		{
			$model->attributes = $_POST['ChangePassword'];
			if($model->validate())
			{
				$user->password = SHA1($model->npassword.'rollerblade');
				if($user->save())
				{
				Yii::app()->user->setflash('success','Password changed succesfully');
				$this->redirect(array('profile'));
				}
			}
		}
		$this->render('passwordchange',array('model'=>$model,
		));
	}
	public function actionUpdateC()
	{
		$customer = Customer::model()->findByPk(Yii::app()->user->getId());
		$user = User::model()->findByPk(Yii::app()->user->getId());
			if($customer===null)
			throw new CHttpException(404,'The requested page does not exist.');
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'update-form') {
			echo CActiveForm::validate($customer);
			Yii::app()->end();
		}
		if(isset($_POST['Customer']))
		{
			$customer->attributes=$_POST['Customer'];
			if($customer->save()){
				Yii::app()->user->setflash('success','Profile updated succesfully');
			$this->redirect(array('profile'));
			}
		}
		$this->render('editcustomerprofile',array(
			'model'=>$customer,'user'=>$user
		));
	}
	public function actionCsignup(){
		$model=new SignupForm('company');
		$user=new User;
		$company = new Company;
		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='signup-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['SignupForm']))
		{
			$model->attributes=$_POST['SignupForm'];
			$salt='rollerblade';
			// validate user input and redirect to the previous page if valid
			if($model->validate())
				{
					$user->username=$model->email;
					$user->password=sha1($model->password.$salt);
					$user->role='company';	
					$company->name =$model->name;
					$company->regno = $model->regno;
					$company->category = $model->category;
					$company->address = $model->address;
					$company->pincode = $model->pincode;
					$company->phone = $model->contact;
					$company->email_id = $model->email;
					$company->country = 'Singapore';
					$company->authenticated = 0;										
					$curTr = Yii::app()->db->getCurrentTransaction();
    				$transaction = $curTr === null || !$curTr->getActive() ? Yii::app()->db->beginTransaction(): false;
    				try 
    				{
	      				$user->save();						
						$company->id=$user->id;
						$company->save();					
       					if($transaction)
           				$transaction->commit();           				
						$this->redirect(array('pendingApproval','name'=>$model->name));
   					} catch (Exception $e) {
				        if ($transaction) {
				            $transaction->rollback();				            
				            Yii::log(__CLASS__ . '::' . __FUNCTION__ . '() failed');
				            $this->redirect(array('Csignup'));
       					} 
       					else
           					throw $e;
					}			
				}					
		}
		// display the signup form
		$this->render('Csignup',array('model'=>$model));
	}
	public function actionDisplayReset(){
		$this->render('resetconfirm');
	}
	public function actionReset($passkey)
	{
		
		$reset=PassReset::model()->find('confirm_code='."'$passkey'");
		// Collect user input data
		if($reset==NULL || date("Y-m-d G:i:s")>$reset->expiry){
			$message = 'This link is no longer valid.';
			throw new CHttpException(400,$message);
		}
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'reset-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
		$model = new ResetForm;
		$salt = 'rollerblade';
		if(isset($_POST['ResetForm']))
		{
			$model->attributes=$_POST['ResetForm'];
			if($model->validate())
			{
				$user=User::model()->find('id='."'$reset->user_id'");
				$user->password=sha1($model->password.$salt);				
				if($user->save()){
						$reset->delete();
						$this->redirect(array('displayReset'));	
				}
			}
		}
		$this->render('resetpage',array('model'=>$model));
	}
	public function actionForgotPassword()
	{
		
		$model=new PasswordForm;
		// + If it is ajax validation request (copied from actionLogin)
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'forgot-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// Collect user input data
		if(isset($_POST['PasswordForm']))
		{
			$model->attributes=$_POST['PasswordForm'];
			if($model->validate())
			{
				$user=User::model()->find('username='."'$model->email'");
				$reset = new PassReset;
				$reset->user_id=$user->id;
				$reset->confirm_code=sha1(uniqid(rand()));				
				$reset->expiry=date("Y-m-d G:i:s", time()+((60*60)*24));
				if($reset->save()){

					$headers="From: verify\r\nReply-To: no-reply";
					$body = "Please use the following link to reset your password: \n".Yii::app()->createAbsoluteUrl('site/reset', array('passkey'=>$reset->confirm_code));
					// mail($model->email,'Password Reset',$body,$headers);

					$message = $body;
					$mailer = Yii::createComponent('application.extensions.mailer.EMailer');
					
					// Basic details - do not change
					$mailer->IsSMTP();
					$mailer->Port = 465;
					$mailer->Host = 'smtp.mail.yahoo.com';
					// $mail->IsHTML(true); // if you are going to send HTML formatted emails

					// Authorization details - do not change
					$mailer->Mailer = 'smtp';
					$mailer->SMTPSecure = 'ssl';
					$mailer->SMTPAuth = true;
					$mailer->Username = "swlab@yahoo.com";
					$mailer->Password = "s12345678";

			//		$mail->SingleTo = true; // if you want to send mail to the users individually so that no recipients can see that who has got the same email.
					
					$mailer->From = "swlab@yahoo.com"; // Apparently nothing else works
					$mailer->FromName = "no-reply";
					$mailer->AddReplyTo("no-reply@weddingbells.com");

					$mailer->AddAddress($model->email);
					
					$mailer->Subject = "Password Reset";
					$mailer->Body = $message;
					$mailer->Send();

					Yii::app()->user->setFlash('success','An email has been sent with a link to reset your password.');
					 $this->refresh();
				}
			}
		}
		$this->render('forgotpassword',array('model'=>$model));
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
	    if($error=Yii::app()->errorHandler->error)
	    {
	    	if(Yii::app()->request->isAjaxRequest)
	    		echo $error['message'];
	    	else
	        	$this->render('error', $error);
	    }
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;

		// + If it is ajax validation request (copied from actionLogin)
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'contact-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// Collect user input data
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$headers="From: {$model->email}\r\nReply-To: {$model->email}";
				
				// mail(Yii::app()->params['adminEmail'],$model->subject,$model->body,$headers); // original PHP mail function

				$message = $model->body;
				$mailer = Yii::createComponent('application.extensions.mailer.EMailer');
				
				// Basic details - do not change
				$mailer->IsSMTP();
				$mailer->Port = 465;
				$mailer->Host = 'smtp.mail.yahoo.com';
				// $mail->IsHTML(true); // if you are going to send HTML formatted emails

				// Authorization details - do not change
				$mailer->Mailer = 'smtp';
				$mailer->SMTPSecure = 'ssl';
				$mailer->SMTPAuth = true;
				$mailer->Username = "swlab@yahoo.com";
				$mailer->Password = "s12345678";

			//	$mail->SingleTo = true; // if you want to send mail to the users individually so that no recipients can see that who has got the same email.
				
				$mailer->From = "swlab@yahoo.com"; // Apparently nothing else works
				$mailer->FromName = $model->name;
				$mailer->AddReplyTo($model->email); // workaround so that reply-to is the user's email address

				$mailer->AddAddress(Yii::app()->params['adminEmail'], "Wedding Bells");
				
				$mailer->Subject = $model->subject;
				$mailer->Body = $message;
				$mailer->Send();
				
				// Display success flash on contact page
				Yii::app()->user->setFlash('success','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}
	public function actionConfirmation($email,$code){
		$this->render('confirm',array('email'=>$email,'code'=>$code));
	}
	public function actionActivated($name){
		$this->render('activate',array('name'=>$name));
	}
	public function actionValidate($passkey)
	{
		$user=new User;
		$customer=new Customer;
		$model=TempUser::model()->find('confirm_code='."'$passkey'");
		if($model==NULL){
			$message = 'This confirmation link is no longer valid. Your account might have already been activated. Please contact us if you still have issues signing up.';
			throw new CHttpException(400,$message);
		}
		$user->username=$model->username;
					$user->password=$model->password;
					$user->role='customer';
					$customer->first_name=$model->first_name;
					$customer->last_name=$model->last_name;
					$customer->phone=$model->phone;					
    				$curTr = Yii::app()->db->getCurrentTransaction();
    				$transaction = $curTr === null || !$curTr->getActive() ? Yii::app()->db->beginTransaction(): false;
    				try 
    				{
	      				$user->save();						
						$customer->id=$user->id;
						$customer->save();	
						$model->delete();					
       					if ($transaction)
           				$transaction->commit();           				
						$this->redirect(array('activated','name'=>$model->first_name));
   					} catch (Exception $e) {
				        if ($transaction) {
				            $transaction->rollback();				            
				            Yii::log(__CLASS__ . '::' . __FUNCTION__ . '() failed');
				            $this->redirect(array('signup'));
       					} 
       					else
           					throw $e;
					}
	}

    // OPENID LOGIN!
    public function actionJanrainLogin() {

        $rpx_api_key = '1377999aca4882bc988310ce36b909973fd79f37';

        if (isset($_POST['token'])) {

        	$token = $_POST['token'];

        	if(strlen($token) == 40) {//test the length of the token; it should be 40 characters

        	  /* STEP 2: Use the token to make the auth_info API call */
        	  $post_data = array('token'  => $token,
        	                     'apiKey' => $rpx_api_key,
        	                     'format' => 'json',
        	                     'extended' => 'false'); //Extended is not available to Basic.

        	  $curl = curl_init();
        	  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        	  curl_setopt($curl, CURLOPT_URL, 'https://rpxnow.com/api/v2/auth_info');
        	  curl_setopt($curl, CURLOPT_POST, true);
        	  curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
        	  curl_setopt($curl, CURLOPT_HEADER, false);
        	  curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        	  curl_setopt($curl, CURLOPT_FAILONERROR, true);
        	  $result = curl_exec($curl);
        	  if ($result == false){
        	    echo "\n".'Curl error: ' . curl_error($curl);
        	    echo "\n".'HTTP code: ' . curl_errno($curl);
        	    echo "\n"; var_dump($post_data);
        	  }
        	  curl_close($curl);


        	  /* STEP 3: Parse the JSON auth_info response */
        	  $auth_info = json_decode($result, true);

				if ($auth_info['stat'] == 'ok') {
					
					// echo "\n auth_info:";
					// var_dump($auth_info);

					$identifier = $auth_info['profile']['identifier'];

		        	// Check if the user already exists
					$user = User::model()->findByAttributes(array('auth_key' => $identifier));

					if($user === NULL) { // i.e. user logged in for the first time

						// echo "User was null.";

						try {

						  	$user = new User;
						  	$customer = new Customer;

						  	$user->setScenario('janrainSignup');

				            $user->username = $auth_info['profile']['email'];
				            $user->role = "customer";
				            $user->auth = 'janrain';
				            $user->auth_key = $identifier;
			  				
			  				if ($user->save()) {

				  				$first_name = isset($auth_info['profile']['name']['givenName']) ? $auth_info['profile']['name']['givenName'] : $auth_info['profile']['preferredUsername'];
				  				$last_name = isset($auth_info['profile']['name']['familyName']) ? $auth_info['profile']['name']['familyName'] : $auth_info['profile']['preferredUsername'];
								
								$customer->first_name = $first_name;
					            $customer->last_name = $last_name;
					            $customer->id = $user->id; // User::model()->findByAttributes(array('auth_key' => $fb['id']))->id;
					            // $customer->id = User::model()->findByAttributes(array('auth_key' => $fb['id']))->id;
					            $customer->save();

					            Yii::app()->user->setFlash('info', 'Welcome to Wedding Bells!');
					        }

					        // Yii::app()->user->setFlash('error', "<pre>" . print_r($auth_info, true) . print_r($user, true) . print_r($customer, true) ."</pre>");

				            // var_dump($user);
				            // var_dump($customer);
						}

						catch (CDbException $e) {
							Yii::app()->user->setFlash('error', "A Wedding Bells user with that email address already exists.");
							$this->redirect(array('site/login'));
						}
					}

					$identity = new JanrainUserIdentity($auth_info['profile']['email'], $identifier);
					if ($identity->authenticate()) {
						// var_dump($identity);
						Yii::app()->user->login($identity);
						$this->redirect(Yii::app()->user->returnUrl);
					}

		        }

		        else { // i.e., !($auth_info['stat'] == 'ok')

					// Gracefully handle auth_info error.  Hook this into your native error handling system.
		        	Yii::app()->user->setFlash('error', 'An error occurred while trying to authenticate.');
					// var_dump($auth_info);
					// echo "\n";
					// var_dump($result);
		        }
    	    }

    	    else {
    	      // Gracefully handle the missing or malformed token.  Hook this into your native error handling system.
    	      Yii::app()->user->setFlash('info', 'Authentication canceled.');
    	    }
        }

        $this->redirect(array('site/login'));
    }

	public function actionSignup()
	{
		$model=new SignupForm('customer');
		$user=new TempUser;
		$user->setScenario('signup');
		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='signup-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['SignupForm']))
		{
			$model->attributes=$_POST['SignupForm'];
			$salt='rollerblade';
			 $check=TempUser::model()->find('username='."'$model->email'");	
			 if($check!=NULL){
			 	$check->delete();
			}		
			// validate user input and redirect to the previous page if valid
			if($model->validate())
				{
					$user->username=$model->email;
					$user->password=sha1($model->password.$salt);
					$user->first_name=$model->Fname;
					$user->last_name=$model->Lname;
					$user->phone=$model->contact;	
					$user->confirm_code=sha1(uniqid(rand()));
	      			if($user->save()){
	      				$this->redirect(array('confirmation','email'=>$user->username,'code'=>$user->confirm_code));	      				
	      			} 					
				}					
		}
		// display the signup form
		$this->render('signup',array('model'=>$model));
	}
	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
}