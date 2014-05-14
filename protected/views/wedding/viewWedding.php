<?php
	$this->pageTitle = ucfirst($model->name) . ' « ' . Yii::app()->name;
?>

<?php $this->widget('bootstrap.widgets.BootAlert'); // Display alert messages, if any ?>
<h2><?php echo ucfirst($model->name); ?></h2>
<div class="row">
	<div class="span8">
		<p>We have selected the best choices according to your budget. You can edit the selections and see the updated cost of the wedding on the tab to your right.</p>
		<?php $form=$this->beginWidget('CActiveForm', array(
			'id' => 'wedding-form',
			'enableAjaxValidation' => false,
		)); ?>

		<?php 
			echo CHtml::errorSummary($model, '<div class="alert alert-error">', '</div>');
			echo $form->hiddenField($model, 'date');
		?>

		<?php foreach($data as $product_type => $product_details):

			// Get the address and description for venues
			if ($product_type === 'venue') {

				$temp = Venue::splitDescription($product_details['description']);

				$product_details['description'] = $temp['description'];
				$product_details['address'] = $temp['address'];
			}
		?>

		<h3><?php echo Wedding::dressType($product_type, true); ?></h3>
		<div id="<?php echo $product_type; ?>" class="row">
			<p class="span2"><img src="<?php echo Yii::app()->request->baseUrl . "/assets/img/products/" . Wedding::dressType($product_type, false, true) . "/{$product_details['id']}.jpg"; ?>" width="128" height="128" alt="<?php echo $product_details['name']; ?>"></p>
			<div class="span6">
				<h4 class="details-name"><?php echo $product_details['name']; ?></h4>
				<p><span class="details-description"><?php echo $product_details['description']; ?></span>
			<?php if ($product_type === "venue"): ?>
				<br><a id="venue-address" class="details-address" title="<?php echo $product_details['address']; ?>" rel="<?php echo $product_details['name'] ?>" data-toggle="modal" href="#maps-modal">View location on a map</a>.
			<?php endif; ?>
				</p>
				<p>Price: $<strong class="details-price"><?php echo $product_details['price']; ?></strong></p>
				
				<?php if ($model->type !== "thematic" && $model->scenario === "edit"): ?>
					<p><a id="<?php echo Wedding::dressType($product_type) . "//{$product_details['id']}"; ?>" class="btn btn-info products-modal" data-toggle="modal" href="#products-modal">Change</a></p>
					<?php echo $form->hiddenField($model, $product_type . '_id'); ?>
					<input type="hidden" class="price" id="<?php echo "{$product_type}_price"; ?>" value="<?php echo $product_details['price'] ?>">
				<?php endif; ?>

			</div>
		</div>

		<?php endforeach; ?>

		<!-- Form buttons (depending on specific scenario and wedding type) -->
		<?php if ((strtotime($model->date) - time()) > 14*24*60*60 && $model->status !== "confirmed"): ?>
			<div class="form-actions">
				<?php if ($model->scenario === "edit"): ?>
					<input class="btn btn-inverse btn-large" type="submit" name="submit" value="Save">
				<?php endif; ?>
				<?php /*else:*/

					// if () {

						if ($model->type === "thematic") {
							echo CHtml::link(
								'Change Theme',
								array('/wedding/thematicWedding', 'id' => $model->wedding_id),
								array('class' => 'btn btn-large btn-inverse')
							);
						}

						echo " ";
					
						echo CHtml::link(
							'Confirm and Proceed to Payment',
							array('/wedding/payment', 'id' => $model->wedding_id),
							array('class' => 'btn btn-large btn-primary payment-button')
						);
					// }
				// endif;
				?>
			</div>
		<?php endif; ?>

		<!-- Modal box for list of products -->
		<div class="modal fade" id="products-modal">
			<div class="modal-header">
				<a class="close" data-dismiss="modal">&times;</a>
				<h3>Choose a new venue</h3>
			</div>
			<div class="modal-body loading">
				<!-- <div class="select loading"> -->
					<!-- Ajax data goes here -->
				<!-- </div> -->
			</div>
		</div>

		<!-- Modal box for maps -->
		<div class="modal fade" id="maps-modal">
			<div class="modal-header">
				<a class="close" data-dismiss="modal">&times;</a>
				<h3>Venue location</h3>
			</div>
			<div class="modal-body">
				<div id="map" style="height: 400px;"></div>
			</div>
			<div class="modal-footer">
				<a id="get-directions" class="btn btn-primary" title="Driving directions from your current location to the destination">How do I get there?</a>
				<a id="get-map" class="btn btn-inverse" title="">Back to map</a>
			</div>
		</div>
	</div>

	<!-- Floating information sidebar -->
	<div class="sidebar well span2 offset1">
	
		<h3>Details</h3>
		
		<?php $days_left = floor((strtotime($model->date) - time())/(60*60*24));
			if ($days_left > 0): ?>
				<p class="label label-<?php echo ($days_left > 14 ? "info" : "important"); ?>"><?php echo "$days_left day(s) left"; ?></p>
		<?php elseif ($days_left == 0): ?>
			<p class="label label-warning">Today!</p>
		<?php else: ?>
			<p class="label">Finished!</p>
		<?php endif; ?>
		
		<p class="label label-inverse"><?php echo $model->number_guests; ?> guests</p>
	
		<?php if ($model->scenario === "edit"): ?>
			<h3>Your budget</h3>
			<p class="label">$<span id="budget"><?php echo $model->budget; ?></span></p>
		<?php endif; ?>
		
		<h3>Total cost</h3>
		<p class="label">$<span id="total-cost"><?php echo $total_cost; ?></span></p>

		<?php if ($model->scenario === "edit"): ?>
			<h3>Balance</h3>
			<p class="label"><span id="balance"></span></p>
		<?php endif; ?>	
	</div>
