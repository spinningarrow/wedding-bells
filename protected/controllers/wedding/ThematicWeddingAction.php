<?php

class ThematicWeddingAction extends CAction
{
    public function run($id, $choice = null)
    {
    	// Define the product IDs for the different options (platinum/gold/silver) for the 4 themes
		$wedding_details = array(
			array( // Classic: Platinum
				'venue_id' => 14,
				'caterer_id' => 7,
				'cake_id' => 5,
				'bride_id' => 1,
				'bridesmaid_id' => 19, 'number_bridesmaid' => 4,
				'groom_id' => 21,
				'groomsmen_id' => 37, 'number_groomsmen' => 4,
				'decor_id' => 5,
				'music_id' => 5,
				'photographer_id' => 1,
			),

			array( // Classic: Gold
				'venue_id' => 13,
				'caterer_id' => 24,
				'cake_id' => 6,
				'bride_id' => 2,
				'bridesmaid_id' => 12, 'number_bridesmaid' => 3,
				'groom_id' => 22,
				'groomsmen_id' => 34, 'number_groomsmen' => 3,
				'decor_id' => 4,
				'music_id' => 6,
				'photographer_id' => 2,
			),

			array( // Classic: Silver
				'venue_id' => 12,
				'caterer_id' => 38,
				'cake_id' => 2,
				'bride_id' => 5,
				'bridesmaid_id' => 16, 'number_bridesmaid' => 3,
				'groom_id' => 29,
				'groomsmen_id' => 38, 'number_groomsmen' => 3,
				'decor_id' => 4,
				'music_id' => 4,
				'photographer_id' => 7,
			),

			array( // Royal: Platinum
				'venue_id' => 5,
				'caterer_id' => 7,
				'cake_id' => 5,
				'bride_id' => 6,
				'bridesmaid_id' => 20, 'number_bridesmaid' => 4,
				'groom_id' => 22,
				'groomsmen_id' => 31, 'number_groomsmen' => 4,
				'decor_id' => 2,
				'music_id' => 3,
				'photographer_id' => 4,
			),

			array( // Royal: Gold
				'venue_id' => 4,
				'caterer_id' => 23,
				'cake_id' => 10,
				'bride_id' => 7,
				'bridesmaid_id' => 14, 'number_bridesmaid' => 3,
				'groom_id' => 27,
				'groomsmen_id' => 38, 'number_groomsmen' => 3,
				'decor_id' => 4,
				'music_id' => 6,
				'photographer_id' => 2,
			),

			array( // Royal: Silver
				'venue_id' => 4,
				'caterer_id' => 24,
				'cake_id' => 7,
				'bride_id' => 3,
				'bridesmaid_id' => 18, 'number_bridesmaid' => 3,
				'groom_id' => 26,
				'groomsmen_id' => 36, 'number_groomsmen' => 3,
				'decor_id' => 1,
				'music_id' => 6,
				'photographer_id' => 6,
			),

			array( // Beach: Platinum
				'venue_id' => 16,
				'caterer_id' => 23,
				'cake_id' => 2,
				'bride_id' => 8,
				'bridesmaid_id' => 20, 'number_bridesmaid' => 4,
				'groom_id' => 26,
				'groomsmen_id' => 39, 'number_groomsmen' => 4,
				'decor_id' => 2,
				'music_id' => 8,
				'photographer_id' => 2,
			),

			array( // Beach: Gold
				'venue_id' => 15,
				'caterer_id' => 34,
				'cake_id' => 12,
				'bride_id' => 10,
				'bridesmaid_id' => 12, 'number_bridesmaid' => 3,
				'groom_id' => 23,
				'groomsmen_id' => 40, 'number_groomsmen' => 3,
				'decor_id' => 2,
				'music_id' => 5,
				'photographer_id' => 3,
			),

			array( // Beach: Silver
				'venue_id' => 1,
				'caterer_id' => 10,
				'cake_id' => 7,
				'bride_id' => 2,
				'bridesmaid_id' => 18, 'number_bridesmaid' => 3,
				'groom_id' => 25,
				'groomsmen_id' => 40, 'number_groomsmen' => 3,
				'decor_id' => 1,
				'music_id' => 6,
				'photographer_id' => 6,
			),

			array( // Yacht: Platinum
				'venue_id' => 11,
				'caterer_id' => 7,
				'cake_id' => 5,
				'bride_id' => 4,
				'bridesmaid_id' => 11, 'number_bridesmaid' => 4,
				'groom_id' => 22,
				'groomsmen_id' => 34, 'number_groomsmen' => 4,
				'decor_id' => 4,
				'music_id' => 8,
				'photographer_id' => 9,
			),

			array( // Yacht: Gold
				'venue_id' => 11,
				'caterer_id' => 22,
				'cake_id' => 2,
				'bride_id' => 4,
				'bridesmaid_id' => 13, 'number_bridesmaid' => 3,
				'groom_id' => 26,
				'groomsmen_id' => 38, 'number_groomsmen' => 3,
				'decor_id' => 1,
				'music_id' => 12,
				'photographer_id' => 4,
			),

			array( // Yacht: Silver
				'venue_id' => 10,
				'caterer_id' => 24,
				'cake_id' => 12,
				'bride_id' => 2,
				'bridesmaid_id' => 18, 'number_bridesmaid' => 3,
				'groom_id' => 24,
				'groomsmen_id' => 39, 'number_groomsmen' => 3,
				'decor_id' => 3,
				'music_id' => 7,
				'photographer_id' => 1,
			),
		);

    	// Get the controller reference
		$controller = $this->getController();
        
        $model = $controller->loadModel($id);

        if (Yii::app()->user->id == $model->customer_id): // check if the wedding belongs to the currently signed in user

	        if ($model->type === "thematic" && $model->status !== "confirmed") { // once a wedding is confirmed, the theme cannot be changed
				
				if (isset($choice)) {
					
					if ($choice >= 1 && $choice <= 12) {

						switch($choice) {
							case 1: // Classic: Platinum
								$model->attributes = $wedding_details[intval($choice) - 1]; // massive assignment
								break;

							case 2: // Classic: Gold
								$model->attributes = $wedding_details[intval($choice) - 1]; // massive assignment
								break;

							case 3: // Classic: Silver
								$model->attributes = $wedding_details[intval($choice) - 1]; // massive assignment
								break;

							case 4: // Royal: Platinum
								$model->attributes = $wedding_details[intval($choice) - 1]; // massive assignment
								break;

							case 5: // Royal: Gold
								$model->attributes = $wedding_details[intval($choice) - 1]; // massive assignment
								break;

							case 6: // Royal: Silver
								$model->attributes = $wedding_details[intval($choice) - 1]; // massive assignment
								break;

							case 7: // Beach: Platinum
								$model->attributes = $wedding_details[intval($choice) - 1]; // massive assignment
								break;

							case 8: // Beach: Gold
								$model->attributes = $wedding_details[intval($choice) - 1]; // massive assignment
								break;

							case 9: // Beach: Silver
								$model->attributes = $wedding_details[intval($choice) - 1]; // massive assignment
								break;

							case 10: // Yacht: Platinum
								$model->attributes = $wedding_details[intval($choice) - 1]; // massive assignment
								break;

							case 11: // Yacht: Gold
								$model->attributes = $wedding_details[intval($choice) - 1]; // massive assignment
								break;

							case 12: // Yacht: Silver
								$model->attributes = $wedding_details[intval($choice) - 1]; // massive assignment
								break;
						}

						$model->status = 'pending';

						if($model->save()) { // save the model
							Yii::app()->user->setFlash('success', 'Your wedding\'s theme has been changed successfully.');
							$controller->redirect(array('view','id'=>$model->wedding_id));
						}
					}
					else {
						throw new CHttpException(400,'Invalid request. The chosen package does not exist.');
					}
				}

				// Otherwise display the thematicWedding view

				$prices = array();

				for ($theme_index = 0; $theme_index < count($wedding_details); $theme_index++) {
					$prices[] = array_sum(
						array(
							Venue::model()->findByPk($wedding_details[$theme_index]['venue_id'])->price,
							Caterer::model()->findByPk($wedding_details[$theme_index]['caterer_id'])->price_per_pax * $model->number_guests,
							Cake::model()->findByPk($wedding_details[$theme_index]['cake_id'])->price,
							Dress::model()->findByPk($wedding_details[$theme_index]['bride_id'])->price,
							Dress::model()->findByPk($wedding_details[$theme_index]['bridesmaid_id'])->price * $wedding_details[$theme_index]['number_bridesmaid'],
							Dress::model()->findByPk($wedding_details[$theme_index]['groom_id'])->price,
							Dress::model()->findByPk($wedding_details[$theme_index]['groomsmen_id'])->price * $wedding_details[$theme_index]['number_groomsmen'],
							Decor::model()->findByPk($wedding_details[$theme_index]['decor_id'])->price,
							Music::model()->findByPk($wedding_details[$theme_index]['music_id'])->price,
							Photographer::model()->findByPk($wedding_details[$theme_index]['photographer_id'])->price,
						)
					);
				}

				$controller->render('thematicWedding', array(
					'model' => $model,
					'prices' => $prices
				));
			}

			else {
				throw new CHttpException(400,'Invalid request. The requested wedding cannot be edited.');
			}

		else: // wedding does *not* belong to the currently signed in user
			throw new CHttpException(403, 'You are not authorized to perform this action.');
		endif;
    }
}
?>