<?php $this->pageTitle=Yii::app()->name; ?>
<p> This is the company home page </p>
<?php 
$connection=Yii::app()->db;
$command=$connection->createCommand("select id from company where email_id = ".'"'.Yii::app()->user->email.'"');
$cid=$command->queryScalar(); 
$command=$connection->createCommand("select category from company where id = ".$cid);
$category=$command->queryScalar(); 
$command=$connection->createCommand("select id from ".$category." where company_id = ".$cid);
$pids=$command->queryColumn();
$in='('; 
foreach($pids as $value)
	{$in .=  $value.",";}
$in = substr($in, 0, strlen($in)-1); 
$in.=')';
 $command=$connection->createCommand("select wedding_id,customer_email,name as Wedding,date as Date,".$category."_id as Product_ID from wedding where ".$category."_id in ".$in);
 $rows=$command->queryAll();
$data = new CArrayDataProvider($rows, array('id'=>'id'));        	
$arrayDataProvider=new CArrayDataProvider($rows, array('keyField'=>'wedding_id','pagination'=>false ));
$this->widget('zii.widgets.grid.CGridView', array('dataProvider'=>$arrayDataProvider)); 
?>