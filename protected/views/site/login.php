  <?php
$this->pageTitle=Yii::app()->name . ' - Login';
$this->breadcrumbs=array(
	'Login',
);
?>

<?php $this->widget('bootstrap.widgets.BootAlert'); // Display alert messages, if any ?>

<h2>Login</h2>
<p>Log in by entering the credentials below. New users, <?php echo CHtml::link('sign up', array('site/page', 'view' => 'statsignup')); ?> now!</p>
<div class="row login-boxes">
	<div class="span6 well">
		<p><strong>Login with your Wedding Bells account</strong> (for customers and companies)</p>
		<?php
			$form = $this->beginWidget('bootstrap.widgets.BootActiveForm', array(
			    'id' => 'login-form',
			    'type' => 'vertical',
			    'enableAjaxValidation' => false,
			    'enableClientValidation' => true,
			));
		?>
		<?php echo $form->textFieldRow($model, 'username',array(/*'hint'=>'The email address you used when you signed up.'*/)); ?>
		<?php echo $form->passwordFieldRow($model, 'password', array('hint' => CHtml::link('Forgot password?',array('/site/forgotPassword')))); ?>
		<?php echo $form->checkBoxRow($model, 'rememberMe'); ?>

		<!-- <div class="form-actions"> -->
		    <?php echo CHtml::htmlButton('Login', array('class'=>'btn btn-primary btn-large', 'type'=>'submit')); ?>
		<!-- </div> -->

		<?php $this->endWidget(); ?>

	</div>     
	
	<div class="span4 well">
		<p><strong>Login with OpenID</strong> (for customers only)</p>
		<div id="janrainEngageEmbed" class=""></div>
		<p>This will sign you up automatically if this is your first time logging in.</p>
	</div>
</div>

<?php

$php_js = "var redirectUrl = '" . CController::createAbsoluteUrl('site/janrainLogin') . "';";

$js_janrain = <<<'SCRIPT'

	(function() {
	    if (typeof window.janrain !== 'object') window.janrain = {};
	    if (typeof window.janrain.settings !== 'object') window.janrain.settings = {};
	    
	    janrain.settings.tokenUrl = redirectUrl;

	    function isReady() { janrain.ready = true; };
	    if (document.addEventListener) {
	      document.addEventListener("DOMContentLoaded", isReady, false);
	    } else {
	      window.attachEvent('onload', isReady);
	    }

	    var e = document.createElement('script');
	    e.type = 'text/javascript';
	    e.id = 'janrainAuthWidget';

	    if (document.location.protocol === 'https:') {
	      e.src = 'https://rpxnow.com/js/lib/wedding-bells/engage.js';
	    } else {
	      e.src = 'http://widget-cdn.rpxnow.com/js/lib/wedding-bells/engage.js';
	    }

	    var s = document.getElementsByTagName('script')[0];
	    s.parentNode.insertBefore(e, s);
	})();

	$.ajax({

		// override janrain styles, Pro account be damned
		success: function () {

			if ($('.janrainContent').length) {
				restyleJanrain();
			}

			else {
				window.setTimeout(restyleJanrain, 500);
			}
		}
	})

	$('#janrainEngageEmbed').ajaxComplete(function () {
		console.log('complete?');
	});

	function restyleJanrain() {

		var oldStyle = $('.janrainContent').attr('style');
		
		var borderStyles = /border-[\w-]+: [\d\w(), ]+!important; /g;
		var backgroundColor = /background-color: .+?;/;
		var position = / position: [\w]+ !important;/;
		var widthHeight = /width: .+?; height: .+?;/;

		var newStyle = oldStyle.replace(widthHeight, 'height: 200px;')
								.replace(borderStyles, '')
								.replace(backgroundColor, 'background-color: transparent;')
								.concat(' margin-left: 0px; ');

		console.log(newStyle);

		$('.janrainContent').attr('style', newStyle);
		$('.janrainContent').find('#janrainView > div').eq(0).hide();
		$('.janrainContent').find('#janrainView > div').eq(2).hide();
		$('.janrainContent').find('#janrainView > div').eq(0)
			.attr('style', function (index, oldVal) {
				return oldVal.replace(backgroundColor, 'background-color: transparent;');
			})
			.find('div').attr('style', 'padding-bottom: 1em;');

		// style 'Sign in as box'
		if ($('#janrainView').next('div').length) {
			$('#janrainView').next('div').css('width', '280px');
		}
	}

SCRIPT;

	Yii::app()->clientScript->registerScript('login.janrain', $php_js . $js_janrain, CClientScript::POS_HEAD);
?>