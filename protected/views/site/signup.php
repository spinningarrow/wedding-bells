	<?php
$this->pageTitle=Yii::app()->name . ' - Customer Sign Up';
?>

<h2>Sign Up as a Customer</h2>

<p>If you have a <a href="http://www.facebook.com">Facebook</a>, <a href="http://www.yahoo.com">Yahoo</a>, <a href="http://www.google.com/account">Google</a> or <a href="http://openid.net/get-an-openid/">OpenID</a> account, you can log in directly without even needing to sign up. Just choose your account from our <?php echo CHtml::link('login page',	array('site/login'));?> and you're done!</p>

<?php
	$form = $this->beginWidget('bootstrap.widgets.BootActiveForm', array(
	    'id' => 'signup-form',
	    'type' => 'horizontal',
	    'enableAjaxValidation' => false,
	    'enableClientValidation' => true,
	));
?>

<?php echo $form->textFieldRow($model, 'Fname', array('autofocus' => 'true')); ?>
<?php echo $form->textFieldRow($model, 'Lname'); ?>
<?php echo $form->textFieldRow($model, 'email', array('hint' => 'You will use your email address when you log in.', 'class' => 'passstrength-userid')); ?>
<?php echo $form->passwordFieldRow($model, 'password', array('class' => 'password')); ?>
<?php echo $form->passwordFieldRow($model, 'cpassword'); ?>
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