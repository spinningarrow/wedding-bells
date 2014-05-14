<div class="form">
<?php
	$form = $this->beginWidget('bootstrap.widgets.BootActiveForm', array(
	    'id' => 'update-form',
	    'type' => 'horizontal',
	    'enableAjaxValidation' => false,
	    'enableClientValidation' => true,	
	    'htmlOptions'=>array('enctype'=>'multipart/form-data'),    
	));

?>
<?php echo $form->textFieldRow($model, 'name'); ?>
<?php echo $form->dropDownListRow($model, 'category',array('beach'=>'Beach','Park'=>'Park','hall'=>'Hall','boat'=>'Boat','indoor'=>'Indoor','outdoor'=>'Outdoor')); ?>
<?php echo $form->textFieldRow($model, 'capacity'); ?>
<?php echo $form->textFieldRow($model, 'price'); ?>
<?php echo $form->textAreaRow($model, 'description'); ?>
<?php echo $form->dropDownListRow($model, 'status',array('enabled'=>'Enabled','disabled'=>'Disabled')); ?>
<?php echo $form->fileFieldRow($image, 'image'); ?>
<div class="form-actions">
    <?php echo CHtml::htmlButton('Submit', array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
    <?php echo CHtml::htmlButton('Reset', array('class'=>'btn btn-warning', 'type'=>'reset')); ?>
</div>


<?php $this->endWidget(); ?>
</div><!-- form -->