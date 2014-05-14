<?php
$this->pageTitle=Yii::app()->name . ' - Password Reset';?>


<h2>Password Reset</h2>
<?php
	$form = $this->beginWidget('bootstrap.widgets.BootActiveForm', array(
	    'id' => 'reset-form',
	    'type' => 'horizontal',
	    'enableAjaxValidation' => false,
	    'enableClientValidation' => true,
	));
?>

<?php echo $form->passwordFieldRow($model, 'password'); ?>
<?php echo $form->passwordFieldRow($model, 'cpassword'); ?>

<div class="form-actions">
    <?php echo CHtml::htmlButton('Submit', array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
</div>

<?php $this->endWidget(); ?>