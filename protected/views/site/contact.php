<?php
$this->pageTitle= 'Contact Us « ' . Yii::app()->name;
$this->breadcrumbs=array(
	'Contact',
);
?>

<h2>Contact Us</h2>

<?php
	if(Yii::app()->user->hasFlash('success')):
		$this->widget('bootstrap.widgets.BootAlert');
?>

<?php else: ?>

<p>If you have business inquiries or other questions, please fill out the following form to contact us.</p>

<?php
	$form = $this->beginWidget('bootstrap.widgets.BootActiveForm', array(
	    'id' => 'contact-form',
	    'type' => 'horizontal',
	    'enableAjaxValidation' => false, // not required, plus captcha doesn't validate correctly (see Yii docs)
	    'enableClientValidation' => true,
	));
?>

<?php echo $form->textFieldRow($model, 'name', array('autofocus' => 'true')); ?>
<?php echo $form->textFieldRow($model, 'email'); ?>
<?php echo $form->textFieldRow($model, 'subject'); ?>
<?php echo $form->textAreaRow($model, 'body', array('rows' => 7, 'class' => 'span5')); ?>

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

<?php endif; ?>