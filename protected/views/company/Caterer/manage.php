<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return FALSE;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('venue-grid', {
		data: $(this).serialize()
	});
	return FALSE;
});
");
?>

<?php $this->widget('bootstrap.widgets.BootGridView', array(
	'id'=>'caterer-grid',
	'dataProvider'=>$model->search($company_id),
	'filter'=>$model,
	'htmlOptions' => array('style' => 'white-space: nowrap;'),
	'type'=>'striped condensed',
	'columns'=>array(
		'id',
		'name',
		'price_per_pax',
		'status',
		array(
			'class'=>'bootstrap.widgets.BootButtonColumn',
			// 'deleteConfirmation'=>"js:'The status of the product with ID ' + $(this).parent().parent().children(':first-child').text() + ' will be toggled! Continue?'",
			'deleteConfirmation' => FALSE, // prevent alert on delete
			'buttons'=>array(
				'delete' => array(
					'icon' => 'retweet',
					'label'=>'Toggle Status',
					'url'=>'Yii::app()->createUrl("company/toggle", array("id"=>$data->id))',
					'afterDelete'=>'function(link,success,data){ alert(link + success + data);}',
				)
			)
		),
	),
)); ?>
