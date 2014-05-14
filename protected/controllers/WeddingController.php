<?php

class WeddingController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	//public $layout='//layouts/column2'; // because we don't want this currently

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
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('view'),
				'users'=>array('*'),
			),
			/*array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),*/
			array('allow',
				'actions' => array('index', 'add', 'prioritySelection', 'allocate', 'ajaxListProducts', 'ajaxVenueMap', 'thematicWedding', 'payment', 'viewWedding'),
				'users' => array('@'),
				'expression' => 'isset($user->role) && ($user->role === "customer")',
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
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
			'thematicwedding' => 'application.controllers.wedding.ThematicWeddingAction', // thematicWedding action
			// 'editwedding' => 'application.controllers.wedding.EditWeddingAction', // we no longer have a separate editWedding action (merged with view)
			'view' => 'application.controllers.wedding.ViewAction', // viewWedding action
		);
	}

	// + Add a new wedding
	public function actionAdd() {

		$model = new Wedding('add'); // create a new Wedding model with the 'add' scenario

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Wedding']))
		{
			if (isset($_POST['submit-thematic'])) {
				$_POST['Wedding']['type'] = 'thematic';
			}
			elseif (isset($_POST['submit-custom'])) {
				$_POST['Wedding']['type'] = 'non-thematic';
			}

			$model->attributes=$_POST['Wedding'];

			if ($model->validate()) {

				$model->customer_id = Yii::app()->user->id; // set customer_id to current user's id
				$model->status = 'created';
			
				if($model->save()) {
					if ($model->type === "thematic") {
						$this->redirect(array('thematicWedding', 'id' => $model->wedding_id));	
					}
					
					$this->redirect(array('prioritySelection', 'id' => $model->wedding_id));
				}
			}
		}

		$this->render('add',array(
			'model'=>$model,
		));
	}

	// + Priority selection (create a custom wedding)
	public function actionPrioritySelection($id) {

		// $this->performAjaxValidation($model);

		$model=$this->loadModel($id);

		if ($model->type !== "thematic" && $model->status === "created") { // only non-thematic just-created weddings can be allocated stuff from the budget algorithm

			$model->setScenario('prioritySelection');
			
			if(isset($_POST['Wedding'])) {

				$model->attributes=$_POST['Wedding'];
				
				if($model->save()) {
					$this->redirect(array('allocate','id'=>$model->wedding_id));
				}
			}

			$this->render('prioritySelection',array(
				'model'=>$model,
			));
		}

		else {
			throw new CHttpException(400,'Invalid request. The requested wedding cannot be edited.');
		}
	}

	// + Allocate the budget based on customer's entered budget and selected priorities
	public function actionAllocate($id) {
		
		// $this->performAjaxValidation($model);

		// No saving to model here? [priorities]
		
		$model=$this->loadModel($id);

		if (Yii::app()->user->id == $model->customer_id) { // check if the wedding belongs to the currently signed 

			if ($model->type !== "thematic" && $model->status === "created") {

				$model->allocateBudget();
				$model->status = 'pending';

				if($model->save()) {
					$this->redirect(array('view','id'=>$model->wedding_id));
				}
				else {

					// Display error
					$Database["Decor"] = CHtml::listData(Decor::model()->findAll('status="enabled"',array('order'=>'price asc')),'id','price');
					foreach ($Database as $k=> $v) {
						foreach ($v as $key => $value) {
							echo $key." ".$value."<br>";
						}
					}
					$connection = Yii::app()->db;
					$max = $connection->createCommand('select max(price) from decor where status="enabled"')->queryScalar(); 
					$min =  $connection->createCommand('select min(price) from decor where status="enabled"')->queryScalar();
					$avg0 =$connection->createCommand('select (min(price)+avg(price))/2 from decor where status="enabled"')->queryScalar();
					echo $max." ".$min." ".$avg0;
					echo CHtml::errorSummary($model);
				}
			}
			else {
				throw new CHttpException(400,'Invalid request. The chosen wedding cannot be allocated.');
			}
		}
		else {
			throw new CHttpException(403, 'You are not authorized to perform this action.');
		}
	}

	// Generate a partial view of a list of products (loaded via ajax on the editWedding page)
	public function actionAjaxListProducts($id, $type, $selected) {
		$model = $this->loadModel($id);

		switch($type) {

			case 'cake' :
				$products = Cake::model()->findAll(array('condition' => 'status = "enabled"', 'order' => 'price DESC'));
				break;

			case 'caterer' :
				$products = Caterer::model()->findAll(array('condition' => "status = 'enabled' AND min_pax <= {$model->number_guests}", 'order' => 'price_per_pax DESC'));
				break;

			case 'decor' :
				$products = Decor::model()->findAll(array('condition' => 'status = "enabled"', 'order' => 'price DESC'));
				break;

			case 'dress' : // deprecated, type will be one of the following dress types, not 'dress'
				$dress_type = Dress::model()->findByPk($selected)->category;
				$products = Dress::model()->findAll(array('condition' => "status = 'enabled' AND category = '$dress_type'", 'order' => 'price DESC'));
				break;

			case 'bride' :
				$products = Dress::model()->findAll(array('condition' => "status = 'enabled' AND category = '$type'", 'order' => 'price DESC'));
				break;

			case 'groom' :
				$products = Dress::model()->findAll(array('condition' => "status = 'enabled' AND category = '$type'", 'order' => 'price DESC'));
				break;

			case 'bridesmaid' :
				$products = Dress::model()->findAll(array('condition' => "status = 'enabled' AND category = '$type'", 'order' => 'price DESC'));
				break;

			case 'groomsmen' :
				$products = Dress::model()->findAll(array('condition' => "status = 'enabled' AND category = 'groomsman'", 'order' => 'price DESC'));
				break;

			case 'music' :
				$products = Music::model()->findAll(array('condition' => 'status = "enabled"', 'order' => 'price DESC'));
				break;

			case 'photographer' :
				$products = Photographer::model()->findAll(array('condition' => 'status = "enabled"', 'order' => 'price DESC'));
				break;

			case 'venue' :
				$products = Venue::model()->findAllBySQL("select * from venue where status = 'enabled' AND capacity >= {$model->number_guests} AND  id NOT IN (select venue_id from wedding where status = 'confirmed' AND date = '{$model->date}' AND venue_id IS NOT NULL) order by price DESC");

				// findAll(array('condition' => "status = 'enabled' AND capacity >= {$model->number_guests}", 'order' => 'price DESC'));
				break;
		}

		$this->renderPartial('ajax/listProducts', array(
			'model' => $model,
			'type' => $type,
			'products' => $products,
			'selectedId' => intval($selected)
		));
	}

	// actionThematicWedding: Thematic wedding
	// Moved to separate action class

	// Generate a partial view of a Google Map for the specified address
	public function actionAjaxVenueMap($address) {

		$this->renderPartial('ajax/venueMap', array(
			'model' => $model,
			'address' => $address
		));
	}

	/**
	 * -> Moved to separate action when it was merged with edit wedding
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	/*public function actionView($id)
	{
		$model = $this->loadModel($id);

		// Don't display wedding if it has been created but not assigned
		if ($model->status === "created") {
			if ($model->type === "thematic") {
				$this->redirect(array('thematicWedding','id'=>$model->wedding_id));
			}

			else {
				$this->redirect(array('editWedding','id'=>$model->wedding_id)); // edit wedding automatically checks if budget algorithm has allocated products or not
			}
		}
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}*/

	/**
	 * Displays the payment page.
	 * @param integer $id the ID of the model to be displayed
	 */

	public function actionPayment($id) {

		$model = $this->loadModel($id);

		$model->status = 'confirmed';
		
		if($model->save()) {
			Yii::app()->user->setflash('success','Your wedding has been confirmed successfully.');
			$this->render('payment', array(
				'model' => $model,
			));
		}
		else {
			Yii::app()->user->setflash('error','An error occurred while trying to confirm the wedding.');
			$this->redirect(array('view','id'=>$model->wedding_id));
		}
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Wedding;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Wedding']))
		{
			$model->attributes=$_POST['Wedding'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->wedding_id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Wedding']))
		{
			$model->attributes=$_POST['Wedding'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->wedding_id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 * Edit: Lists all weddings created by the current user
	 */
	public function actionIndex()
	{
		$dataProvider = new CActiveDataProvider('Wedding', array(
				'criteria' => array(
					'condition' => 'customer_id=' . Yii::app()->user->id,
					'order' => 'date ASC',
					'with' => array('venue')
				),
				'pagination' => false, // stupid thing was limiting to only 10 results *eyeroll*
			)
		);

		// $dataProvider->setPagination(false);
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Wedding('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Wedding']))
			$model->attributes=$_GET['Wedding'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Wedding::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='wedding-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}