<?php
$this->pageTitle=Yii::app()->name . ' - Company Sign Up';
?>

<h2>Sign Up as a Company</h2>

<?php
	$form = $this->beginWidget('bootstrap.widgets.BootActiveForm', array(
	    'id' => 'signup-form',
	    'type' => 'horizontal',
	    'enableAjaxValidation' => false,
	    'enableClientValidation' => true,
	));
?>

<?php echo $form->textFieldRow($model, 'name', array('autofocus' => 'true')); ?>
<?php echo $form->textFieldRow($model, 'regno'); ?>
<?php echo $form->dropDownListRow($model, 'category',array('dress'=>'Dress','caterer'=>'Caterer','cake'=>'Cake','decor'=>'Decor','music'=>'Music','photographer'=>'Photographer','venue'=>'Venue')); ?>
<?php echo $form->textFieldRow($model, 'email', array('hint' => 'You will use your email address when you log in.', 'class' => 'passstrength-userid')); ?>
<?php echo $form->passwordFieldRow($model, 'password', array('class' => 'password')); ?>
<?php echo $form->passwordFieldRow($model, 'cpassword'); ?>
<?php echo $form->textFieldRow($model, 'address'); ?>
<?php echo $form->textFieldRow($model, 'pincode'); ?>
<?php echo $form->textFieldRow($model, 'contact'); ?>

<?php
    if(CCaptcha::checkRequirements()) {
		echo $form->captchaRow($model,
			'verifyCode',
			array(
				'hint' => 'Please enter the letters as they are shown in the image above.<br/>Letters are not case-sensitive.'
			),
			array(
				'clickableImage' => true,
				'showRefreshButton' => true,
			)
		);
	}
?>

<div class="form-actions">
    <?php echo CHtml::htmlButton('Submit', array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
    <?php echo CHtml::htmlButton('Reset', array('class'=>'btn btn-inverse', 'type'=>'reset')); ?>
</div>

<?php $this->endWidget(); ?>

<?php /* JavaScript */

$js_password = <<<'SCRIPT'

	$('.password').passStrength({
		userid: '.passstrength-userid',
		baseStyle: 'password-testresult',
		shortPass: 'label label-important',
		badPass: 'label label-warning',
		goodPass: 'label label-success',
		strongPass: 'label label-success'

	});

	$('#signup-form .form-actions button').eq(1).click(function () {
		$('.password-testresult').html('').removeClass('label').removeClass('label-important');
	});

SCRIPT;

	// Register the password strength plugin
	Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/assets/js/password_strength_plugin.js', CClientScript::POS_END);

	// Include on $(document).ready
	Yii::app()->clientScript->registerScript('add.js', $js_password, CClientScript::POS_READY);

?>