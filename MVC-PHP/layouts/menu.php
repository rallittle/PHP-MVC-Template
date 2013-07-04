<?php
	$config = new config;
	$request = new Request;
	$controller = $request->ControlName;
	echo '<div id="menu"><div><a id="btnMenu">&nbsp;</a></div>';
		//echo $controller == "location" ? "" : '<a class="btn btnwide" href="'.$config->BaseDir.'/location">location</a>';
		echo $controller == "home" ? "" : '<a class="btn btnwide" href="'.$config->BaseDir.'/home">home</a>';
		echo $controller == "quote" ? "" : '<a class="btn btnwide" href="'.$config->BaseDir.'/quote">Quote</a>';
		echo $controller == "vote" ? "" : '<a class="btn btnwide" href="'.$config->BaseDir.'/vote">Vote</a>';
	echo '</div>';
?>

<script>

$(function(){	
	$('#btnMenu').click(function(){
		if($('#btnMenu.menuopen').length > 0){
			$('#btnMenu').animate({"top": "-31px", "background-position-y" :"68px"}, 200 ).removeClass('menuopen');
			$('#menu').animate({"bottom": "-121px"}, 750 );
			$('#menu').css("border-top", "1px solid #000000")
		}
		else{
			$('#btnMenu').animate({"top": "0px", "background-position-y" :"30px"}, 200 ).addClass('menuopen');
			$('#menu').animate({"bottom": "0px"}, 750 );
		}
	});
});


</script>