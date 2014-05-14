<h2>Manage Products</h2>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial($category.'/advsearch',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->renderPartial($category.'/manage',array(
	'model'=>$model,'company_id'=>$company_id,
)); ?>