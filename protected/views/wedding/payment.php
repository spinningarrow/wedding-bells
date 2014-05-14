<?php
	$this->pageTitle=Yii::app()->name . ' - Payment';
?>
<?php echo CHtml::errorSummary($model); ?>
<?php $this->widget('bootstrap.widgets.BootAlert'); // Display alert messages, if any ?>
<div class="alert">
  <button class="close" data-dismiss="alert">×</button>
  <strong>Note:</strong> Please <a href="javascript:if (window.print) window.print();">print</a> this page, or save it. For details on payment, please see the instructions on the <?php echo CHtml::link('payment page', array('site/page', 'view' => 'payment'));?>.
</div>
	<h2>Invoice</h2>

	<div class="pull-right">
		<h3>Wedding Bells Pvt. Ltd.</h3>	
		<p>#121 Changi Business Park, Central 3, Singapore - 486048</p>
	</div>

<?php
	
	$totalcost = 0;
	$date = date("d-m-Y", strtotime($model->date));
	$due = date('d-m-Y', strtotime("+7 days"));

echo <<<EOT
<p><strong>Customer Name</strong>: {$model->customer->first_name} {$model->customer->last_name}<br>
<strong>Wedding Date</strong>: {$date}<br>
<strong>Due Date</strong>: {$due}</p>
EOT;
?>
<table class="table table-striped table-bordered">
	<tr>
		<th>Company</th>
		<th>Product</th>
		<th>Price</th>
	</tr>
<?php if($model->venue_id!==NULL) { 
$totalcost+=$model->venue->price;
?>
	<tr>
		<td><?php echo $model->venue->company->name ?></td>
		<td><?php echo $model->venue->name ?></td>
		<td><?php echo $model->venue->price ?></td>
	</tr>
<?php }
if($model->caterer_id!==NULL) { 
$totalcost+=$model->caterer->price_per_pax*$model->number_guests;
?>
	<tr>
		<td><?php echo $model->caterer->company->name ?></td>
		<td><?php echo $model->caterer->name ?></td>
		<td><?php echo $model->caterer->price_per_pax*$model->number_guests ?></td>
	</tr>
<?php }
if($model->photographer_id!==NULL) {
$totalcost+=$model->photographer->price;
 ?>
	<tr>
		<td><?php echo $model->photographer->company->name ?></td>
		<td><?php echo $model->photographer->name ?></td>
		<td><?php echo $model->photographer->price?></td>
	</tr>
<?php }
if($model->music_id!==NULL) { 
$totalcost+=$model->music->price;
	?>
	<tr>
		<td><?php echo $model->music->company->name ?></td>
		<td><?php echo $model->music->name ?></td>
		<td><?php echo $model->music->price?></td>
	</tr>
<?php }
if($model->decor_id!==NULL) { 
$totalcost+=$model->decor->price;
	?>
	<tr>
		<td><?php echo $model->decor->company->name ?></td>
		<td><?php echo $model->decor->name ?></td>
		<td><?php echo $model->decor->price?></td>
	</tr>
<?php }
if($model->cake_id!==NULL) { 
$totalcost+=$model->cake->price;
	?>
	<tr>
		<td><?php echo $model->cake->company->name ?></td>
		<td><?php echo $model->cake->name ?></td>
		<td><?php echo $model->cake->price?></td>
	</tr>
<?php }
if($model->bride_id!==NULL) {
$totalcost+=$model->bride->price;
 ?>
 <tr>
 	<td><?php echo $model->bride->company->name ?></td>
 	<td><?php echo $model->bride->name ?></td>
 	<td><?php echo $model->bride->price?></td>
 </tr>
<?php }
if($model->groom_id!==NULL) { 
$totalcost+=$model->groom->price;
	?>
	<tr>
		<td><?php echo $model->groom->company->name ?></td>
		<td><?php echo $model->groom->name ?></td>
		<td><?php echo $model->groom->price?></td>
	</tr>
<?php }
if($model->bridesmaid_id!==NULL) { 
$totalcost+=$model->bridesmaid->price*$model->number_bridesmaid;
	?>
	<tr>
		<td><?php echo $model->bridesmaid->company->name ?></td>
		<td><?php echo $model->bridesmaid->name ?></td>
		<td><?php echo $model->bridesmaid->price*$model->number_bridesmaid?></td>
	</tr>
<?php }
if($model->groomsmen_id!==NULL) {
$totalcost+=$model->groomsmen->price*$model->number_groomsmen;
 ?>
	<tr>
		<td><?php echo $model->groomsmen->company->name ?></td>
		<td><?php echo $model->groomsmen->name ?></td>
		<td><?php echo $model->groomsmen->price*$model->number_groomsmen?></td>
	</tr>
<?php } ?>
<tr>
	<th colspan="2">Total Cost</th>
	<td><?php echo $totalcost ?></td>
</tr>
</table>
<p class=""><strong>Zahil Lihaz</strong><br>
Chief Executive Officer<br>
Wedding Bells Pte. Ltd.</p>

<?php /* CSS */

$css_print = <<<'CSS'
	
	#header, #footer, .title-phone, .alert {
		display: none;
	}

	#main-content, #container {
		clear: both;
		margin-top: 20em !important;
		width: 100%; margin: 0; float: none;
	}
CSS;

	// Register the CSS for print media
	Yii::app()->clientScript->registerCss('invoice.print', $css_print, 'print');
?>