<div class="form">
<?php $form=$this->beginWidget('CActiveForm');
?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>
	<?php echo $form->errorSummary($model); ?>
<div class="compactRadioGroup">
		<?php echo $form->labelEx($model,'budget'); ?>
		<?php echo $form->textField($model,'budget',array('size'=>60,'maxlength'=>80)); ?>
		<?php echo $form->error($model,'budget'); ?>
	</div>

	<div class="compactRadioGroup">
		<?php echo $form->labelEx($model,'venue_priority'); ?>
		<?php echo $form->radioButtonList($model,'venue_priority',array('Low','Medium','High')); ?>
		<?php echo $form->error($model,'venue_priority'); ?>
	
<div class="compactRadioGroup">
		<?php echo $form->labelEx($model,'caterer_priority'); ?>
		<?php echo $form->radioButtonList($model,'caterer_priority',array('Low','Medium','High')); ?>
		<?php echo $form->error($model,'caterer_priority'); ?>
	</div>

	<div class="compactRadioGroup">
		<?php echo $form->labelEx($model,'photographer_priority'); ?>
		<?php echo $form->radioButtonList($model,'photographer_priority',array('Low','Medium','High')); ?>
		<?php echo $form->error($model,'photographer_priority'); ?>
	</div>

	<div class="compactRadioGroup">
		<?php echo $form->labelEx($model,'music_priority'); ?>
		<?php echo $form->radioButtonList($model,'music_priority',array('Low','Medium','High')); ?>
		<?php echo $form->error($model,'music_priority'); ?>
	</div>

	<div class="compactRadioGroup">
		<?php echo $form->labelEx($model,'decor_priority'); ?>
		<?php echo $form->radioButtonList($model,'decor_priority',array('Low','Medium','High')); ?>
		<?php echo $form->error($model,'decor_priority'); ?>
	</div>


	<div class="compactRadioGroup">
		<?php echo $form->labelEx($model,'cake_priority'); ?>
		<?php echo $form->radioButtonList($model,'cake_priority',array('Low','Medium','High')); ?>
		<?php echo $form->error($model,'cake_priority'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Submit'); ?>
	</div>
<?php $this->endWidget(); ?>

</div><!-- form -->