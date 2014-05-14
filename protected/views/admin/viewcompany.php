<?php
?>

<h2>View Company #<?php echo $model->id; ?></h2>
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
<?php if($model->authenticated==0){
echo CHtml::Button('Approve', array('class'=>'btn btn-primary','submit' => array('admin/approve','id'=>$model->id))); ?>

<?php echo CHtml::Button('Decline', array('class'=>'btn btn-danger', 'submit' => array('admin/decline','id'=>$model->id)));
} ?>

<?php echo CHtml::button('Update', array('class'=>'btn btn-primary','submit' => array('admin/update','id'=>$model->id))); ?>

