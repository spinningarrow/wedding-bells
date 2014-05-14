<div class="form">

<h2>Update Company 	<?php echo $model->id; ?></h2>
<?php
	$form = $this->beginWidget('bootstrap.widgets.BootActiveForm', array(
	    'id' => 'update-form',
	    'type' => 'horizontal',
	    'enableAjaxValidation' => false,
	    'enableClientValidation' => true,
	));
?>
<?php echo $form->textFieldRow($model, 'name'); ?>
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