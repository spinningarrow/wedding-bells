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
<?php echo $form->dropDownListRow($model, 'category',array(''=>'Any','venue'=>'Venue','caterer'=>'Caterer','photographer'=>'Photographer','music'=>'Music','dress'=>'Dress','decor'=>'Decor','cake'=>'Cake')); ?>
<?php echo $form->textFieldRow($model, 'email_id'); ?>
<?php echo $form->textFieldRow($model, 'address'); ?>
<?php echo $form->textFieldRow($model, 'pincode'); ?>
<?php echo $form->textFieldRow($model, 'country'); ?>
<?php echo $form->textFieldRow($model, 'phone'); ?>

<div class="form-actions">
    <?php echo CHtml::htmlButton('Submit', array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
    <?php echo CHtml::htmlButton('Reset', array('class'=>'btn btn-warning', 'type'=>'reset')); ?>
</div>


<?php $this->endWidget(); ?>

</div><!-- form -->