<?php

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('company-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h2>Manage Companies</h2>

<p>You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b> or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.</p>

<?php $this->widget('bootstrap.widgets.BootAlert'); // Display alert messages, if any ?>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('advsearch',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->


<?php $this->widget('bootstrap.widgets.BootGridView', array(
	'ajaxUpdate' => true,
	'id'=>'company-grid',
	'dataProvider'=>$model->search(),
	'type'=>'striped condensed',
	'filter'=>$model,
	'columns'=>array(
		'id',
		'name',
		'category',
		'email_id',
		array(
			'class'=>'bootstrap.widgets.BootButtonColumn',
			'afterDelete'=> 'function(link, success, data) { displayAlert(data.split("@")[0], data.split("@")[1]); }',
		),
	),
)); ?>

<?php /* JavaScript */

$js = <<<'SCRIPT'

	function displayAlert(type, message) {
		
		var alertHtml = '<div class="alert alert-block"><a class="close" data-dismiss="alert" href="#">×</a></div>';
		$('.search-button').eq(0).before(alertHtml);
		$('.alert')
			.addClass('alert-' + type)
			.find('a')
				.after(message);
	}

SCRIPT;

	// Include on $(document).ready
	Yii::app()->clientScript->registerScript('add.js', $js, CClientScript::POS_READY);
?>