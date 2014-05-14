<?php
$this->breadcrumbs=array(
	'Weddings'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Wedding', 'url'=>array('index')),
	array('label'=>'Create Wedding', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('wedding-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Weddings</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'wedding-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'wedding_id',
		'customer_id',
		'name',
		'date',
		'number_guests',
		'number_groomsmen',
		/*
		'number_bridesmaid',
		'venue_id',
		'caterer_id',
		'photographer_id',
		'music_id',
		'decor_id',
		'invitation_id',
		'cake_id',
		'bride_id',
		'groom_id',
		'bridesmaid_id',
		'groomsmen_id',
		'status',
		'budget',
		'venue_priority',
		'caterer_priority',
		'photographer_priority',
		'music_priority',
		'decor_priority',
		'dress_priority',
		'invitation_priority',
		'cake_priority',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
