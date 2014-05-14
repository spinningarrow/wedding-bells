<?php
$this->pageTitle=Yii::app()->name . ' - FAQ';
?>
<h2>FAQ</h2>

<dl class="faq">
	<dt>How do I register as a company?</dt>
	<dd>In order to be registered as a company and display your products under the right category, you need to send an email to the administrators through the <?php echo CHtml::link('contact', array('/site/contact'));?> page. After proper verification, an account will be created for you, along with a default password which can be changed later. Once you receive a confirmation email from us, you can view your profile by logging in, and add products to the list. More information will be provided once we receive your email.</dd>

	<dt>Can I register as a company that is not based in Singapore?</dt>
	<dd>Sorry, Wedding Bells Pte Ltd is a Singapore-registered company and does not cater to weddings or companies outside Singapore. However, we are trying to expand to neighbouring countries, so please check this website regularly for updates.</dd>

	<dt>How do I start using the site, as a customer?</dt>
	<dd>Please follow the diagram below.
		<br>
		<img src="<?php echo Yii::app()->request->baseUrl; ?>/assets/img/flowchart.png" width="535" alt="Customer-flow chart"></dd>

    <dt>How do I start using the site, as a company?</dt>
	<dd>Please follow the diagram below.
		<br>
		<img src="<?php echo Yii::app()->request->baseUrl; ?>/assets/img/flowchart2.png" width="272" alt="Company-flow chart"></dd>

	<dt>How do I choose the different features under "Create your own wedding"?</dt>
	<dd>When you select "Create your own wedding", you will be prompted for your budget and the list of features that you require, along with priorities for each. You will then be provided with a set of features, which reflect the optimum use of the money allocated. However, you can change any of the features if you wish.</dd>

	<dt>Can I plan more than one wedding at the same time?</dt>
	<dd>Yes, you may simultaneously plan as many weddings as you like.</dd>	

	<dt>When can I start planning my wedding?</dt>
	<dd>We allow creation of weddings atleast 14 days before the wedding and not more than a year from the wedding. Please keep on checking your portal for any updates to your wedding. It is recommended to confirm your wedding within 7 days of creating the wedding.</dd>

	<dt>Do I need to make the full payment when I confirm the wedding?</dt>
	<dd>You need to make full payment upon confirmation of the wedding. For details on how to make the payment, please visit the <?php echo CHtml::link('payment', array('site/page', 'view' => 'payment'));?>  page.

	<dt>If I cancel a wedding after making the payment, will I get a refund?</dt>
	<dd>Once confirmed, a wedding cannot be cancelled. Also, as per the terms and conditions of Wedding Bells you will not get a refund if you cancel a wedding by contacting us.</dd>
</dl>