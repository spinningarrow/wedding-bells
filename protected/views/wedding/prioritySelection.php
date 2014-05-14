<?php
$this->pageTitle=Yii::app()->name . ' - Add a Wedding - Budget and Priorities Selection';
$this->breadcrumbs=array(
	'Weddings','Add a Wedding',
);
?>

<h2>Budget and Priorities Selection</h2>
<p>Please enter your budget specification and priority of feature (for example, give a <strong>high</strong> priority to an essential feature).<br>
	You are required to choose <strong>at least one</strong> feature.</p>

<?php
	$form = $this->beginWidget('bootstrap.widgets.BootActiveForm', array(
	    'id' => 'budget-priorities-form',
	    'type' => 'horizontal',
	    'enableAjaxValidation' => false,
	    'enableClientValidation' => true,
	));
?>

<?php echo $form->textFieldRow($model, 'budget', array('hint' => '', 'autofocus' => true)); ?>

<?php
	// Radio buttons for the priorities 
	// This is what is actually submitted to the server.
	// The drag and drop functionality manipulates these via JavaScript after hiding this whole section.
?>
<fieldset id="priority-choices">
	<legend>Choose Priorites</legend>
	<?php echo $form->radioButtonListInlineRow($model, 'venue_priority', array('Low', 'Medium', 'High')); ?>
	<?php echo $form->radioButtonListInlineRow($model, 'caterer_priority', array('Low', 'Medium', 'High')); ?>
	<?php echo $form->radioButtonListInlineRow($model, 'photographer_priority', array('Low', 'Medium', 'High')); ?>
	<?php echo $form->radioButtonListInlineRow($model, 'music_priority', array('Low', 'Medium', 'High')); ?>
	<?php echo $form->radioButtonListInlineRow($model, 'decor_priority', array('Low', 'Medium', 'High')); ?>
	<?php echo $form->radioButtonListInlineRow($model, 'dress_priority', array('Low', 'Medium', 'High')); ?>
	<!--<?php echo $form->radioButtonListInlineRow($model, 'invitation_priority', array('Low', 'Medium', 'High')); ?>-->
	<?php echo $form->radioButtonListInlineRow($model, 'cake_priority', array('Low', 'Medium', 'High')); ?>
</fieldset>

<fieldset id="priority-boxes">
	<legend>Choose priorities for the products you want at your wedding</legend>
	<br>
	<p> You can drag a particular feature from the list of features and drop it into the desired priority box. If you do not need a particular feature you need not add the feature to any of the priority boxes. However, you are required to add at least one feature to your wedding.</p>
	<div id="products" class="span12 row draggable-list">
		<ul class="unstyled span8">
			<li>Venue</li>
			<li>Caterer</li>
			<li>Photographer</li>
			<li>Music</li>
			<li>Decor</li>
			<li>Dress</li>
			<li>Cake</li>
		</ul>
		<p class="span3">Drag here to <strong>remove</strong> the item from the selection.</p>
	</div>

	<div class="row"></div> <!-- clear -->

	<div class="row">
		<div id="priority-high" class="priority-well span3 well">
			<h4>High Priority</h4>
			<p>Drag here to assign <strong>high</strong> priority to this item.</p>
		</div>
		<div id="priority-medium" class="priority-well span3 well">
			<h4>Medium Priority</h4>
			<p>Drag here to assign <strong>medium</strong> priority to this item.</p>
		</div>
		<div id="priority-low" class="priority-well span3 well">
			<h4>Low Priority</h4>
			<p>Drag here to assign <strong>low </strong>priority to this item.</p>
		</div>
	</div>

	<!-- Display when Dress is given a priority -->
	<div id="dress-details" class="span8 well form-inline">
		<label>Enter the number of dresses required for groomsmen and bridesmaids</label>
		<?php echo CHtml::activeTextField($model, 'number_groomsmen', array('class' => 'input-small', 'placeholder' => 'Groomsmen', 'value' => '')); ?>
		<?php echo CHtml::activeTextField($model, 'number_bridesmaid', array('class' => 'input-small', 'placeholder' => 'Bridesmaids', 'value' => '')); ?>
	</div>
</fieldset> 

<?php echo CHtml::htmlButton('Next', array('class'=>'btn btn-primary btn-large', 'type' => 'submit')); ?> 
<?php echo CHtml::htmlButton('Reset', array('class'=>'btn btn-inverse btn-large', 'type' => 'reset', 'id' => 'reset-everything')); ?>

<?php $this->endWidget(); ?>

<?php

