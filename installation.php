<?php 
error_reporting("E_ALL & ~E_NOTICE");

initConfig();

include 'configuration.php';


$host= gethostname();
$myip = gethostbyname($host);
$mySQLFile = "." . Conf::$dataroot ."/". Conf::$dbname .".sql";		//configuration??

//get myIP
define ("myIP", $myip);
define("appName", "iOrder");	
define("appVer", "0.0.1");

static $errors="";


if(isset($_POST['submit'])){
	$errors =checkData(); 
   	if (strlen($errors)==0){
  		saveConfigFile();
 	 	checkDir($_POST["rootdir"] . "/iOrder_framework" .  $_POST["dataroot"]);
	 	
	 	uploadDBfile();
	 	
 		if(isset($_POST['dbprefix'])){
 			 			
 			$mySQLFile = addPrefixes($mySQLFile, "TABLE ", "TABLE " . $_POST["dbprefix"]);
 			$mySQLFile = addPrefixes($mySQLFile, "REFERENCES ", "REFERENCES " . $_POST["dbprefix"]);
			
 			//TODO: add prefix for insert & functions and other SQLs 
 		}
 		initializeDatabase($mySQLFile);
		
  	}else{
		//error handling
 	}

}
?>


<!DOCTYPE html>
<!--[if IE 8]> 				 <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="en">
<!--<![endif]-->

<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width" />
<title>iOrder Installation</title>

<link rel="stylesheet" href="css/normalize.css" />
<link rel="stylesheet" href="css/foundation.css" />

<script src="js/vendor/custom.modernizr.js"></script>

</head>


<body style="background: #ebffef;">

			<div class="panel callout radius">
              <h5 align="center">iOrder installation.</h5>
              <p align="center">For successful insatllation, please take your time and fill this data correctly.</p>              
            </div>
	
	
			<?php 
			if(strlen($errors)>0){
			?>
			
			
			

			<div class="row">
				<div class="small-12 columns">
					<div class="alert-box alert round" align="center">
			  			<?php echo $errors;?>
			  				<a href="" class="close">&times;</a>
					</div>
				</div>
			</div>
			<?php }?>
			
			
			
	
	<div class="row">
		<div class="large-12 columns" align="center">
			<form enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
				<fieldset>

					<legend>Set configuration parameters</legend>

					<div class="row">
						<div class="small-12 columns">
							<div class="small-2 columns">
								<label for="webaddress" class="right inline">Web address</label>
<!-- 								<span data-tooltip class="has-tip right inline" title="Tooltips are awesome, you should totally use them!">Web address</span> -->
							</div> 
							<div class="small-10 columns">
								<input type="text" id="webaddress" name="webaddress" placeholder="http://localhost/" value=<?php echo myIP?> style="background-color: silver" disabled="disabled">
								
							</div>
						</div>
					</div>
										
					<div class="row">
						<div class="small-12 columns">
							<div class="small-2 columns">
								<label for="rootdir" class="right inline"><?php echo appName?> directory</label>
							</div> 
							<div class="small-10 columns">
								<input type="text" id="rootdir" name="rootdir" placeholder="C:\xampp\htdocs\"<?php echo appName?> value=<?php echo $_SERVER['DOCUMENT_ROOT']?> style="background-color: silver;" readonly="readonly">
							</div>
						</div>
					</div>
	
					<div class="row">
						<div class="small-12 columns">
							<div class="small-2 columns">
								<label for="dataroot" class="right inline">Data directory</label>
							</div> 
							<div class="small-6 columns">
								<input type="text" id="dataroot" name="dataroot" placeholder="/DATA" value="<?php if(isset($_POST["dataroot"])) echo $_POST["dataroot"]?>" maxlength="50"> 
							</div>
							<div class="small-4 columns">
