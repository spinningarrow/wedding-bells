<?php

class CompanyController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('deny', // logged-in users can't login again
				'actions' => array('login'),
				'users' => array('@'),
			),
			array('allow',
				'actions' => array('index', 'create','updateC','changePassword','passConfirm', 'toggle','profile', 'error', 'view','update', 'addProduct', 'admin'),
				'users' => array('@'),
				'expression' => 'isset($user->role) && ($user->role === "company")',
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionIndex()
	{	
		$company = Company::model()->findByPK(Yii::app()->user->getId());
		$this->render('orders',array(
			'company'=>$company,
		));
	}
	
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$company = Company::model()->findByPk(Yii::app()->user->getId());
		$category=ucfirst($company->category);
		$model = $category::model()->findByPk($id);	
		if($model!==NULL && $model->company_id===$company->id){
		$path = Yii::app()->request->baseUrl . "/assets/img/products/".$category.'/'.$model->id.'.jpg';	
			$this->render('viewproduct',array(
				'model'=>$this->loadModel($id),'path'=>$path
			));
		}
		else{
			throw new CHttpException(404,'Invalid Request');
		}
	}
	public function actionProfile()
	{
		$company = Company::model()->findByPk(Yii::app()->user->getId());
				$this->render('viewprofile',array('model'=>$company,
		));
	}
	public function actionPassConfirm()
	{
		$this->render('passwordconfirmation');
	}
	public function actionChangePassword()
	{
		$user = User::model()->findByPk(Yii::app()->user->getId());
		$model = new ChangePassword;
		if(isset($_POST['ChangePassword']))
		{
			$model->attributes = $_POST['ChangePassword'];
			if($user->password === SHA1($model->currentpassword.'rollerblade'))
			{
				$user->password = SHA1($model->npassword.'rollerblade');
				if($user->save())
				{
				Yii::app()->user->setflash('success','Password changed succesfully');
				$this->redirect(array('profile'));
				}
			}
			else{
				throw new CHttpException(404,'There was some error processing your request. Please make sure you enter the correct password.');
			} 	
		}
		$this->render('passwordchange',array('model'=>$model,
		));
	}


	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	//image upload reference
	// add to view in widget options--->>>> 'htmlOptions'=>array('enctype'=>'multipart/form-data'),
	// public function actionCreate()
	// {
		
	// 	$model = new Company;
	// 	$image = new Image;
	// 	if (isset($_POST['ajax']) && $_POST['ajax'] === 'reset-form') {
	// 		echo CActiveForm::validate($model);
	// 		Yii::app()->end();
	// 	}		
	// 	if(isset($_POST['Company']))
	// 	{
	// 		$model->attributes=$_POST['Company'];			
	// 		$image=CUploadedFile::getInstance($image,'image');					
	// 		if($model->save())
	// 		{		
	// 			$path = dirname(dirname(dirname(__FILE__))).'\assets\img\products\\'.$category.'\\'.$model->id.'.';
	// 			$path.=$image->getExtensionName();			
	// 			$image->saveAs($path);
	// 			$this->redirect(array('viewCompany','id'=>$model->id));	
	// 		}
	// 	}
	// 	$this->render('addcompany',array('model'=>$model,'image'=>$image));
	// }
	

	public function actionAddProduct()
	{
		$company = Company::model()->findByPk(Yii::app()->user->getId());
		$category=ucfirst($company->category);
		$model = new $category;
		$Mimage = new Image('create');
		$path = '';
		if(isset($_POST[$category]))
		{
			$model->attributes=$_POST[$category];
			$Mimage->image=CUploadedFile::getInstance($Mimage,'image');
			$model->company_id=$company->id;
			if($Mimage->validate() && $model->save() )
			{
				if($Mimage->image!==NULL){
				$path = dirname(dirname(dirname(__FILE__))).'\assets\img\products\\'.$category.'\\'.$model->id.'.jpg';
	 			$Mimage->image->saveAs($path);
	 			}
				$this->redirect(array('view','id'=>$model->id,'path'=>$path));
			}
		}
		$this->render('addproduct',array(
			'model'=>$model,'category'=>$category,'image'=>$Mimage
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdateC()
	{
		$company = Company::model()->findByPk(Yii::app()->user->getId());
			if($company===null)
			throw new CHttpException(404,'The requested page does not exist.');
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'update-form') {
			echo CActiveForm::validate($company);
			Yii::app()->end();
		}
		if(isset($_POST['Company']))
		{
			$company->attributes=$_POST['Company'];
			if($company->save()){
			Yii::app()->user->setflash('success','Profile updated successfully');
			$this->redirect(array('profile'));
			}
		}
		$this->render('editcompanyprofile',array(
			'model'=>$company,
		));
	}
	public function actionUpdate($id)
	{
		$company = Company::model()->findByPk(Yii::app()->user->getId());
		$category=ucfirst($company->category);
		$model = $category::model()->findByPk($id);		
		if($model!==NULL && $model->company_id===$company->id){
		$Mimage = new Image;
		if(isset($_POST[$category]))
		{
			$model->attributes=$_POST[$category];
			$Mimage->image=CUploadedFile::getInstance($Mimage,'image');
			if($Mimage->validate() && $model->save())
			{
				if($Mimage->image!==NULL){
				$path = dirname(dirname(dirname(__FILE__))).'\assets\img\products\\'.$category.'\\'.$model->id.'.jpg';
	 			$Mimage->image->saveAs($path);
	 			}
				$this->redirect(array('view','id'=>$model->id));
			}
		}

		$this->render($category.'/create',array(
			'model'=>$model,'image'=>$Mimage,
		));
		}
		else{
			throw new CHttpException(404,'Invalid Request');
		}
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionToggle($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$product = $this->loadModel($id);
			if($product->status === 'disabled')
			{
				$product->status = 'enabled';
			}
			else
			{
				$product->status = 'disabled';
			}
			$product->save();
			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}
	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$company = Company::model()->findByPk(Yii::app()->user->getId());
		$category=ucfirst($company->category);
		$model = new $category('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET[$category]))
			$model->attributes=$_GET[$category];

		$this->render('manageproducts',array(
			'model'=>$model,'category'=>$category,'company_id'=>$company->id,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$company = Company::model()->findByPk(Yii::app()->user->getId());
		$category=ucfirst($company->category);
		$model = $category::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='company-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
