<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'wedding-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'customer_id'); ?>
		<?php echo $form->textField($model,'customer_id'); ?>
		<?php echo $form->error($model,'customer_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>80)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'date'); ?>
		<?php echo $form->textField($model,'date'); ?>
		<?php echo $form->error($model,'date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'number_guests'); ?>
		<?php echo $form->textField($model,'number_guests'); ?>
		<?php echo $form->error($model,'number_guests'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'number_groomsmen'); ?>
		<?php echo $form->textField($model,'number_groomsmen'); ?>
		<?php echo $form->error($model,'number_groomsmen'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'number_bridesmaid'); ?>
		<?php echo $form->textField($model,'number_bridesmaid'); ?>
		<?php echo $form->error($model,'number_bridesmaid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'venue_id'); ?>
		<?php echo $form->textField($model,'venue_id'); ?>
		<?php echo $form->error($model,'venue_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'caterer_id'); ?>
		<?php echo $form->textField($model,'caterer_id'); ?>
		<?php echo $form->error($model,'caterer_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'photographer_id'); ?>
		<?php echo $form->textField($model,'photographer_id'); ?>
		<?php echo $form->error($model,'photographer_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'music_id'); ?>
		<?php echo $form->textField($model,'music_id'); ?>
		<?php echo $form->error($model,'music_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'decor_id'); ?>
		<?php echo $form->textField($model,'decor_id'); ?>
		<?php echo $form->error($model,'decor_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'invitation_id'); ?>
		<?php echo $form->textField($model,'invitation_id'); ?>
		<?php echo $form->error($model,'invitation_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'cake_id'); ?>
		<?php echo $form->textField($model,'cake_id'); ?>
		<?php echo $form->error($model,'cake_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'bride_id'); ?>
		<?php echo $form->textField($model,'bride_id'); ?>
		<?php echo $form->error($model,'bride_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'groom_id'); ?>
		<?php echo $form->textField($model,'groom_id'); ?>
		<?php echo $form->error($model,'groom_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'bridesmaid_id'); ?>
		<?php echo $form->textField($model,'bridesmaid_id'); ?>
		<?php echo $form->error($model,'bridesmaid_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'groomsmen_id'); ?>
		<?php echo $form->textField($model,'groomsmen_id'); ?>
		<?php echo $form->error($model,'groomsmen_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->textField($model,'status',array('size'=>9,'maxlength'=>9)); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'budget'); ?>
		<?php echo $form->textField($model,'budget'); ?>
		<?php echo $form->error($model,'budget'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'venue_priority'); ?>
		<?php echo $form->textField($model,'venue_priority'); ?>
		<?php echo $form->error($model,'venue_priority'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'caterer_priority'); ?>
		<?php echo $form->textField($model,'caterer_priority'); ?>
		<?php echo $form->error($model,'caterer_priority'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'photographer_priority'); ?>
		<?php echo $form->textField($model,'photographer_priority'); ?>
		<?php echo $form->error($model,'photographer_priority'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'music_priority'); ?>
		<?php echo $form->textField($model,'music_priority'); ?>
		<?php echo $form->error($model,'music_priority'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'decor_priority'); ?>
		<?php echo $form->textField($model,'decor_priority'); ?>
		<?php echo $form->error($model,'decor_priority'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'dress_priority'); ?>
		<?php echo $form->textField($model,'dress_priority'); ?>
		<?php echo $form->error($model,'dress_priority'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'invitation_priority'); ?>
		<?php echo $form->textField($model,'invitation_priority'); ?>
		<?php echo $form->error($model,'invitation_priority'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'cake_priority'); ?>
		<?php echo $form->textField($model,'cake_priority'); ?>
		<?php echo $form->error($model,'cake_priority'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->