<!-- 								<span class="alert label">Alert Label</span> -->
							</div>
							
						</div>
					</div>

				</fieldset>

				<fieldset>
					<legend>Set mySQL parameters</legend>
					
					<div class="row">
						<div class="small-12 columns">
							<div class="small-2 columns">
								<label for="dbhost" class="right inline">Database Host</label>
							</div> 
							<div class="small-10 columns">
								<input type="text" id="dbhost" name="dbhost" placeholder="localhost" value="<?php if(isset($_POST["dbhost"])) echo $_POST["dbhost"]?>" maxlength="50">
							</div>
						</div>
					</div>
					
					
					<div class="row">
						<div class="small-12 columns">
							<div class="small-2 columns">
								<label for="dbname" class="right inline">Database Name</label>
							</div> 
							<div class="small-10 columns">
								<input type="text" id="dbname" name="dbname" placeholder="iorder" value="<?php if(isset($_POST["dbname"])) echo $_POST["dbname"]?>" maxlength="50">
							</div>
						</div>
					</div>
					
					
					<div class="row">
						<div class="small-12 columns">
							<div class="small-2 columns">
								<label for="dbuser" class="right inline">User</label>
							</div> 
							<div class="small-10 columns">
								<input type="text" id="dbuser" name="dbuser" placeholder="admin" value="<?php if(isset($_POST["dbuser"])) echo $_POST["dbuser"]?>" maxlength="50">
							</div>
						</div>
					</div>
					
					<div class="row">
						<div class="small-12 columns">
							<div class="small-2 columns">
								<label for="dbpass" class="right inline">Password</label>
							</div> 
							<div class="small-10 columns">
								<input type="password" id="dbpass" name="dbpass" placeholder="test123." value="<?php if(isset($_POST["dbpass"])) echo $_POST["dbpass"]?>" maxlength="50">
							</div>
						</div>
					</div>
					
					<div class="row" align="left">
						<div class="small-12 columns">
							<div class="small-2 columns">
								<label for="dbprefix" class="right inline">DB Prefix </label>
							</div> 
							<div class="small-10 columns" >
								<input type="text" id="dbprefix" name="dbprefix" placeholder="<?php echo appName?>_" value="<?php if(isset($_POST["dbprefix"])) echo $_POST["dbprefix"]?>" maxlength="50">
							</div>
						</div>
					</div>
					
					
					<hr>
					
					<div class="row" >
						<div class="small-12 columns">
							<div class="small-2 columns">
								<label for="sql" class="right inline">Database bringup</label>
							</div> 
							<div class="small-9 columns">
 								<input type="file" class="button secondary round expand tiny" id="mysqlfile" accept="text/plain" name="mysqlfile" maxlength="150"/> 															
							</div>				
							<div class="small-1 columns">
								<label for="sql" class="right inline">(txt,sql)</label>
							</div>							
						</div>
					</div>

				</fieldset>

				<input type="submit" class="button round expand" id="submit" name="submit" value="Submit configuration" />
			
			</form>
			

}
			
			?>
			
			<div id="loading" >
				<p>
				<img src="images/loading.gif">
				Please Wait
				</p>
			</div>



		</div>
	</div>

	

</body>



<?php 
function checkData(){
	include_once 'functions.php';
	
	$errors="";
	
	if (checkText("Data directory", $_POST["dataroot"], 2, 50)==false){
		$errors=$errors . "Please fill out 'Data Directory' field!<br>";
	};
	
	if (checkText("Database Host", $_POST["dbhost"], 2, 50)==false){
		$errors= $errors . "Please fill out 'Database Host' field!<br>";
	};
	
	if (checkText("User", $_POST["dbuser"], 2, 50)==false){
		$errors= $errors . "Please fill out 'Database User' field!<br>";
	};
		
	if (checkText("Password", $_POST["dbpass"], 2, 50)==false){
		$errors= $errors . "Please fill out 'Database Password' field!<br>";
	};
	
// 	if (checkText("Password", $_POST["dbprefix"], 2, 50)==false){
// 		$errors= $errors ."Please fill out 'Database Prefix' field!<br>";
// 	};
	
  	return $errors;
	
}


