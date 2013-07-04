<?php 

class home extends controller{
	function index(){
	
		$ControlName = "home";
		$Layout = "nomenu";
		$View = "index";
		$Title = "Welcome";
		
		$this->RenderView($ControlName, $Layout, $View, $Title);
	}
	function setlist(){
		$list = $_POST['List'];
		//echo var_dump($list); 
		header("location: /la/vote/list/".$list);
	}
	
}

?>
