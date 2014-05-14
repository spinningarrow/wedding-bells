<table class="table table-striped products-list">
	<thead></thead>
	<tfoot></tfoot>
	<tbody>
	<?php foreach ($products as $value):

		$id = $value->id;
		$name = $value->name;
		$description = $value->description;
		// $price = isset($value->price) ? $value->price : ($value->price_per_pax * $model->number_guests); // because Caterer has price_per_pax and not price =/

		// Get the right price
		if (isset($value->price)) {
		
			if ($type === 'bridesmaid') {
				$price = $value->price * $model->number_bridesmaid;
			}
			elseif($type === 'groomsmen') {
				$price = $value->price * $model->number_groomsmen;
			}
			else {
				$price = $value->price;
			}
		}
		else { // caterer
			$price = $value->price_per_pax * $model->number_guests;
		}

		$img_src = "assets/img/products/" . Wedding::dressType($type, false, true) . "/{$id}.jpg"; // get the word 'dress' if it is a type of a dress, otherwise path won't work
		$img_src = file_exists($img_src) ? Yii::app()->request->baseUrl . "/" . $img_src : ("http://placehold.it/128/ffffff&text=" . strtoupper($type)); // load dummy image if the real one doesn't exist

		// Addresses for Google Maps
		if ($type === 'venue') {

			$temp = Venue::splitDescription($description);

			$description = "<strong>Capacity</strong>: {$value->capacity}<br>" . $temp['description'];
			$address = $temp['address'];
		}
	?>
		<tr>
			<td>
				<h4><?php echo $name; ?></h4>
				<ul class="unstyled product-description">
						<li><img src="<?php echo $img_src; ?>" width="128" height="128" alt="<?php echo $name; ?>"></li>
						<li><?php echo $description; ?></li>
				</ul>
			</td>
			<td class="price">
				<strong>$<?php echo $price; ?></strong>
			<?php if (intval($id) === $selectedId): ?>
				<button class="btn btn-mini btn-success disabled">Selected</button>
			<?php else: ?>
				<button class="btn btn-mini btn-info" value="<?php echo "$type//{$id}//{$name}//{$description}//{$price}" . (isset($address) ? "//{$address}" : ""); ?>" data-dismiss="modal">Choose</button>
			<?php endif; ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>