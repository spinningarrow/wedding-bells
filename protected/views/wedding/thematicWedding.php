<?php
	$this->pageTitle=Yii::app()->name . ' - ' . (($model->status === 'created') ? "Choose a " : "Change ") . ' Theme';
	$theme_index = 0;
?>
<h2><?php echo ($model->status === 'created') ? "Choose a " : "Change "; ?>theme: <?php echo $model->name; ?></h2>
<p>Choose from the following four themes and enjoy our finest choices for cuisine, music, photography, decorations, venue and dresses which are perfectly in sync with the theme. You are welcome to select from our platinum, gold or silver packages.<br></p>

<form name="thematic-wedding" id="thematic-wedding" class="row">

	<div class="classic span3" data-title="Classic" data-content="Our quaint, romantic, historical chapel will make the most important day of your lives a stylish and memorable event. The elegant music, classic floral decorations and tasty gourmet recipes will definitely mirror age old traditions and make this day memorable for the rest of your lives.">
		<h3>Classic</h3>
		<p class="row">
			<a href="<?php echo CController::createUrl('wedding/thematicWedding', array('id' => $model->wedding_id, 'choice' => 1)); ?>" class="btn btn-platinum span2">Platinum: <strong>$<?php echo number_format($prices[$theme_index++]); ?></strong></a>
		</p>
		<p class="row">
			<a href="<?php echo CController::createUrl('wedding/thematicWedding', array('id' => $model->wedding_id, 'choice' => 2)); ?>" class="btn btn-gold span2">Gold: <strong>$<?php echo number_format($prices[$theme_index++]); ?></strong></a>
		</p>
		<p class="row">
			<a href="<?php echo CController::createUrl('wedding/thematicWedding', array('id' => $model->wedding_id, 'choice' => 3)); ?>" class="btn btn-silver span2">Silver: <strong>$<?php echo number_format($prices[$theme_index++]); ?></strong></a>
		</p>
	</div>

	<div class="royal span3" data-title="Royal" data-content="Have the grand wedding you have always dreamed of! With exquisite floral decorations, amazing music accompanied by mouthwatering gourmet food, this wedding is guaranteed to be a royal affair for your friends and family and make your wedding even better than the dream!">
		<h3>Royal</h3>
		<p class="row">
			<a href="<?php echo CController::createUrl('wedding/thematicWedding', array('id' => $model->wedding_id, 'choice' => 4)); ?>" class="btn btn-platinum span2">Platinum: <strong>$<?php echo number_format($prices[$theme_index++]); ?></strong></a>
		</p>
		<p class="row">
			<a href="<?php echo CController::createUrl('wedding/thematicWedding', array('id' => $model->wedding_id, 'choice' => 5)); ?>" class="btn btn-gold span2">Gold: <strong>$<?php echo number_format($prices[$theme_index++]); ?></strong></a>
		</p>
		<p class="row">
			<a href="<?php echo CController::createUrl('wedding/thematicWedding', array('id' => $model->wedding_id, 'choice' => 6)); ?>" class="btn btn-silver span2">Silver: <strong>$<?php echo number_format($prices[$theme_index++]); ?></strong></a>
		</p>
	</div>

	<div class="beach span3" data-title="Beach" data-content="Have the Caribbean wedding you always dreamed of in the most romantic places on earth! The spirit of an exotic island wedding melds with the unparalled pleasures along the all-inclusive romantic music, delicious gourmet buffet and magnificent flowers and decorations at the beach.">
		<h3>Beach</h3>
		<p class="row">
			<a href="<?php echo CController::createUrl('wedding/thematicWedding', array('id' => $model->wedding_id, 'choice' => 7)); ?>" class="btn btn-platinum span2">Platinum: <strong>$<?php echo number_format($prices[$theme_index++]); ?></strong></a>
		</p>
		<p class="row">
			<a href="<?php echo CController::createUrl('wedding/thematicWedding', array('id' => $model->wedding_id, 'choice' => 8)); ?>" class="btn btn-gold span2">Gold: <strong>$<?php echo number_format($prices[$theme_index++]); ?></strong></a>
		</p>
		<p class="row">
			<a href="<?php echo CController::createUrl('wedding/thematicWedding', array('id' => $model->wedding_id, 'choice' => 9)); ?>" class="btn btn-silver span2">Silver: <strong>$<?php echo number_format($prices[$theme_index++]); ?></strong></a>
		</p>
	</div>

	<div class="yacht span3" data-title="Yacht" data-content="Imagine the wedding of your dreams aboard one of Singapore's most romantic yachts. Set sail under the Singapore sun or the incredible, starry night sky with the Pacific Ocean as your backdrop.">
		<h3>Yacht</h3>
		<p class="row">
			<a href="<?php echo CController::createUrl('wedding/thematicWedding', array('id' => $model->wedding_id, 'choice' => 10)); ?>" class="btn btn-platinum span2">Platinum: <strong>$<?php echo number_format($prices[$theme_index++]); ?></strong></a>
		</p>
		<p class="row">
			<a href="<?php echo CController::createUrl('wedding/thematicWedding', array('id' => $model->wedding_id, 'choice' => 11)); ?>" class="btn btn-gold span2">Gold: <strong>$<?php echo number_format($prices[$theme_index++]); ?></strong></a>
		</p>
		<p class="row">
			<a href="<?php echo CController::createUrl('wedding/thematicWedding', array('id' => $model->wedding_id, 'choice' => 12)); ?>" class="btn btn-silver span2">Silver: <strong>$<?php echo number_format($prices[$theme_index++]); ?></strong></a>
		</p>
	</div>

</form>

<?php /* JavaScript */

$js = <<<'SCRIPT'

	$('.classic, .royal').popover({
		placement: 'right'
	});

	$('.beach, .yacht').popover({
		placement: 'left'
	});

SCRIPT;

	// Register tooltip and popover
	Yii::app()->bootstrap->registerPopover();

	// Include on $(document).ready
	Yii::app()->clientScript->registerScript('add.js', $js, CClientScript::POS_READY);
?>