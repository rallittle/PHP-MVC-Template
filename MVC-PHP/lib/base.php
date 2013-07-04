<?php 
date_default_timezone_set('Pacific/Auckland');


require_once("config.php");
require_once("controller.php");
require_once("renderer.php");
require_once("database.php");


	class Request{
		var $ControlPath = "";
		var $ControlName = "";
		var $ControlMethod = "";

		public function getArgs(){
			$config = new Config;
	
			$uri = $_SERVER["REQUEST_URI"];
			
			if ($config->ignoreBaseDir){
				$uri = str_replace(strtolower($config->BaseDir),"",strtolower($uri));
			}
			return array_filter(explode("/", $uri));
		}
				
		public function getArg($index, $default = ""){
			$config = new Config;
	
			$uri = $_SERVER["REQUEST_URI"];
			
			if ($config->ignoreBaseDir){
				$uri = str_replace(strtolower($config->BaseDir),"",strtolower($uri));
			}
			$value = array_filter(explode("/", $uri));
			$value = $value[$index];
			return ($value != NULL ? $value : $default);
		}
		
		
				
		function __construct(){
			$args = $this->getArgs();
			if(!empty($args)){				
					if(file_exists("controller/".$args[1]."/control.".$args[1].".php")){
						$this->ControlPath = "controller/".$args[1]."/control.".$args[1].".php";
						$this->ControlName = $args[1];
						$this->ControlMethod = count($args) > 1 ? $args[2]: "index";
						
					}
					else{
						$this->ControlPath = "controller/home/control.home.php";
					 	$this->ControlName = "home";
						$this->ControlMethod = "index";
					}
					
				}
				else{
					$this->ControlPath = "controller/home/control.home.php";
				 	$this->ControlName = "home";
					$this->ControlMethod = "index";
 				}
	
		}
	
	}

?>
