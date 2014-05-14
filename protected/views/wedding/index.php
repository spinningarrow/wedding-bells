<?php
	$weddings = $dataProvider->getData();
?>
<?php $this->widget('bootstrap.widgets.BootAlert'); // Display alert messages, if any ?>
<div  id='fb-root'></div> <!-- Weird facebook stuff -->

<div class="row">
	<div class="span9">
		<h2>Your Weddings</h2>
		<p>These are the weddings created by you. You may add a new wedding to your profile by clicking <a href="<?php echo CController::createUrl('wedding/add'); ?>">Add a Wedding</a> or edit an existing wedding before confirming it. You may also view the weddings created. </p>
	</div>

	<div class="well span2 pull-right social-buttons">
		<!-- Facebook Post to Feed -->
		<a class="btn btn-inverse btn-facebook" onclick='postToFeed(); return false;'><i class="icon-facebook-alt icon-extras-white"> </i> Post to Wall</a>
		<p id='msg'></p>
		<!-- End Facebook Post to Feed -->
		    
		<!-- Twitter Tweet #WB -->
		<a href="https://twitter.com/intent/tweet?button_hashtag=WB&text=Just%20planned%20a%20wedding!" class="twitter-hashtag-button" url="http://172.21.147.103/csc207/ss3g1/index.php" data-lang="en" data-size="large" data-related="jasoncosta">Tweet</a>
		<!-- End Twitter Tweet #WB -->
	</div>
</div>

<div class="row weddings-list">
	<?php foreach($weddings as $wedding):

			if ($wedding->status === "created") {
				$status_class = "info";
			}

			elseif ($wedding->status === "pending") {
				$status_class = "warning";
			}

			else {
				$status_class = "success";
			}
	?>
		<button value="<?php echo CController::createUrl('wedding/view', array('id' => $wedding->wedding_id)); ?>" class="span3 btn">
			<h3><a href="<?php echo CController::createUrl('wedding/view', array('id' => $wedding->wedding_id)); ?>"><?php echo $wedding->name; ?></a></h3>
			
			<p>
				<?php if (ceil((strtotime($wedding->date) - time())/(60*60*24)) > 0): ?>
					<span class="label label-<?php echo $status_class; ?>"><?php echo strtoupper($wedding->status); ?></span>
				<?php elseif (ceil((strtotime($wedding->date) - time())/(60*60*24)) == 0): ?>
					<span class="label label-important">TODAY</span>
				<?php else: ?>
					<span class="label">FINISHED</span> 
				<?php endif; ?>
				<span class="label"><?php echo strtoupper($wedding->type); ?></span>
			</p>
			<p class="details"><strong><?php echo date("j F Y", strtotime($wedding->date)); ?></strong><?php if (isset ($wedding->venue_id)): ?> at <a href="#"><?php echo $wedding->venue->name; ?></a><?php endif; ?></p>
		</button>
	<?php endforeach; ?>

	<a class="span2 btn btn-add hidden-phone" href="<?php echo CController::createUrl('wedding/add'); ?>">
		<span>+</span><br><strong>Add a Wedding</strong>
	</a>
</div>

<a class="btn btn-primary btn-large visible-phone" href="<?php echo CController::createUrl('wedding/add'); ?>">Add a Wedding
	</a>
 
<?php /* JavaScript */

$js_button_redirect = <<<'SCRIPT'

	// Redirect user to appropriate view page when the button is clicked
	$('.weddings-list button').click(function () {
		location.href = $(this).find('h3 a').attr('href');
	})

SCRIPT;

	// Include on $(document).ready
	Yii::app()->clientScript->registerScript('index.buttonRedirect', $js_button_redirect, CClientScript::POS_READY);

?>

<?php /* JavaScript */

$js_facebook = <<<'SCRIPT'

	FB.init({appId: "413543745340597", status: true, cookie: true});

	function postToFeed() {

	  // calling the API ...
	  var obj = {
	    method: 'feed',
	    link: 'http://172.21.147.103/csc207/ss3g1/shah/index.php?r=wedding/index',// where to end up after you click submit
	    picture: 'http://s3.amazonaws.com/wedding_prod/photos/f8837bfa7a46645aea3b9b4656e039cd_t',// image url
	    name: 'Wedding Bells Pte Ltd.',
	    caption: 'Make your dream wedding come true!',
	    description: ''
	  };

	  function callback(response) {
	  	// NOTE TO SELF: the following snippet can be used for debugging!
	    //document.getElementById('msg').innerHTML = "Post ID: " + response['post_id'];
	  }

	  FB.ui(obj, callback);
	}

SCRIPT;

$js_twitter = <<<'SCRIPT'

	!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");

SCRIPT;

	// Load facebook scripts
	Yii::app()->clientScript->registerScriptFile('http://connect.facebook.net/en_US/all.js', CClientScript::POS_BEGIN);
	Yii::app()->clientScript->registerScript('index.facebook', $js_facebook, CClientScript::POS_BEGIN);

	// Load twitter script
	Yii::app()->clientScript->registerScript('index.twitter', $js_twitter, CClientScript::POS_BEGIN);