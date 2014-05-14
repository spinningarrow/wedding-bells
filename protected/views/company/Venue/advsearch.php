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
<?php echo $form->dropDownListRow($model, 'category',array(''=>'Any','beach'=>'Beach','park'=>'Park','hall'=>'Hall','boat'=>'Boat','indoor'=>'Indoor','ourdoor'=>'Outdoor')); ?>
<?php echo $form->textFieldRow($model, 'capacity'); ?>
<?php echo $form->textFieldRow($model, 'price'); ?>
<?php echo $form->textFieldRow($model, 'description'); ?>
<?php echo $form->textFieldRow($model, 'status'); ?>

<div class="form-actions">
    <?php echo CHtml::htmlButton('Submit', array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
    <?php echo CHtml::htmlButton('Reset', array('class'=>'btn btn-warning', 'type'=>'reset')); ?>
</div>


<?php $this->endWidget(); ?>

</div><!-- form -->