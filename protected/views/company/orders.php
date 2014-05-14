<?php $this->pageTitle=Yii::app()->name; ?>
<h2>My Orders</h2>
<p>These are the pending orders for your company.</p>
<br>
<?php 
$category = $company->category;
if($category =='dress'){
	?>
	<h3>Bride dresses</h3>
	<?php
$dataProvider=new CActiveDataProvider('Wedding', array(
    'criteria'=>array(
        'condition'=>'bride_id in (select id from '.$category.' where company_id ='.$company->id.') and date>'.date("Ymd").' and t.status=\'confirmed\'',
        'with'=>array('bride','customer'),
    ),
    'pagination'=>array(
        'pageSize'=>10,
    ),
));
$this->widget('bootstrap.widgets.BootGridView', array(
	'dataProvider'=>$dataProvider,
	'columns'=>array(		
		/*'customer.first_name',
		'customer.last_name',*/
		array('header' => 'Customer Name', 'value' => '"{$data->customer->first_name} {$data->customer->last_name}"'),
		'name:Wedding Name',
		'date:Wedding Date',
		'bride.id:Bride ID',
		/*
		'description',
		'status',
		*/
		
	),
)); 
?>
<br>
	<h3>Groom dresses</h3>
	<?php
$dataProvider=new CActiveDataProvider('Wedding', array(
    'criteria'=>array(
        'condition'=>'groom_id in (select id from '.$category.' where company_id ='.$company->id.') and date>'.date("Ymd").' and t.status=\'confirmed\'',
        'with'=>array('groom','customer'),
    ),
    'pagination'=>array(
        'pageSize'=>10,
    ),
));
$this->widget('bootstrap.widgets.BootGridView', array(
	'dataProvider'=>$dataProvider,
	'columns'=>array(		
		/*'customer.first_name',
		'customer.last_name',*/
		array('header' => 'Customer Name', 'value' => '"{$data->customer->first_name} {$data->customer->last_name}"'),
		'name:Wedding Name',
		'date:Wedding Date',
		'groom.id:Groom ID',
		/*
		'description',
		'status',
		*/
		
	),
)); 
?>
<br>
	<h3>Bridesmaid dresses</h3>
	<?php
$dataProvider=new CActiveDataProvider('Wedding', array(
    'criteria'=>array(
        'condition'=>'bridesmaid_id in (select id from '.$category.' where company_id ='.$company->id.') and date>'.date("Ymd").' and t.status=\'confirmed\'',
        'with'=>array('bridesmaid','customer'),
    ),
    'pagination'=>array(
        'pageSize'=>10,
    ),
));
$this->widget('bootstrap.widgets.BootGridView', array(
	'dataProvider'=>$dataProvider,
	'columns'=>array(		
		/*'customer.first_name',
		'customer.last_name',*/
		array('header' => 'Customer Name', 'value' => '"{$data->customer->first_name} {$data->customer->last_name}"'),
		'name:Wedding Name',
		'date:Wedding Date',
		'bridesmaid.id:Bridesmaid ID',
		/*
		'description',
		'status',
		*/
		
	),
)); 
?>
<br>
	<h3>Groomsmen dresses</h3>
	<?php
$dataProvider=new CActiveDataProvider('Wedding', array(
    'criteria'=>array(
        'condition'=>'groomsmen_id in (select id from '.$category.' where company_id ='.$company->id.') and date>'.date("Ymd").' and t.status=\'confirmed\'',
        'with'=>array('groomsmen','customer'),
    ),
    'pagination'=>array(
        'pageSize'=>10,
    ),
));
$this->widget('bootstrap.widgets.BootGridView', array(
	'dataProvider'=>$dataProvider,
	'columns'=>array(		
		/*'customer.first_name',
		'customer.last_name',*/
		array('header' => 'Customer Name', 'value' => '"{$data->customer->first_name} {$data->customer->last_name}"'),
		'name:Wedding Name',
		'date:Wedding Date',
		'groomsmen.id:Groomsmen ID',
		/*
		'description',
		'status',
		*/
		
	),
)); 
}
else
{

$dataProvider=new CActiveDataProvider('Wedding', array(
    'criteria'=>array(
        'condition'=>$category.'_id in (select id from '.$category.' where company_id ='.$company->id.') and date>'.date("Ymd").' and t.status=\'confirmed\'',
        'with'=>array($category,'customer'),
    ),
    'pagination'=>array(
        'pageSize'=>10,
    ),
));

$this->widget('bootstrap.widgets.BootGridView', array(
	'dataProvider'=>$dataProvider,
	'columns'=>array(		
		/*'customer.first_name',
		'customer.last_name',*/
		array('header' => 'Customer Name', 'value' => '"{$data->customer->first_name} {$data->customer->last_name}"'),
		'name:Wedding Name',
		'date:Wedding Date',
		$category.'_id:'.ucfirst($category).' ID',
		/*
		'description',
		'status',
		*/
		
	),
)); 
}?>