<?php
$this->breadcrumbs=array(
	'Weddings'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Wedding', 'url'=>array('index')),
	array('label'=>'Manage Wedding', 'url'=>array('admin')),
);
?>

<h1>Create Wedding</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>