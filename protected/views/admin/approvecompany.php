	<div class="form">
<h2>Approve Companies</h2>

<?php 
$companies=Company::model()->findAll('authenticated = 0');
if($companies==NULL){
	?>
	<p> <br> No companies are pending approval. </p>
	<?php
}
else {
foreach ($companies as $company) {
	$this->widget('bootstrap.widgets.BootDetailView', array(
	'data'=>$company,
	'attributes'=>array(
		'regno',
		'name',
		'category',
		'email_id',
	),
));
?>
<div class="form-actions">
<?php echo CHtml::Button('Approve', array('class'=>'btn btn-primary','submit' => array('admin/approve','id'=>$company->id))); ?>

<?php echo CHtml::Button('Decline', array('class'=>'btn btn-danger', 'submit' => array('admin/decline','id'=>$company->id))); ?>

<?php echo CHtml::Button('View', array('class'=>'btn btn-info', 'submit' => array('admin/view','id'=>$company->id))); ?>
</div>
<?php
}}
?>
</div><!-- form -->