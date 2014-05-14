<div class="form">

<h2>Edit Your Profile</h2>
<?php
	$form = $this->beginWidget('bootstrap.widgets.BootActiveForm', array(
	    'id' => 'update-form',
	    'type' => 'horizontal',
	    'enableAjaxValidation' => false,
	    'enableClientValidation' => true,
	))
?>

<?php echo $form->textFieldRow($model, 'first_name'); ?>
<?php echo $form->textFieldRow($model, 'last_name'); ?>
<?php echo $form->textFieldRow($user, 'username', array('disabled'=>true)); //have to get email_id from user table?> 
<?php echo $form->textFieldRow($model, 'phone'); ?>

<div class="form-actions">
    <?php echo CHtml::htmlButton('Submit', array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
    <?php echo CHtml::htmlButton('Reset', array('class'=>'btn btn-warning', 'type'=>'reset')); ?>
</div>


<?php $this->endWidget(); ?>

</div><!-- form -->