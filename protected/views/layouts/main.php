<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>

	<!-- Favicon -->
	<link rel="icon" type="image/png" href="favicon.png">

	<!-- Google Web Fonts: Raleway -->
	<link href='http://fonts.googleapis.com/css?family=Raleway:100' rel='stylesheet' type='text/css'>
</head>

<body>

<div class="container" id="page">
	<a class="title-phone" href="<?php echo CController::createUrl('site/index'); ?>"><img class="visible-phone" src="<?php echo Yii::app()->request->baseUrl; ?>/assets/img/weddingbells_small.png" width="322" alt="Wedding Bells - Make your dream wedding come true"></a>
	<div id="header" class="">
		<?php

			if (Yii::app()->user->isGuest) {

				echo '<div id="login-box" class="span2 offset9">';		
				echo CHtml::link(
							'Login',
							array('/site/login')
						);

				echo " | ";

				echo CHtml::link(
							'Sign Up',
							array('site/page', 'view' => 'statsignup')
						);				

				echo '</div>';
			}
			else {

				echo '<div id="login-box" class="span3 offset9">';
				
				if (Yii::app()->user->role === "customer") {
					$customer = Customer::model()->findByPk(Yii::app()->user->id);
					$name = "$customer->first_name";
				}

				else if (Yii::app()->user->role === "company") {
					$company = Company::model()->findByPk(Yii::app()->user->id);
					$name = "$company->name";
				}

				else {
					$name = "Admin";
				}

				echo CHtml::link(
							'Logout',
							array('/site/logout')
						);
				echo " $name!";

				echo '</div>';
			}
		?>

		<h1>Wedding Bells</h1>

		<a href="<?php echo CController::createUrl('site/index'); ?>"><img class="hidden-phone" src="<?php echo Yii::app()->request->baseUrl; ?>/assets/img/weddingbells.png" width="630" height="150" alt="Wedding Bells - Make your dream wedding come true"></a>
	</div> <!-- end #header -->

	<div id="mainmenu" class="subnav">
		<?php $this->widget('zii.widgets.CMenu', array(
			'id' => 'nav',
			'activeCssClass' => 'active',
			'htmlOptions' => array('class' => 'nav nav-pills'),

			'items'=>array(
				// Basic
				array('label'=>'Home', 'url'=>array('/site/index')),
				array('label'=>'About', 'url'=>array('/site/page', 'view'=>'about'), 'visible'=>Yii::app()->user->isGuest || Yii::app()->user->role!="admin"),
				array('label'=>'FAQ', 'url'=>array('/site/page', 'view'=>'faq'), 'visible'=>Yii::app()->user->isGuest || Yii::app()->user->role!="admin"),
				array('label'=>'Contact', 'url'=>array('/site/contact'), 'visible'=>Yii::app()->user->isGuest || Yii::app()->user->role!="admin"),

				// Customer (reverse of display order as these are floated right)
				array('label'=>'My Profile', 'url'=>array('/site/profile'), 'visible'=>!Yii::app()->user->isGuest && Yii::app()->user->role=="customer", 'itemOptions' => array('class' => 'special-action')),
				array('label'=>'My Weddings', 'url'=>array('/wedding/index'),'visible'=>!Yii::app()->user->isGuest && Yii::app()->user->role=="customer", 'itemOptions' => array('class' => 'special-action')),

				// Company (reverse of display order as these are floated right)
				array('label'=>'My Profile', 'url'=>array('/company/profile'), 'visible'=>!Yii::app()->user->isGuest && Yii::app()->user->role=="company", 'itemOptions' => array('class' => 'special-action')),
				array('label'=>'Manage Products', 'url'=>array('/company/admin'), 'visible'=>!Yii::app()->user->isGuest && Yii::app()->user->role=="company", 'itemOptions' => array('class' => 'special-action')),
				array('label'=>'Add a Product', 'url'=>array('/company/addProduct'),'visible'=>!Yii::app()->user->isGuest && Yii::app()->user->role=="company", 'itemOptions' => array('class' => 'special-action')),
				array('label'=>'My Orders', 'url'=>array('/company'), 'visible'=>!Yii::app()->user->isGuest && Yii::app()->user->role=="company", 'itemOptions' => array('class' => 'special-action')),


				// Admin (reverse of display order as these are floated right)
				array('label'=>'Manage Companies', 'url'=>array('/admin'), 'visible'=>!Yii::app()->user->isGuest && Yii::app()->user->role=="admin", 'itemOptions' => array('class' => 'special-action')),
				array('label'=>'Approve Companies', 'url'=>array('/admin/approveList'),'visible'=>!Yii::app()->user->isGuest && Yii::app()->user->role=="admin", 'itemOptions' => array('class' => 'special-action')),
			),
		)); ?><!-- end #nav -->
	</div><!-- mainmenu -->

	<?php
		/*if(isset($this->breadcrumbs) &&
			// Don't display single breadcrumb on home page
			!(Yii::app()->controller->getId() === 'site' && Yii::app()->controller->getAction()->getId() === 'index')
		) {
		
			$this->widget('bootstrap.widgets.BootBreadcrumbs', array(
			    'links'=>$this->breadcrumbs,
			)); // breadcrumbs
		}*/
	?>

	<div id="main-content">
		<?php echo $content; ?>
	</div><!-- end #main-content -->

	<div class="clear"></div>

	<div id="footer">
		<p>Copyright © <?php echo date('Y'); ?> <?php echo CHtml::link('Wedding Bells Pvt. Ltd.',array('/site/page', 'view' => 'about'));?> All rights reserved. | <?php echo CHtml::link('Terms of Service',array('/site/page', 'view' => 'terms'));?></p>
	</div><!-- end #footer -->

</div><!-- page -->

</body>
</html>