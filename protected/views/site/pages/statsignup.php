<?php
$this->pageTitle=Yii::app()->name . ' - Choose Sign Up';
?>

<h2>Sign Up</h2>
<!-- <div class="row" id="add-wedding"> -->
	<!-- <div class="span5 box"> -->
	<!-- <div class="span5">
		<p><strong>Sign Up as a Customer:</strong><br><br><i>By signing up as a customer, you can plan your own weddings by selecting from our wide range of features.</i><br>
		<?php
			$form = $this->beginWidget('bootstrap.widgets.BootActiveForm', array(
			    'id' => 'add-thematic-form',
			    'type' => 'horizontal',
			    'enableAjaxValidation' => false, // setting to true apparently insert two rows in the database -.-
			    'enableClientValidation' => false,
			    'htmlOptions' => array('class' => 'add-wedding-form'),
			));
		?>

		<div class="form-actions">
			<?php echo CHtml::Button ('Sign Up as Customer', array('class'=>'btn btn-primary btn-large', 'submit' => array('site/signup'))); ?>
		</div>	
		<?php $this->endWidget(); ?>
	</div> -->

<div class="row signup">
	<div class="span5 customer">

		<!-- <?php /*echo CHtml::htmlButton('Sign Up as a Customer', array(
			'class' => 'span4 btn btn-primary btn-fat', 
			'rel' => 'popover', 
			'title' => 'Sign Up as a Customer',
			'submit' => array('site/signup')));*/ ?> -->

		<h3 class="span4"><?php echo CHtml::link('Sign Up as a Customer', array('site/signup')); ?></h3>

		<p class="span4">By signing up as a customer, you can plan your own weddings by selecting from our wide range of features.</p>
	</div>

	<div class="span5 company">
		<h3 class="span4"><?php echo CHtml::link('Sign Up as a Company', array('site/Csignup')); ?></h3>
		<p class="span4">By signing up as a company, you can list your products and services for customers to choose from.</p>
	</div>
</div>

	<!-- <div class="span5 box">	
		<p class="choice-box"><strong>Sign Up as a Company:</strong> <br><br><i>By signing up as a company, you can list your products and services for customers to choose from.</i><br>
		<?php
			$form = $this->beginWidget('bootstrap.widgets.BootActiveForm', array(
			    'id' => 'add-thematic-form',
			    'type' => 'horizontal',
			    'enableAjaxValidation' => false, // setting to true apparently insert two rows in the database -.-
			    'enableClientValidation' => false,
			    'htmlOptions' => array('class' => 'add-wedding-form'),
			));
		?>
		
		<div class="form-actions">
		    <?php echo CHtml::htmlButton ('Sign Up as Company', array('class'=>'btn btn-primary btn-large', 'submit' => array('site/Csignup'))); ?>
		</div>	
		<?php $this->endWidget(); ?>

		<p><h3>^ Increase size of both buttons </h3></p>
	</div> -->

<?php /* JavaScript */

$js = <<<'SCRIPT'

	$('.signup div').click(function () {
		$(this).find('a').click();
		// console.log($(this).find('a').click());
	});

	$('.signup div a').click(function (event) {
		event.stopPropagation();
		window.location = $(this).attr('href');
	});

SCRIPT;

	// Include on $(document).ready
	Yii::app()->clientScript->registerScript('add.js', $js, CClientScript::POS_READY);

	// Register tooltip and popover
	Yii::app()->bootstrap->registerPopover();
?>