<?php
?>
<?php $this->widget('bootstrap.widgets.BootAlert'); // Display alert messages, if any ?>
<h2>Profile</h2>
<br>
<?php $this->widget('bootstrap.widgets.BootDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'first_name',
		'last_name',
		'id0.username', //have to get email id from user table
		'phone',
	),
)); ?>
<br>
If you want to change your password, click <?php echo CHtml::link('here', array('site/ChangePassword',));?>.
<br>
<br>
<?php echo CHtml::button('Update', array('class'=>'btn btn-primary','submit' => array('site/updateC',))); ?>
