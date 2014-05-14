<?php

class AdminController extends Controller
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
			array('allow',
				'actions' => array('index', 'approveList','approve','decline', 'delete', 'error', 'view','update'),
				'users' => array('@'),
				'expression' => 'isset($user->role) && ($user->role === "admin")',
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
			),			
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{		
	$model=new Company('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Company']))
			$model->attributes=$_GET['Company'];

		$this->render('managecompany',array(
			'model'=>$model,
		));
	}	
	public function actionView($id)
	{
		$company=Company::model()->findByPk($id);
			if($company===null)
			throw new CHttpException(404,'The requested page does not exist.');
		$this->render('viewcompany',array(
			'model'=>$company,
		));
	}
	public function actionApproveList()
	{
		$this->render('approvecompany');
	}
	public function actionApprove($id)
	{
		$company = Company::model()->findByPK($id);
		$company->authenticated=1;
		$company->save();
		$body = "Dear ".$company->name.",\n\nThank you for submitting your application. We are pleased to inform you that your application has been successful and you have been registered as a listed company on WeddingBells Pvt.Ltd.\nYou may now login using the following link :\n".Yii::app()->createAbsoluteUrl('site/login')."\nBest Regards\nZahil Lihaz";
		$this->sendmail($body,$company->email_id);
		$this->render('approvecompany');
	}
	public function actionDecline($id)
	{
		$user = User::model()->findByPK($id);
		$company = Company::model()->findByPK($id);
		$curTr = Yii::app()->db->getCurrentTransaction();
    				$transaction = $curTr === null || !$curTr->getActive() ? Yii::app()->db->beginTransaction(): false;
    				try 
    				{	      					
						$company->delete();	
						$user->delete();					
       					if($transaction)
           				$transaction->commit();
           				$body = "Dear ".$company->name.",\n\nThank you for submitting your application. We regret to inform you that your application has been unsuccessful.\nBest Regards\nZahil Lihaz";
						$this->sendmail($body,$company->email_id);           				
   					} catch (Exception $e) {
				        if ($transaction) {
				            $transaction->rollback();				            
       					} 
       					else
           					throw $e;
					}				
		$this->render('approvecompany');
	}
	function sendmail($body,$email){
			$headers="From: verify\r\nReply-To: no-reply";
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

		//	$mail->SingleTo = true; // if you want to send mail to the users individually so that no recipients can see that who has got the same email.
			
			$mailer->From = "swlab@yahoo.com"; // Apparently nothing else works
			$mailer->FromName = "no-reply";
			$mailer->AddReplyTo("no-reply@weddingbells.com");

			$mailer->AddAddress($email);
			
			$mailer->Subject = "Wedding Bells - Application Outcome";
			$mailer->Body = $message;
			$mailer->Send();
	}
	public function actionUpdate($id)
	{
		$company=Company::model()->findByPk($id);
			if($company===null)
			throw new CHttpException(404,'The requested page does not exist.');
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'update-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
		if(isset($_POST['Company']))
		{
			$model->attributes=$_POST['Company'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}
		$this->render('updatecompany',array(
			'model'=>$company,
		));
	}

	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{	
			// we only allow deletion via POST request
			$company=Company::model()->findByPk($id);
			if($company === null) {
				throw new CHttpException(404,'The requested page does not exist.');
			}

			$category = $company->category;			
			$attribute = $category.'_id';
			
			if($category=='dress'){
				$condition = '(bride_id in (select id from dress where company_id ='."$id".') or groom_id in (select id from dress where company_id= '."$id".') or bridesmaid_id in (select id from dress where company_id = '."$id".') or groomsmen_id in (select id from dress where company_id= '."$id".')) and status=\'confirmed\' and date>'.date("Ymd");
			}

			else{
				$condition = "$attribute".' in (select id from '."$category".' where company_id = '."$id".') and status=\'confirmed\' and date>'.date("Ymd");
			}

			$criteria=new CDbCriteria;
			$criteria->condition=$condition;
			$wedding = Wedding::model()->find($criteria);
				
			if ($wedding !== NULL) {
				
				try {
					throw new CException('You cannot delete this company as it has pending orders.');
				}
				catch (CException $e) {
					if (!isset($_GET['ajax'])) {
						Yii::app()->user->setFlash('error', $e->getMessage());
					}
					else {
						echo "error@" . $e->getMessage();
					}
				}
			}
			else {	
				$user=User::model()->findByPk($company->id);
				$curTr = Yii::app()->db->getCurrentTransaction();
    				$transaction = $curTr === null || !$curTr->getActive() ? Yii::app()->db->beginTransaction(): false;
    				try 
    				{	 
    					$cat = ucfirst($category);
						$cat::model()->deleteAll('company_id='.$company->id);
						$company->delete();
						$user->delete();					
       					if($transaction)
           				$transaction->commit();

           				if(!isset($_GET['ajax'])) {
           					Yii::app()->user->setFlash('success', 'Company deleted successfully.');
           				}

           				else {
           					echo "success@Company deleted successfully.";
           				}
   					} catch (Exception $e) {
				        if ($transaction) {
				            $transaction->rollback();				            
       					} 
       					else
           					throw $e;
					}	
			}
			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax'])) {
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
			}
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
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

}