<?php
$this->pageTitle = 'Activation « ' . Yii::app()->name;
?>
<p>Thank you <?php echo $name;?>, your account has now been activated. You may now 
	<?php echo CHtml::link('login',array('/site/login'));?>. </p>