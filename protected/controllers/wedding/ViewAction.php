<?php

/*
This action lets users view or edit weddings.
For non-thematic weddings, users can edit the wedding if the status is pending.
For thematic weddings, users can go back to the theme choosing page if the status is pending.

If the wedding status is confirmed, users can only view the wedding details.
*/

class ViewAction extends CAction
{
    public function run($id, $choice = null)
    {
		$controller = $this->getController(); // get the controller reference
        $model = $controller->loadModel($id);

        // $this->performAjaxValidation($model);

        if (Yii::app()->user->id == $model->customer_id): // check if the wedding belongs to the currently signed in user

        	// If the user is trying to view a blank (just created) wedding...
        	if ($model->status === "created") {

        		if ($model->type !== "thematic") { // non-thematic wedding
	        		$controller->redirect(array('prioritySelection','id' => $model->wedding_id)); // ...redirect to priority selection if the budget has not been allocated
	        	}

	        	else { // thematic wedding
		        	$controller->redirect(array('thematicWedding','id' => $model->wedding_id)); // ...redirect to theme selection if no theme has been chosen
	        	}
        	}

	        if ($model->type !== "thematic" && $model->status !== "confirmed") { // once a non-thematic wedding is confirmed, it can no longer be edited

	        	$model->scenario = "edit";

				if(isset($_POST['Wedding'])) {
					$model->attributes=$_POST['Wedding'];
					if($model->save()) {
						Yii::app()->user->setflash('success','Your wedding has been saved successfully.');
						$controller->redirect(array('index'));
					}
					else {
						Yii::app()->user->setflash('error','An error occurred while trying to save the wedding.');
					}
				}
			}

			else { // thematic weddings can only be viewed
				$model->scenario = "view";
			}

			// Put all the wedding details in an associative array in order to display them in HTML
			$data = array();

			if (isset($model->venue_id)) { 

				$temp = Venue::model()->findByPk($model->venue_id);
				$data['venue'] = array(
					'id' => $temp->id,
					'name' => $temp->name,
					'description' => "<strong>Capacity</strong>: {$temp->capacity}<br>" . $temp->description,
					'price' => $temp->price
				);
			}

			if (isset($model->caterer_id)) {

				$temp = Caterer::model()->findByPk($model->caterer_id);
				$data['caterer'] = array(
					'id' => $temp->id,
					'name' => $temp->name,
					'description' => $temp->description,
					'price' => $temp->price_per_pax * $model->number_guests /*. " ($" . $temp->price_per_pax . "/pax)"*/
				);
			}

			if (isset($model->cake_id)) { 

				$temp = Cake::model()->findByPk($model->cake_id);
				$data['cake'] = array(
					'id' => $temp->id,
					'name' => $temp->name,
					'description' => $temp->description,
					'price' => $temp->price
				);
			}

			if (isset($model->bride_id)) { // Bride dress

				$temp = Dress::model()->findByPk($model->bride_id);
				$data['bride'] = array(
					'id' => $temp->id,
					'name' => $temp->name,
					'description' => $temp->description,
					'price' => $temp->price
				);
			}

			if (isset($model->groom_id)) { // Groom dress

				$temp = Dress::model()->findByPk($model->groom_id);
				$data['groom'] = array(
					'id' => $temp->id,
					'name' => $temp->name,
					'description' => $temp->description,
					'price' => $temp->price
				);
			}

			if (isset($model->bridesmaid_id)) { // Bridesmaid dresses

				$temp = Dress::model()->findByPk($model->bridesmaid_id);
				$data['bridesmaid'] = array(
					'id' => $temp->id,
					'name' => $temp->name,
					'description' => $temp->description,
					'price' => $temp->price * $model->number_bridesmaid
				);
			}

			if (isset($model->groomsmen_id)) { // Groomsmen dresses

				$temp = Dress::model()->findByPk($model->groomsmen_id);
				$data['groomsmen'] = array(
					'id' => $temp->id,
					'name' => $temp->name,
					'description' => $temp->description,
					'price' => $temp->price * $model->number_groomsmen
				);
			}

			if (isset($model->decor_id)) { 

				$temp = Decor::model()->findByPk($model->decor_id);
				$data['decor'] = array(
					'id' => $temp->id,
					'name' => $temp->name,
					'description' => $temp->description,
					'price' => $temp->price
				);
			}

			if (isset($model->music_id)) { 

				$temp = Music::model()->findByPk($model->music_id);
				$data['music'] = array(
					'id' => $temp->id,
					'name' => $temp->name,
					'description' => $temp->description,
					'price' => $temp->price
				);
			}

			if (isset($model->photographer_id)) { 

				$temp = Photographer::model()->findByPk($model->photographer_id);
				$data['photographer'] = array(
					'id' => $temp->id,
					'name' => $temp->name,
					'description' => $temp->description,
					'price' => $temp->price
				);
			}

			// Compute the total cost of the wedding (displayed in the 'view' scenario; 'edit' scenario updates via JavaScript)
			$total_cost = 0;

			foreach ($data as $product_type => $product_details) {
				$total_cost += $product_details['price'];
			}

			// Load the view
			$controller->render('viewWedding',array(
				'model'=>$model,
				'data' => $data,
				'total_cost' => $total_cost,
			));

		else: // wedding does *not* belong to the currently signed in user
			throw new CHttpException(403, 'You are not authorized to perform this action.');
		endif;
    }
}
?>