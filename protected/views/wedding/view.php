<?php
/* -------------------- OLD PAGE, NO LONGER USED -------------------- */

	$wedding_cost = 0;

	// Get all wedding details
	$wedding_details = array(

		'venue' => isset($model->venue_id) ? array(
			'id' => $model->venue->id,
			'name' => $model->venue->name,
			'description' => $model->venue->description,
			'price' => $model->venue->price,
		) : NULL,

		'caterer' => isset($model->caterer_id) ? array(
			'id' => $model->caterer->id,
			'name' => $model->caterer->name,
			'description' => $model->caterer->description,
			'price' => $model->caterer->price_per_pax * $model->number_guests,
		) : NULL,

		'cake' => isset($model->cake_id) ? array(
			'id' => $model->cake->id,
			'name' => $model->cake->name,
			'description' => $model->cake->description,
			'price' => $model->cake->price,
		) : NULL,

		'bride' => isset($model->bride_id) ? array(
			'id' => $model->bride->id,
			'name' => $model->bride->name,
			'description' => $model->bride->description,
			'price' => $model->bride->price,
		) : NULL,

		'groom' => isset($model->groom_id) ? array(
			'id' => $model->groom->id,
			'name' => $model->groom->name,
			'description' => $model->groom->description,
			'price' => $model->groom->price,
		) : NULL,

		'bridesmaid' => isset($model->bridesmaid_id) ? array(
			'id' => $model->bridesmaid->id,
			'name' => $model->bridesmaid->name,
			'description' => $model->bridesmaid->description,
			'price' => $model->bridesmaid->price,
		) : NULL,

		'groomsmen' => isset($model->groomsmen_id) ? array(
			'id' => $model->groomsmen->id,
			'name' => $model->groomsmen->name,
			'description' => $model->groomsmen->description,
			'price' => $model->groomsmen->price,
		) : NULL,

		'decor' => isset($model->decor_id) ? array(
			'id' => $model->decor->id,
			'name' => $model->decor->name,
			'description' => $model->decor->description,
			'price' => $model->decor->price,
		) : NULL,

		'music' => isset($model->music_id) ? array(
			'id' => $model->music->id,
			'name' => $model->music->name,
			'description' => $model->music->description,
			'price' => $model->music->price,
		) : NULL,

		'photographer' => isset($model->photographer_id) ? array(
			'id' => $model->photographer->id,
			'name' => $model->photographer->name,
			'description' => $model->photographer->description,
			'price' => $model->photographer->price,
		) : NULL,
	);
?>

<h2>View Wedding: <?php echo $model->name; ?></h2>

<div class="row">
	<p class="span3 label label-info"><?php echo date("j F Y (l)", strtotime($model->date)); ?></p>
	<?php $days_left = floor((strtotime($model->date) - time())/(60*60*24)); ?>
	<p class="span2 label label-<?php echo ($days_left > 14 ? "success" : "important"); ?>"><?php echo "$days_left days left"; ?></p>
	<p class="span2 label label-inverse"><?php echo $model->number_guests; ?> guests</p>
</div>

<?php
	foreach ($wedding_details as $product_type => $product_details):
		$wedding_cost += $product_details['price'];
		if (isset($wedding_details[$product_type])):
?>

	<h3><?php echo Wedding::dressType($product_type, true); ?></h3>
	<div id="<?php echo $product_type; ?>" class="row">
		<p class="span1"><img src="<?php echo Yii::app()->request->baseUrl . "/assets/img/products/" . Wedding::dressType($product_type) . "/{$product_details['id']}.jpg"; ?>" width="64" height="64" alt="<?php echo $product_details['name']; ?>"></p>
		<div class="span6">
			<h4 class="details-name"><?php echo $product_details['name']; ?></h4>
			<!-- <p><span class="details-description"><?php echo $product_details['description']; ?></span> -->
		<?php if ($product_type === "venue"): ?>
			<!-- <br><a id="venue-address" class="details-address" title="<?php //echo $product_details['address']; ?>" rel="<?php echo $product_details['name'] ?>" data-toggle="modal" href="#maps-modal">View location on a map</a>. -->
		<?php endif; ?>
			</p>
			<p>Price: $<strong class="details-price"><?php echo $product_details['price']; ?></strong></p>
		</div>
	</div>
	<hr class="list-divider">

	<?php endif; ?>
<?php endforeach; ?>

<div class="alert">
	<strong>Total Cost: $<?php echo $wedding_cost; ?></strong>
</div>

<?php
	if ($model->status !== "confirmed" && (strtotime($model->date) - time()) > 14*24*60*60):
		echo CHtml::link(
			'Confirm',
			array('/wedding/payment', 'id' => $model->wedding_id),
			array('class' => 'btn btn-large btn-primary')
		);
?>

<?php

		if ($model->type === "thematic") {
			echo CHtml::link(
				'Change Theme',
				array('/wedding/thematicWedding', 'id' => $model->wedding_id),
				array('class' => 'btn btn-large btn-inverse')
			);
		}
		else {
			echo CHtml::link(
				'Edit Wedding',
				array('/wedding/editWedding', 'id' => $model->wedding_id),
				array('class' => 'btn btn-large btn-inverse')
			);
		}
	endif;
?>