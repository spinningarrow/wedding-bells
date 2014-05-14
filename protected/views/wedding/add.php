<?php
$this->pageTitle=Yii::app()->name . ' - Add a Wedding';
?>

<h2>Add a Wedding</h2>
<!-- <p><strong>Please note:</strong></p>
<ul class="unstyled">
	<li>Weddings must be confirmed atleast 14 days in advance.</li>
	<li>In case you add your wedding a year ahead (but do not confirm it), please note that the products are subject to change.</li>
	<li>It is recommended that you confirm your wedding within 7 days of adding it.</li>	
</ul> -->
<p>Add a new wedding to your profile. You may add as many weddings as you wish.</p>

<!-- Form -->
<?php
	$form = $this->beginWidget('bootstrap.widgets.BootActiveForm', array(
	    'id' => 'add-wedding-form',
	    'type' => 'horizontal',
	    'enableAjaxValidation' => false, // setting to true apparently insert two rows in the database -.-
	    'enableClientValidation' => true,
	    'htmlOptions' => array('class' => 'add-wedding-form'),
	));
?>

	<?php // echo CHtml::errorSummary($model); ?> 

	<?php echo $form->textFieldRow($model, 'name', array('hint' => 'Give your wedding a name', 'class' => 'span3', 'autofocus' => 'true')); ?>

	<?php echo $form->textFieldRow($model, 'date', array('placeholder' => 'YYYY/MM/DD', 'class' => 'input-medium datepicker'/*, 'append' => '<i class="icon-calendar"></i>'*/)); ?>

	<?php echo $form->textFieldRow($model, 'number_guests', array('hint' => 'The number of guests can be between 25 and 700', 'class' => 'span1')); ?>

	<!-- <div class="form-actions"> -->
	<div class="row add-wedding">

	    <button class="span4 btn btn-inverse btn-wedding-type" type="submit" name="submit-thematic" rel="popover" title="Thematic Wedding" data-content="Thematic weddings let you choose from our wide range of themes and packages">I want a <strong>Thematic Wedding</strong></button>

	    <button class="span4 btn btn-primary btn-wedding-type" type="submit" name="submit-custom" rel="popover" title="Custom Wedding" data-content="Be your own planner and customize your wedding while we assign you the best products within your budget">I want a <strong>Custom Wedding</strong></button>
	</div>

<?php $this->endWidget(); ?>

<?php /* JavaScript */

$start_date = date("Y/m/d", time() + ((14 + 1) * 60 * 60 * 24));
$end_date = date("Y/m/d", time() + ((365 + 1) * 60 * 60 * 24));

$phpjs = "var start_date = '$start_date'; var end_date = '$end_date';";

$js = <<<'SCRIPT'

	$('.datepicker').datepicker({
		// startView: 'year',
		format: 'yyyy/mm/dd',
		weekStart: 1,
		startDate: start_date,
		endDate: end_date
	});

	$('.add-wedding button').popover({
		placement: 'top'
	});

SCRIPT;

	// Include on $(document).ready
	Yii::app()->clientScript->registerScript('add.js', $phpjs . $js, CClientScript::POS_READY);

	// Include the datepicker script at the end of the page
	Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/assets/js/bootstrap-datepicker.js', CClientScript::POS_END);

	// Register tooltip and popover
	Yii::app()->bootstrap->registerPopover();
?>