// Script to manage all the drag and drop magic
// Largely an edited version of the 'Simple photo manager' from the Droppable demo on the jQuery UI site
$js_priorities = <<<'SCRIPT'

	// Hide radio buttons and dress-related form text fields
	$('#priority-choices').hide();
	$('#dress-details').hide();

	// Used later when toggling the radio buttons for getting the correct priority
	// NOTE: The order of elements *must* be the same as that in which the radio button groups are
	// displayed using php
	var productsArray = ['venue', 'caterer', 'photographer', 'music', 'decor', 'dress', 'cake'];
	var prioritiesArray = ['priority-low', 'priority-medium', 'priority-high'];

	var $productsList = $("#products");
	var $priorityWells = $('.priority-well');

	// Let the products items be draggable
	var draggableOptions = { // so that options can be reused when the form is reset

		revert: "invalid", // when not dropped, the item will revert back to its initial position
		containment: $( "#budget-priorities-form" ).length ? "#budget-priorities-form" : "document", // stick to budget-priorities-form if present
		helper: "clone",
		cursor: "move",
	};

	$("li", $productsList).draggable(draggableOptions); // bind draggable to the list items

	// Let the priority-wells be droppable, accepting the product items
	$priorityWells.droppable({

		accept: "#products li, .priority-well li",
		activeClass: "active",
		hoverClass: 'hover',

		over: function (event, ui) {
			$(this).find('p').show(); // toggle message display
		},

		out: function (event, ui) {
			$(this).find('p').hide(); // toggle message display
		},

		drop: function(event, ui) {

			$(this).find('p').hide(); // make sure the message is not visible
			
			dragToWell(ui.draggable, $(this));

			var droppedItem = ui.draggable.html().toLowerCase(); // so that we can check which item was dropped

			if (droppedItem === 'dress') { // display extra form fields if Dress is selected
				$('#dress-details').fadeIn('fast', function () {
					$(this).find('input').eq(0).focus();
				});
			}

			// Get the index of the item and the well
			var productIndex = $.inArray(droppedItem, productsArray);
			var priorityIndex = $.inArray($(this).attr('id'), prioritiesArray);
			
			// Select the radio button using to the indices above
			$('#priority-choices .controls').eq(productIndex).find('input[type=radio]').eq(priorityIndex).prop('checked', true);
			
			// Un-highlight the wells that the item was not dropped to
			$priorityWells.removeClass('highlight');
		}
	});

	// Let the products list be droppable as well, accepting items from the priority wells
	$productsList.droppable({

		accept: ".priority-well li",
		activeClass: "active",
		hoverClass: 'hover',

		over: function (event, ui) {
			$(this).find('p').show(); // toggle message display
		},

		out: function (event, ui) {
			$(this).find('p').hide(); // toggle message display
		},

		drop: function(event, ui) {

			$(this).find('p').hide(); // make sure the message is not visible
			
			dragToProducts(ui.draggable);

			var droppedItem = ui.draggable.html().toLowerCase(); // so that we can check which item was dropped

			if (droppedItem === 'dress') {
				$('#dress-details').fadeOut('fast'); // hide extra form fields if Dress is deselected
			}

			// Get the index of the item
			var productIndex = $.inArray(droppedItem, productsArray);

			// Deselect the radio button using the index above
			$('#priority-choices .controls').eq(productIndex).find('input[type=radio]:checked').prop('checked', false);
		}
	});

	// Handle dragging to priority wells
	function dragToWell(item, context) {
		item.hide(0, function() {
			var $list = $("ul", context).length ? $( "ul", context) : $( "<ul class='draggable-list ui-helper-reset'/>" ).appendTo(context);
			item
				.appendTo($list)
				.effect('highlight', { color: '#f9faf8' }, 200);
		});
	}

	// Handle dragging to products list
	function dragToProducts($item) {
		$item.hide(0, function() {
			$item
				.appendTo($('ul', $productsList))
				.effect('highlight', { color: '#f9faf8' }, 200);
		});
	}

	// Handle resetting the drag and drop elements
	$('#reset-everything').click(function () {
		
		$('.priority-well').each(function () {
			if ($(this).find('ul li').length) {
				$(this).find('ul li').detach(); // [remove() may not work correctly]
			}
		});

		$('#products').find('ul')
			.find('li').remove().end() // remove any remaining list items
			.append('<li>Venue</li><li>Caterer</li><li>Photographer</li><li>Music</li><li>Decor</li><li>Dress</li><li>Cake</li>'); // insert all the list items
		$("li", $productsList).draggable(draggableOptions); // bind draggable again, nothing else worked

		$('#dress-details').hide(); // make sure extra dress-related form fields are hidden
	});

SCRIPT;

	// Register scripts
	Yii::app()->clientScript->registerScriptFile('https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js', CClientScript::POS_END);
	Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/assets/js/jquery.ui.touch-punch.min.js', CClientScript::POS_END);

	// Include on document ready
	Yii::app()->clientScript->registerScript('prioritySelection.priorities', $js_priorities, CClientScript::POS_READY);

?>