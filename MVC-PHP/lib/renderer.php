<?php 

	class Renderer{
	
		public function RenderPage(){
			$request = new Request;
		
			if (file_exists($request->ControlPath)) {
				require_once($request->ControlPath);					
				$temp = new $request->ControlName;
				if(method_exists($temp, $request->ControlMethod)){
					call_user_func(array($temp,$request->ControlMethod) );
				} 
				else {
					echo 'Error: Controller "'.$request->ControlName.'" method "'.$request->ControlMethod.'" does not exist.';
				}
			} 
			else {
				echo "Error: Controller filename (".$request->ControlPath.") does not exist";
			}
		}
	}

?>
