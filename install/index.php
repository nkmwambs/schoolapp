<?php
session_start();

error_reporting(0); //Setting this to E_ALL showed that that cause of not redirecting were few blank lines added in some php files.
$db_config_path = '../application/config/database.php';

//define(BASEPATH,dirname(__DIR__));


// Only load the classes in case the user submitted the form
if($_POST) {

	// Load the classes and create the new objects
	require_once('includes/core_class.php');
	require_once('includes/database_class.php');
	//require_once('includes/config.php');

	$core = new Core();
	$database = new Database();


			// Validate the post data
			//if($core->validate_post($_POST) == true)
			//{

				if(isset($_POST['next'])){
						// First create the database, then create tables, then write config file
						$db_create = $database->create_database($_POST);

						if($db_create['success'] == false) {
							$message = $core->show_message('error', $db_create['msg']);
						} else if ($database->create_tables($_POST) == false) {
							$message = $core->show_message('error',"The database tables could not be created, please verify your settings.");
						}
						// else if ($core->write_config($_POST) == false) {
						// 	$message = $core->show_message('error',"The database configuration file could not be written, please chmod install/config/database.php file to 777");
						// }

						// If no errors, redirect to login page
						if(!isset($message)) {
						  	$_SESSION['db_param'] = $_POST;
						}
				}elseif (isset($_POST['set_admin'])) {


					//include(BASEPATH.'/install/config/database.php');

					$mysqli = new mysqli($_SESSION['db_param']['hostname'],$_SESSION['db_param']['db_user'],$_SESSION['db_param']['db_password'],$_SESSION['db_param']['db_name']);


					foreach($_POST as $key=>$value){
							// $sql = "UPDATE settings SET description='".$value."' WHERE type='".$key."'";
							//
							// if(!$mysqli){
							// 	$message = $core->show_message('error','Cannot connect to the database.');
							// }else{
							// 	$mysqli->query($sql);
							// }

							$sql = "INSERT INTO admin VALUES()";

					}



					if(!isset($message)){

						//$_SESSION['advance'] = FALSE;
						//$_SESSION['db_param'] = "";

						$redir = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
						$redir .= "://".$_SERVER['HTTP_HOST'];
						$redir .= str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);
						$redir = str_replace('install/','',$redir);
						header( 'Location: ' . $redir) ;
					}


				}elseif(isset($_POST['finish'])){
						//include(BASEPATH.'/install/config/database.php');

						$mysqli = new mysqli($_SESSION['db_param']['hostname'],$_SESSION['db_param']['db_user'],$_SESSION['db_param']['db_password'],$_SESSION['db_param']['db_name']);


						foreach($_POST as $key=>$value):
								$sql = "UPDATE settings SET description='".$value."' WHERE type='".$key."'";

								if(!$mysqli){
									$message = $core->show_message('error','Cannot connect to the database.');
								}else{
									$mysqli->query($sql);
								}

						endforeach;



						if(!isset($message)){

							//$_SESSION['advance'] = FALSE;
							//$_SESSION['db_param'] = "";

							$redir = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
							$redir .= "://".$_SERVER['HTTP_HOST'];
							$redir .= str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);
							$redir = str_replace('install/','',$redir);
							header( 'Location: ' . $redir) ;
						}
				}
			//}
			//else {
				//$message = $core->show_message('error','Not all fields have been filled in correctly. The host, username, database name are required.');
			//}

			//if($_SESSION['advance']===TRUE){

			//}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<script src="assets/js/jquery-1.7.1.min.js"></script>
		<script src="assets/js/jquery.validate.min.js"></script>
		<script src="assets/js/script.js"></script>
		<link href="assets/css/style.css" rel="stylesheet">
		<title>Sign Up | Techsys Systems</title>
	</head>
	<body>

    <?php if(is_writable($db_config_path)){?>

		  <form id="install_form" class="smart-blue" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
		  <h1>Schoolapp Sign Up</h1>
		  <?php
		  		if(isset($message)) {echo '<p class="alert alert-danger">' . $message . '</p>';}
		  		if(isset($_GET['e'])){
		  			$error = $_GET['e'];
		  			if($error == 'folder'){
		  				echo '<p class="alert alert-danger">Please delete or rename the <b>INSTALL FOLDER</b> to disable the installation script and then <a href="../"> Go to system</a></p>';
		  			}
		  			elseif ($error == 'db') {
		  				echo '<p class="alert alert-danger">The specified database does not exist, please set the correct database in <b> application/config/database.php </b> or run the installer again !!</p>';
		  			}
		  		}
		 if(!isset($_POST['next']) && !isset($_POST['set_admin'])){
		  ?>

		  	<h3>initialization (Step 1/3)</h3>
					<span>
							Click on the "Initialize" button to begin signing up
					</span>
          	<input type="hidden" id="hostname" value="localhost" class="input_text" name="hostname" />
          	<!-- <input type="hidden" id="db_name" value="schoolapp_12" class="input_text" name="db_name" /> -->
          	<input type="hidden" id="db_user" value="<?=$config['db_user'];?>" class="input_text" name="db_user" />
          	<input type="hidden" id="db_password" value="<?=$config['db_password'];?>" class="input_text" name="db_password" />
			<input type="submit" name="next" value="Initialize" class="button" id="submit" style="float:right"/>
		<?php
	}elseif (!isset($_POST['set_admin'])) {
	?>
		<h3>Setup Admin User (Step 2/3)</h3>
		<label for="First Name">First Name</label><input type="text" id="firstname" value="<?php echo (isset($_POST['firstname'])) ? $_POST['firstname']: ''; ?>" class="input_text" name="firstname" />
		<label for="Last Name">Last Name</label><input type="text" id="lastname" value="<?php echo (isset($_POST['lastname'])) ? $_POST['lastname'] : ''; ?>" class="input_text" name="lastname" />
		<label for="Email">Email</label><input type="email" id="email" value="<?php echo (isset($_POST['email'])) ? $_POST['email'] : ''; ?>" class="input_text" name="email" />
		<label for="Password">Password</label><input type="password" id="password" value="<?php echo (isset($_POST['password'])) ? $_POST['password'] : ''; ?>" class="input_text" name="password" />
		<label for="Confirm Password">Confirm Password</label><input type="password" id="confirm_password" value="<?php echo (isset($_POST['confirm_password'])) ? $_POST['confirm_password'] : ''; ?>" class="input_text" name="confirm_password" />
		<input type="submit" name="set_admin" value="Set Admin User" class="button" id="set_admin" style="float:right"/>
	<?php
	}elseif(!isset($_POST['finish'])){
			//print_r($_SESSION['db_param']);
		?>
			<h3>System Details (Step 3/3)</h3>
          	<label for="system_name">System Name</label><input type="text" id="system_name" value="<?php echo (isset($_POST['system_name'])) ? $_POST['system_name'] : ''; ?>" class="input_text" name="system_name" />
          	<label for="system_title">System Title</label><input type="text" id="system_title" value="<?php echo (isset($_POST['system_title'])) ? $_POST['system_title'] : ''; ?>" class="input_text" name="system_title" />
          	<label for="address">Address</label><input type="text" id="address" value="<?php echo (isset($_POST['address'])) ? $_POST['address'] : ''; ?>" class="input_text" name="address" />
          	<label for="phone">Phone Number</label><input type="text" id="phone" value="<?php echo (isset($_POST['phone'])) ? $_POST['phone'] : ''; ?>" class="input_text" name="phone" />
          	<label for="system_email">E-Mail</label><input type="text" id="system_email" value="<?php echo (isset($_POST['system_email'])) ? $_POST['system_email'] : ''; ?>" class="input_text" name="system_email" />
			<label for="text_align">Text Alignment</label><input type="text" id="text_align" value="left-right" class="input_text" name="text_align" />
			<label for="skin_colour">Skin Color</label><input type="text" id="skin_colour" value="Black" class="input_text" name="skin_colour" />
			<input type="submit" name="finish" value="Finish" class="button" id="submit" style="float:right"/>
		<?php
		}
		?>




	 		<div class="clr"></div>

	 	</form>

	 <?php

		} else { ?>
      <p class="alert alert-danger">Please make the application/config/database.php file writable. <strong>Example</strong>:<br /><br /><code>chmod 777 application/config/database.php</code></p>
	  <?php } ?>
	</body>
</html>