</div>

<?php $this->endWidget(); ?>

<?php

	// Include the Bootstrap Modal script at the end of the page
	Yii::app()->bootstrap->registerModal();

	// Include the Google Maps API script
	Yii::app()->clientScript->registerScriptFile('http://maps.google.com/maps/api/js?sensor=false', CClientScript::POS_END);

	$js_weddingId = "var wedding_id = $model->wedding_id; "; // because the nowdoc syntax used for scripts doesn't parse PHP (intentionally, so that nothing needs to be escaped)

$js_modal = <<<'SCRIPT'

// Scroll sidebar
// Source: http://css-tricks.com/scrollfollow-sidebar/
// Minor modifications made.
var scrollSidebar = function () {
    var $sidebar   = $(".well"),
        $window    = $(window),
        offset     = $sidebar.offset(),
        topPadding = 15;

    $window.scroll(function() {
        if ($window.scrollTop() > offset.top) {
            $sidebar.stop().animate({
                marginTop: $window.scrollTop() - offset.top + topPadding
            }, 'fast');
        } else {
            $sidebar.stop().animate({
                marginTop: 0
            }, 'fast');
        }
    });
}();

// Ajax options for products modal box
// Moved these from $.ajax to $.ajaxSetup because of subsequent calls queueing rather than
// replacing previous calls. That didn't help though. Original $.ajax was being called on
// modal's 'shown' event within the Change button's 'click' event, now it is being called
// directly from the click event. Hopefully works correctly now, though the loading icon
// doesn't show up for some reason.
jQuery.ajaxSetup({
	cache: true,
	async: true,
	url: 'index.php',
});

// Update the 'total cost' when any product is changed
$('.price').change(function () {

	var sum = 0;
	
	$('input.price').each(function () {
		sum += parseFloat($(this).attr('value'));
	});

	$('#total-cost').html(sum);

	var balance = parseFloat($('#budget').html()) - sum;
	if (balance < 0) {
		$('#balance')
			.html('-$' + Math.abs(balance))
			.parent().removeClass().addClass('label label-warning');
			//.find('i').removeClass().addClass('icon-white icon-exclamation-sign');
	}

	else {
		$('#balance')
			.html('$' + balance)
			.parent().removeClass().addClass('label label-success');
			//.find('i').removeClass().addClass('icon-white icon-ok-sign');
	}

	$('#total-cost').parent().fadeOut().fadeIn();
	$('#balance').parent().fadeOut().fadeIn();

}).first().change(); // trigger the 'change' event when the page is loaded

$('.price').change(function () { // for subsequent calls to change
	$('.payment-button')
		.addClass('disabled')
		.click(function (event) {
			event.preventDefault();
		});
});

