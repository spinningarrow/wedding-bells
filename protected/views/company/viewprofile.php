<?php
?>
<?php $this->widget('bootstrap.widgets.BootAlert'); // Display alert messages, if any ?>
<h2>Profile</h2>
<br>
<?php $this->widget('bootstrap.widgets.BootDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'regno',
		'name',
		'category',
		'email_id',
		'address',
		'pincode',
		'country',
		'phone',
	),
)); ?>

<div>
	<br>
	If you want to change your password, click <?php echo CHtml::link('here', array('company/ChangePassword',));?>.
	<br>
	<br>
</div>

<?php echo CHtml::button('Update', array('class'=>'btn btn-primary','submit' => array('company/updateC',))); ?>





