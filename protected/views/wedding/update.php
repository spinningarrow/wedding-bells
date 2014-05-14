<?php
$this->breadcrumbs=array(
	'Weddings'=>array('index'),
	$model->name=>array('view','id'=>$model->wedding_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Wedding', 'url'=>array('index')),
	array('label'=>'Create Wedding', 'url'=>array('create')),
	array('label'=>'View Wedding', 'url'=>array('view', 'id'=>$model->wedding_id)),
	array('label'=>'Manage Wedding', 'url'=>array('admin')),
);
?>

<h1>Update Wedding <?php echo $model->wedding_id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>