// Change the heading of the products modal box depending on the button that invoked it and insert ajax data into it
$('a[href=#products-modal]').click(function (event) {
	
	var productDetails = event.target.id.split("//");

	// Because 'Choose a new bridesmaid' isn't exactly an appropriate title
	var title = $.inArray(productDetails[0], ['bride', 'groom', 'bridesmaid', 'groomsmen']) !== -1 ? 'dress' : productDetails[0];

	$('#products-modal').find('h3').html('Choose a new ' + title);

	$.ajax({
		data: {
			r: 'wedding/ajaxListProducts',
			id: wedding_id, // current wedding
			type: productDetails[0], // product type
			selected: productDetails[1] // currently selected product
		},

		success: function(data) {
			$('#products-modal')
				.find('.modal-body')
					.html(data)
					.removeClass('loading')
				
					// Toggle the description when the row is clicked (but not if the price or button is clicked)
			    	.find('.products-list tr td').not('.price').click(function () {
			    		//console.log($(this));
			    		$(this).parent().siblings().find('.product-description').hide(); // Hide any other visible description
			    		$(this).find('.product-description').fadeToggle('fast'); // Toggle the current description
			    	})

			    	// Hide product descriptions by default
				    .find('.product-description')
				    	.hide();

		    // Update the selected product information when the 'choose' button is clicked
		    $('#products-modal').find('button').not('.disabled').click(function () {
		    	var selectedDetails = $(this).attr('value').split('//');
		    	//var oldPrice = 
		    	
		    	$('#' + selectedDetails[0])
		    		.find('img')
			    		.attr('src', function (index, attr) { // update image source
			    			return attr.replace(/[0-9]+.(jpg|png)/, selectedDetails[1] + ".$1");
			    		})
			    		
			    		.attr('alt', selectedDetails[2]).end() // update image alt text with name
		    		
		    		.find('.details-name').html(selectedDetails[2]).end() // update name
			    	
			    	.find('.details-description').html(selectedDetails[3]).end() // update description
			    	
			    	.find('.details-price').html(function (index, oldPrice) { // update price
			    		$(this).html(selectedDetails[4]);
			    	}).end()

			    	.find('.btn').attr('id', selectedDetails[0] + '//' + selectedDetails[1]).end() // update  button's id (so that next time it is clicked, the right element is selected)
			    	
			    	.find('input[type=hidden]').not('.price').attr('value', selectedDetails[1]).end()
			    	
			    	.filter('.price').attr('value', selectedDetails[4]).change(); // fire 'change' event as it is not automatically fired but is required to compute the budget

			    if (selectedDetails[0] === 'venue') {
			    	$('#venue-address').attr('title', selectedDetails[5]);
			    }
		    });
		}
	});
});

// Modal box containing products list
$('#products-modal')
    .modal({
    	show : false
    })

    // Collapse any expanded product description when the modal box is closed
    .on('hidden', function () {
    	$(this).find('.product-description').hide();
    	$(this).find('.modal-body').html('').addClass('loading');
    });

// Display the map via ajax
$('a[href=#maps-modal]').click(function (event) {
	$('#maps-modal .modal-header h3').html('Venue location: ' + $(this).attr('rel'));
	
	var address = $(this).attr('title');
	$("#maps-modal #get-map").attr('title', address).hide();
});

// Bind the geolocation directions to the "directions" button's click event
// and toggle disabled states
$('#maps-modal #get-directions').click(function () {
	geolocationMap.initiate_geolocation();
	$(this).hide();
	$(this).siblings('#get-map').show();
});

// Bind the map display to the "map" button's click event
// and toggle disabled states
$('#maps-modal #get-map').click(function () {
	renderMap($(this).attr('title'));
	$(this).hide();
	$(this).siblings('#get-directions').show();
});

// Modal box containing venue map
$('#maps-modal')
	.modal({
		show: false
	})

	.on('shown', function () {
		$('#maps-modal #get-map').click();
	})

	.on('hidden', function () {
		$(this).find('.modal-body').html('<div id="map" style="height: 400px;"></div>');
	});

SCRIPT;

	Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/assets/js/googlemaps.js', CClientScript::POS_END);

	// Include on $(document).ready
	Yii::app()->clientScript->registerScript('editWedding.modal', $js_weddingId . $js_modal, CClientScript::POS_READY);
?>