<?php
	$config = new config;
	$request = new Request;
	$controller = $request->ControlName;
	
	
?>
<div class="search-box">
	<form method="post" action="<?php echo $config->BaseDir; ?>/search">
		<input type="text" class="" value="" name="query" placeholder="Search Quotes">
		<input type="submit" class="btn btnsearch" value="Search">
	</form>
	<div class="hideshow-search">&nbsp;</div>
</div>
