<?php 
session_start();
	class Controller{	
		var $userinfo;
		
		public function RenderView($controller, $layout, $filename, $title){
	   	    $LayoutPath = 'layouts/'.$layout.'.php';
			$view = 'controller/'.$controller.'/view.'.$filename.'.php';
			
	    	$body = $view;
	    		    		
	    	if(file_exists($LayoutPath)) {
	    		include($LayoutPath);
	    	} else {
	    		echo "Error: No Layout ";
	    	}
	
		}
		
		function authorised($provider){
		 	
				$config = dirname(__FILE__) . '\hybridauth\config.php';
			   	require_once( "lib/hybridauth/Hybrid/Auth.php" );
			 
				   try{
				       $hybridauth = new Hybrid_Auth( $config );
				       $cloudID = $hybridauth->authenticate( $provider );
				       $user_profile = $cloudID->getUserProfile();				       
					  $this->create_user($provider, $user_profile->displayName, $user_profile->firstName, $user_profile->lastName, $user_profile->email, $user_profile->birthYear.'-'.$user_profile->birthMonth.'-'.$user_profile->birthDay, $user_profile->gender, $user_profile->photoURL);
				      return true;
				   }
				   catch( Exception $e ){
				   		echo "Ooophs, we got an error: " . $e->getMessage();
				   }
			 
	   			   
			   return false;
			   
		}
		
		function facebookfeedpost($message, $pagename, $caption, $pictureURL, $link){
			$config = dirname(__FILE__) . '\hybridauth\config.php';			
			require_once( "lib/hybridauth/Hybrid/Auth.php" );
			$hybridauth = new Hybrid_Auth();
			$facebook = $hybridauth->authenticate("Facebook");
   
			$facebook->api()->api("/me/feed", "post", array(
		      "message" => $message,
		      "picture" => $pictureURL,
		      "link"    => $link,
		      "name"    => $pagename,
		      "caption" => $caption
			));

			
		}


		function twitterstatuspost($message){
			$hybridauth = new Hybrid_Auth();			 
			// try to authenticate with twitter
			$adapter = $hybridauth->authenticate( "Twitter" );
			// update the user status
			$adapter->setUserStatus($message); 
		}  
  

		function create_user($IDProvider, $displayname, $firstname, $lastname, $email, $dob, $gender, $photoURL){
			//Creates user if not exists
			$db = new database(new config);
			
			$userID = 0;
			$sql = 'select uID from user where uEmail="'.$email.'" and uFirstName="'.$firstname.'" and uDOB="'.$dob.'"';
			$userID = $db->queryScalar($sql,-1);
			echo $userID.'<br />';
			echo $sql;
			if($userID == -1){
				//user does not exist
				$sql = 'insert into user (uDisplayName, uEmail, uFirstname, uLastName, uDOB, uGender, uPhotoURL) values("'.$displayname.'","'.$email.'","'.$firstname.'","'.$lastname.'", "'.$dob.'", "'.$gender.'", "'.$photoURL.'")';
				$db->query($sql);
				
				$_SESSION['UserID'] = $db->insert_id();
				$_SESSION['DisplayName'] = $displayname;
				$_SESSION['IDProvider'] = $IDProvider;

			}
			else{
				//user exists
				$_SESSION['UserID'] = $userID;
				$_SESSION['DisplayName'] = $displayname;
				$_SESSION['IDProvider'] = $IDProvider;
	
			}
			//echo $_SESSION['userID'];

		}

		
	}
	
?>