//initial createing of configuration
function initConfig(){

$File = "configuration.php";
$Handle = fopen($File, 'w');

$Data = "<?php" ."\n";
fwrite($Handle, $Data);

$Data = "class Conf{\n";
fwrite($Handle, $Data);

$Data = "public static \$rootdir = '". $_POST["rootdir"] ."';\n";
fwrite($Handle, $Data);

$Data = "public static \$dataroot = '". $_POST['dataroot'] ."';\n";
fwrite($Handle, $Data);

$Data = "public static \$host='" . $_POST['dbhost'] ."';\n";
fwrite($Handle, $Data);

$Data = "public static \$dbname='" . $_POST['dbname'] ."';\n";
fwrite($Handle, $Data);

// 	$Data = "\$cnstring ='mysql:dbname='. \$dbname .';host='. \$host .';charset=utf-8'" . ";\n";
// 	fwrite($Handle, $Data);

$Data = "public static \$dbuser = '". $_POST['dbuser'] ."'" . ";\n";
fwrite($Handle, $Data);

$Data = "public static \$dbpass = '". $_POST['dbpass'] ."';\n";
fwrite($Handle, $Data);

$Data = "public static \$dbprefix = '". $_POST['dbprefix'] ."';\n\n";
fwrite($Handle, $Data);

$Data = "public static function cnstring(){\n";
fwrite($Handle, $Data);

$Data = "return 'mysql:dbname=' . self::\$dbname .' ;host=' . self::\$host.';charset=utf-8';\n";
fwrite($Handle, $Data);

$Data = "}\n\n";
fwrite($Handle, $Data);

$Data = "}\n";
fwrite($Handle, $Data);
}



//update configuration file
function saveConfigFile(){
// 	print "save files!";
$File = "configuration.php";
$Handle = fopen($File, 'w');

$Data = "<?php" ."\n";
fwrite($Handle, $Data);

$Data = "class Conf{\n";
fwrite($Handle, $Data);

$Data = "public static \$rootdir = '". $_POST["rootdir"] ."';\n";
fwrite($Handle, $Data);

$Data = "public static \$dataroot = '". $_POST['dataroot'] ."';\n";
fwrite($Handle, $Data);

$Data = "public static \$host='" . $_POST['dbhost'] ."';\n";
fwrite($Handle, $Data);

$Data = "public static \$dbname='" . $_POST['dbname'] ."';\n";
fwrite($Handle, $Data);

// 	$Data = "\$cnstring ='mysql:dbname='. \$dbname .';host='. \$host .';charset=utf-8'" . ";\n";
// 	fwrite($Handle, $Data);

$Data = "public static \$dbuser = '". $_POST['dbuser'] ."'" . ";\n";
fwrite($Handle, $Data);

$Data = "public static \$dbpass = '". $_POST['dbpass'] ."';\n";
fwrite($Handle, $Data);

$Data = "public static \$dbprefix = '". $_POST['dbprefix'] ."';\n\n";
fwrite($Handle, $Data);

$Data = "public static function cnstring(){\n";
fwrite($Handle, $Data);

$Data = "return 'mysql:dbname=' . self::\$dbname .' ;host=' . self::\$host.';charset=utf-8';\n";
fwrite($Handle, $Data);

$Data = "}\n\n";
fwrite($Handle, $Data);

$Data = "}\n";
fwrite($Handle, $Data);
	
// 	print "Configuration file successfully written.";
	fclose($Handle);
}




//TODO: kako dodati prefixe na sve potrebno 
function addPrefixes($path, $string, $replace){
// 	include 'configuration.php';
	
	$newPath = "." . Conf::$dataroot . "/" . Conf::$dbname . "_PREFIX.sql";		//backup original

// 	print "PATH: " . $path . "<br>";
// 	print "NEW PATH: " . $newPath . "<br>";
	
	copy($path, $newPath);
    set_time_limit(0);
    
    if (is_file($newPath) === true){
        $file = fopen($newPath, 'r');
        $temp = tempnam('./', 'tmp');

        if (is_resource($file) === true) {
            while (feof($file) === false){
                file_put_contents($temp, str_replace(strtoupper($string), strtoupper($replace), strtoupper(fgets($file))), FILE_APPEND);
            }
            fclose($file);
        }
        unlink($newPath);
    }
    rename($temp, $newPath);
      
    return $newPath; 
}



