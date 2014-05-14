<?php
$this->breadcrumbs=array(
	'Venues',
);

$this->menu=array(
	array('label'=>'Create Venue', 'url'=>array('create')),
	array('label'=>'Manage Venue', 'url'=>array('admin')),
);
?>

<h1>Venues</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
