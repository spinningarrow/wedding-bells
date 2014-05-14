<?php
	$this->pageTitle=Yii::app()->name;
?>

<?php $this->widget('bootstrap.widgets.BootAlert'); // Display alert messages, if any ?>

<!-- <ul id="carousel" class="unstyled">
	<li>
		<img src="assets/img/slideshow/1.jpg" width="940" height="200" alt="Wedding Bells photo slideshow - Image 1">
	</li>
	<li>
		<img src="assets/img/slideshow/2.jpg" width="940" height="200" alt="Wedding Bells photo slideshow - Image 2">
	</li>
	<li>
		<img src="assets/img/slideshow/3.jpg" width="940" height="200" alt="Wedding Bells photo slideshow - Image 3">
	</li>
	<li>
		<img src="assets/img/slideshow/4.jpg" width="940" height="200" alt="Wedding Bells photo slideshow - Image 4">
	</li>
	<li>
		<img src="assets/img/slideshow/5.jpg" width="940" height="200" alt="Wedding Bells photo slideshow - Image 5">		
	</li>
	<li>
		<img src="assets/img/slideshow/6.jpg" width="940" height="200" alt="Wedding Bells photo slideshow - Image 6">
	</li>
	<li>
		<img src="assets/img/slideshow/7.jpg" width="940" height="200" alt="Wedding Bells photo slideshow - Image 7">
	</li>
</ul> -->

<div id="myCarousel" class="carousel slide">
  <!-- Carousel items -->
  <div class="carousel-inner">
    <div class="active item">
    	<img src="assets/img/slideshow/1.jpg" alt="Wedding Bells photo slideshow - Image 1">
    </div>
    <div class="item">
    	<img src="assets/img/slideshow/2.jpg" alt="Wedding Bells photo slideshow - Image 2">
    </div>
    <div class="item">
    	<img src="assets/img/slideshow/3.jpg" alt="Wedding Bells photo slideshow - Image 3">
    </div>
    <div class="item">
    	<img src="assets/img/slideshow/4.jpg" alt="Wedding Bells photo slideshow - Image 4">
    </div>
    <div class="item">
    	<img src="assets/img/slideshow/5.jpg" alt="Wedding Bells photo slideshow - Image 5">
    </div>
    <div class="item">
    	<img src="assets/img/slideshow/6.jpg" alt="Wedding Bells photo slideshow - Image 6">
    </div>
    <div class="item">
    	<img src="assets/img/slideshow/7.jpg" alt="Wedding Bells photo slideshow - Image 7">
    </div>
  </div>
  <!-- Carousel nav -->
  <a class="carousel-control left" href="#myCarousel" data-slide="prev">&lsaquo;</a>
  <a class="carousel-control right" href="#myCarousel" data-slide="next">&rsaquo;</a>
</div>

<div class="row">
	<div class="span8">
		
		<h2>Welcome</h2>

		<p>We believe that no two weddings are alike. It’s not the union of two people or two lovers; marriage is the union of two families, of two worlds. We would like to make this union of yours a memorable one. So that when you go down the memory lane and recount your wedding to your grandchildren, it would bring a smile to your face.</p>

		<p>For a quick overview of our features, check out the video below. And then <?php echo CHtml::link('sign up', array('site/page', 'view' => 'statsignup'));?> to enjoy all these features — it's free and fast!</p>

		<iframe src="http://player.vimeo.com/video/42077888?byline=0&amp;portrait=0&amp;color=f7e4be" style="width: 100%; margin-top: 2em" height="350" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
		
	</div>

	<!-- Sidebar -->
	<div class="span3 offset1 social-buttons"> 
		<!-- <a href="https://twitter.com/#!/_WeddingBells_" class="btn btn-small"><i class="icon-twitter-bird icon-extras"></i> Follow us on Twitter</a> -->
		<a href="https://twitter.com/_WeddingBells_" style="margin-top: 200px !important" class="twitter-follow-button" data-show-count="true" data-size="large" data-show-screen-name="false">Follow WeddingBells</a>
        <script>
          !function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");
         </script>
       <!--facebook like --> 
       <iframe src="https://www.facebook.com/plugins/like.php?href=https://www.facebook.com/WeddingBellsPvtLtd"
        scrolling="no" style="border:none; width: 100%; margin-top: 2em"></iframe>
       <!--twitter follow -->
        
         <!--
			<a href="https://www.facebook.com/WeddingBellsPvtLtd" class="btn btn-primary"><i class="icon-facebook-alt icon-extras-white"> </i> Like us on Facebook</a> <br><br>
			<a href="https://twitter.com/#!/_WeddingBells_"class="btn btn-info"><i class="icon-twitter-bird icon-extras-white"></i> Follow us on Twitter </a>-->

			<!-- <div id="fb-root"></div>
			<script>(function(d, s, id) {
			  var js, fjs = d.getElementsByTagName(s)[0];
			  if (d.getElementById(id)) return;
			  js = d.createElement(s); js.id = id;
			  js.src = "//connect.facebook.net/en_IN/all.js#xfbml=1&appId=216782125105272";
			  fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));</script>

			<div class="fb-like" data-href="https://www.facebook.com/WeddingBellsPvtLtd" data-send="false" data-show-faces="false" data-width="200"></div> -->
	</div>
</div>

<?php

$js_carousel = <<<'SCRIPT'

	$('.carousel').carousel({
		interval: 3000,
	});

SCRIPT;

	// Include on $(document).ready
	Yii::app()->clientScript->registerScript('index.carousel', $js_carousel, CClientScript::POS_READY);

	// Register carousel
	Yii::app()->bootstrap->registerCarousel();
?>