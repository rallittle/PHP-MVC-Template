<!DOCTYPE html>
<html>
	<head>
		<META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
		<META HTTP-EQUIV="PRAGMA" CONTENT="NO-CACHE">    
		<meta content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport">
	    <meta content="true" name="HandheldFriendly">

		<meta charset="utf-8" />
		
		<title><?php echo $title; ?></title>
		<link href="/la/content/css/styles.css" rel="stylesheet" type="text/css">
		<script src="/la/content/js/jquery-1.7.2.min.js" type="text/javascript"></script>
		<script src="/la/content/js/mobileappprep.js" type="text/javascript"></script>

		<script language="javascript" type="text/javascript">
			$(function(){
				window.onresize = resized;
				webappStart();

			});
			
			/*$(document).bind(
			  'touchmove',
			  function(e) {
			    e.preventDefault();
			  }
			);*/
			
			function resized(){
				$('#Content').height($('#Content').parent().height()-30);
			}	
		</script>
		
		
	</head>
	
	<body id="page" class="home main">
		<?php require_once('header.partial.php'); ?>
		<div class="wrapper">
			<div class="inner-wrapper">
				<?php require_once('search.php'); ?>
				<div id="Content">
					<?php require_once($body); ?>
							
				</div>
				<?php require_once('menu.php'); ?>
			</div>
		</div>
		<?php require_once('footer.partial.php'); ?>		
	</body>
</html>