

<h2>View Product #<?php echo $model->id; ?></h2>
<br>
<p><img src="<?php echo $path; ?>" width="128" height="128" alt="Not Available"></p>
<br>
<?php $this->widget('bootstrap.widgets.BootDetailView', array(
	'data'=>$model,	
)); ?>
<?php echo CHtml::button('Update', array('class'=>'btn btn-primary','submit' => array('company/update','id'=>$model->id))); ?>