//initialize, import data in SQL 
function initializeDatabase($mySQLFile){
// include 'configuration.php';
	
// print "load from SQL: " . $mySQLFile . "<br>";

$fh = fopen($mySQLFile, 'r');
$theData = fread($fh,5000);
fclose($fh);

//  print "data: " . $theData ."<br>";
//  print "CN: " . $cnstring ."<br>";

try {
	$cn = new PDO('mysql:dbname=test;host='. Conf::$host .';charset=utf-8', Conf::$dbuser, Conf::$dbpass);
	$cn->query("SET NAMES utf8");
	$cm = $cn->prepare($theData);
	$rs = $cm->execute();
	
	$cn=null;

} catch (PDOException $e) {
  		 print $e->getMessage();
	}
}



function checkDir($dirPath){
	if (!is_dir($dirPath)) {
		mkdir($dirPath);
	}
}





function uploadDBfile (){
// 	include 'configuration.php';
	
	$valid_file = true;

		
// 	print $_FILES['mysqlfile']['name'];
	
	if($_FILES['mysqlfile']['name']){
		//if no errors...
		
// 		if ($_FILES["file"]["type"] != "sql"){
// 			$msg = "Error while upload!!! Return Code: " . $_FILES["file"]["error"] ."<br>";
// 			print $msg;
// 			$valid_file=false;
// 		}else{
// 			print "extension OK!";
// 		}
				
		if(!$_FILES['mysqlfile']['error']){
			
// 			print "nema errora<br>";
			
			//now is the time to modify the future file name and validate the file
			$new_file_name = strtolower($_FILES['mysqlfile']['tmp_name']); //rename file
			
// 			print "dalje <br>";
// 			print $_FILES['mysqlfile']['tmp_name'] . "<br>";
			
			if($_FILES['mysqlfile']['size'] > (1024000)) {//can't be larger than 1 MB
// 				print "veće je od 1mB <br>";
				$valid_file = false;
// 				print 'Oops!  Your file\'s size is to large.';
			}
	
			//if the file has passed the test
			if($valid_file)
			{
				//move it to where we want it to be
// 				print $dataroot . "/test.sql";
// 				print "." .  $dataroot . "/" . $dbname . ".sql";
				
				move_uploaded_file($_FILES['mysqlfile']['tmp_name'], "." .  Conf::$dataroot . "/" . Conf::$dbname . ".sql");
// 				print 'Congraftulations!  Your file was uploaded.';
			}
		}
		//if there is an error...
		else
		{
			print "error";
			//set that to be the returned message
			print 'Ooops!  Your upload triggered the following error:  '.$_FILES['mysqlfile']['error'];
		}
	}
	
// 	return $message;
	
}




function display_filesize($filesize){
	if(is_numeric($filesize)){
		$decr = 1024; $step = 0;
		$prefix = array('Byte','KB','MB','GB','TB','PB');

		while(($filesize / $decr) > 0.9){
			$filesize = $filesize / $decr;
			$step++;
		}
		return round($filesize,2).' '.$prefix[$step];
	} else {

		return 'NaN';
	}
}




function loadSQLfile($my_file){
// 	include_once 'configuration.php';
	// 	print $my_file . "<br>";

	if (file_exists($my_file)) {
		$fh = fopen($myFile, 'r');
		$theData = fread($fh,5000);
		fclose($fh);

// 		print $theData;

	} else {

		print "No file to display <br>";
		// 		echo "No file to display <br>";
	}
}


?>


	<!-- Included JS Files (Compressed) -->
	<script src="../javascripts/foundation.min.js"></script>

	<!-- Initialize JS Plugins -->
	<script src="../javascripts/app.js"></script>


<script type='text/javascript'>
function showLoading() {
$("#loading").show();
}

function hideLoading() {
$("#loading").hide();
}

</script>




</html>
