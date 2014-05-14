<?php
$this->pageTitle=Yii::app()->name . ' - Forgot Password';?>


<h2>Password Reset</h2>
<?php
	if(Yii::app()->user->hasFlash('success')):
		$this->widget('bootstrap.widgets.BootAlert');
?>

<?php else: ?>
	<p>If you wish to reset your password, enter the email address you used when you signed up.</p>
	<p><?php echo CHtml::errorSummary($model); ?></p>
<?php
	$form = $this->beginWidget('bootstrap.widgets.BootActiveForm', array(
	    'id' => 'forgot-form',
	    'type' => 'inline',
	    'enableAjaxValidation' => false,
	    'enableClientValidation' => true,
	));
?>

<?php echo $form->textFieldRow($model, 'email', array('class' => 'span5', 'autofocus' => 'true')); ?>
 <?php echo CHtml::htmlButton('Submit', array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
<?php $this->endWidget(); ?>

<p>If this email address is found in our records, an email will be sent to you containing instruction on how to reset your password.</p>
<?php endif; ?>