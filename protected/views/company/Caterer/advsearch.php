		<div class="form">
	<?php
		$form = $this->beginWidget('bootstrap.widgets.BootActiveForm', array(
			'id' => 'update-form',
			'type' => 'horizontal',
			'enableAjaxValidation' => false,
			'enableClientValidation' => false,	    
		));

	?>

	<?php echo $form->textFieldRow($model, 'id'); ?>
	<?php echo $form->textFieldRow($model, 'name'); ?>
	<?php echo $form->textFieldRow($model, 'cuisine'); ?>
	<?php echo $form->textFieldRow($model, 'number_of_courses'); ?>
	<?php echo $form->textFieldRow($model, 'price_per_pax'); ?>
	<?php echo $form->textFieldRow($model, 'min_pax'); ?>
	<?php echo $form->textFieldRow($model, 'description'); ?>
	<?php echo $form->textFieldRow($model, 'status'); ?>

	<div class="form-actions">
		<?php echo CHtml::htmlButton('Submit', array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
		<?php echo CHtml::htmlButton('Reset', array('class'=>'btn btn-warning', 'type'=>'reset')); ?>
	</div>


	<?php $this->endWidget(); ?>

	</div><!-- form -->