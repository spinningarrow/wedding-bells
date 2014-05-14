<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'wedding_id'); ?>
		<?php echo $form->textField($model,'wedding_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'customer_id'); ?>
		<?php echo $form->textField($model,'customer_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>80)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'date'); ?>
		<?php echo $form->textField($model,'date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'number_guests'); ?>
		<?php echo $form->textField($model,'number_guests'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'number_groomsmen'); ?>
		<?php echo $form->textField($model,'number_groomsmen'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'number_bridesmaid'); ?>
		<?php echo $form->textField($model,'number_bridesmaid'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'venue_id'); ?>
		<?php echo $form->textField($model,'venue_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'caterer_id'); ?>
		<?php echo $form->textField($model,'caterer_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'photographer_id'); ?>
		<?php echo $form->textField($model,'photographer_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'music_id'); ?>
		<?php echo $form->textField($model,'music_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'decor_id'); ?>
		<?php echo $form->textField($model,'decor_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'invitation_id'); ?>
		<?php echo $form->textField($model,'invitation_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'cake_id'); ?>
		<?php echo $form->textField($model,'cake_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'bride_id'); ?>
		<?php echo $form->textField($model,'bride_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'groom_id'); ?>
		<?php echo $form->textField($model,'groom_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'bridesmaid_id'); ?>
		<?php echo $form->textField($model,'bridesmaid_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'groomsmen_id'); ?>
		<?php echo $form->textField($model,'groomsmen_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'status'); ?>
		<?php echo $form->textField($model,'status',array('size'=>9,'maxlength'=>9)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'budget'); ?>
		<?php echo $form->textField($model,'budget'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'venue_priority'); ?>
		<?php echo $form->textField($model,'venue_priority'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'caterer_priority'); ?>
		<?php echo $form->textField($model,'caterer_priority'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'photographer_priority'); ?>
		<?php echo $form->textField($model,'photographer_priority'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'music_priority'); ?>
		<?php echo $form->textField($model,'music_priority'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'decor_priority'); ?>
		<?php echo $form->textField($model,'decor_priority'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'dress_priority'); ?>
		<?php echo $form->textField($model,'dress_priority'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'invitation_priority'); ?>
		<?php echo $form->textField($model,'invitation_priority'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'cake_priority'); ?>
		<?php echo $form->textField($model,'cake_priority'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->