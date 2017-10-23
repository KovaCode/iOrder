<?php 
// error_reporting();
if(isset($_POST['next'])){
	
	print "ušao!";
	saveConfigFile();
	
// 	checkDB();
	
	importData();
}

?>

<!doctype html>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if IE 9]>    <html class="no-js ie9" lang="en" itemscope itemtype="http://schema.org/Product"> <![endif]-->
<!-- Consider adding an manifest.appcache: h5bp.com/d/Offline -->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="en" itemscope
	itemtype="http://schema.org/Product">
<!--<![endif]-->
<head>
<meta charset="utf-8">

<!-- Use the .htaccess and remove these lines to avoid edge case issues.
       More info: h5bp.com/b/378 -->
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

<title>Installation</title>
<meta name="description" content="" />
<meta name="keywords" content="" />
<meta name="author" content="humans.txt">

<link rel="shortcut icon" href="favicon.png" type="image/x-icon" />
<link rel="shortcut icon" href="theme/standard/pix/favicon.ico" />
<link rel="stylesheet" type="text/css" href="http://localhost/moodle/install/css.php" />
<title>Installation</title>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<meta http-equiv="pragma" content="no-cache" />
<meta http-equiv="expires" content="0" />

<!--Facebook Metadata /-->
<meta property="fb:page_id" content="" />
<meta property="og:image" content="" />
<meta property="og:description" content="" />
<meta property="og:title" content="" />

<!--Google+ Metadata /-->
<meta itemprop="name" content="">
<meta itemprop="description" content="">
<meta itemprop="image" content="">

<!-- Mobile viewport optimized: j.mp/bplateviewport -->
<meta name="viewport" content="width=device-width,initial-scale=1">

<!-- Place favicon.ico and apple-touch-icon.png in the root directory: mathiasbynens.be/notes/touch-icons -->

<!-- CSS: implied media=all -->
<!-- CSS concatenated and minified via ant build script-->
<!-- <link rel="stylesheet" href="css/minified.css"> -->

<!-- CSS imports non-minified for staging, minify before moving to production-->
<link rel="stylesheet" href="css/imports.css">
<!-- end CSS-->

<!-- More ideas for your <head> here: h5bp.com/d/head-Tips -->

<!-- All JavaScript at the bottom, except for Modernizr / Respond.
       Modernizr enables HTML5 elements & feature detects; Respond is a polyfill for min/max-width CSS3 Media Queries
       For optimal performance, use a custom Modernizr build: www.modernizr.com/download/ -->
<script src="js/libs/modernizr-2.0.6.min.js"></script>




</head>
<body style="background: #ebffef;">
		<div id="twelve columns">
			<h2>Confirm paths</h2>
			<div class="stage generalbox box">
				<dl>
					<dt>Web address</dt>
					<dd>Full web address where Moodle will be accessed. It's not
						possible to access Moodle using multiple addresses. If your site
						has multiple public addresses you must set up permanent redirects
						on all of them except this one. If your site is accessible both
						from Intranet and Internet use the public address here and set up
						DNS so that the Intranet users may use the public address too. If
						the address is not correct please change the URL in your browser
						to restart installation with a different value.</dd>
					<dt>Moodle directory</dt>
					<dd>Full directory path to Moodle installation.</dd>
					<dt>Data directory</dt>
					<dd>You need a place where Moodle can save uploaded files. This
						directory should be readable AND WRITEABLE by the web server user
						(usually 'nobody' or 'apache'), but it must not be accessible
						directly via the web. The installer will try to create it if
						doesn't exist.</dd>
				</dl>
			</div>
			
			
			
			<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
				<fieldset>
						<input type="hidden" name="lang" value="en" /> 
						<input type="hidden" name="stage" value="2" />
						<input type="hidden" name="dbtype" value="" /> 
						<input type="hidden" name="dbhost" value="localhost" />
						<input type="hidden" name="dbuser" value="" />
						<input type="hidden" name="dbpass" value="" />
						<input type="hidden" name="dbname" value="moodle" />
						<input type="hidden" name="prefix" value="mdl_" />
						<input type="hidden" name="dbsocket" value="0" />
						<input type="hidden" name="admin" value="admin" />
						<input type="hidden" name="dataroot" value="C:\xampp\moodledata" />
					
					
					<div class="userinput">
						<div class="formrow">
							<label for="id_wwwroot" class="formlabel">Web address</label>
							<input	id="id_wwwroot" name="wwwroot" type="text" value="http://localhost/moodle" disabled="disabled" size="70"class="forminput" />
						</div>
						
						<div class="formrow">
							<label for="id_dirroot" class="formlabel">Moodle directory</label><input
								id="id_dirroot" name="dirroot" type="text"
								value="C:\xampp\htdocs\moodle" disabled="disabled" size="70"
								class="forminput" />
						</div>
						
						<div class="formrow">
							<label for="id_dataroot" class="formlabel">Data directory</label><input
								id="id_dataroot" name="dataroot" type="text"
								value="C:\xampp\moodledata" size="70" class="forminput" />
						</div>
	
						
						<div class="formrow">
							<label for="id_dbhost" class="formlabel">Database host</label>
							<input id="id_dbhost" name="dbhost" type="text" value="localhost" size="50" class="forminput" />
						</div>
						<div class="formrow">
							<label for="id_dbname" class="formlabel">Database name</label>
							<input id="id_dbname" name="dbname" type="text" value="moodle" size="50" class="forminput" />
						</div>
						<div class="formrow">
							<label for="id_dbuser" class="formlabel">Database user</label>
							<input id="id_dbuser" name="dbuser" type="text" value="" size="50" class="forminput" />
						</div>
						<div class="formrow">
							<label for="id_dbpass" class="formlabel">Database password</label><input
								id="id_dbpass" name="dbpass" type="text" value="" size="50"
								class="forminput" />
						</div>
						<div class="formrow">
							<label for="id_prefix" class="formlabel">Tables prefix</label><input
								id="id_prefix" name="prefix" type="text" value="mdl_" size="10"
								class="forminput" />
						</div>
						<div class="hint"></div>
					</div>
				</fieldset>
				
				
				
				<fieldset id="nav_buttons">
					<input type="submit" class="secondary btn" style="color:white" id=next name="next" value="Configure" />
				</fieldset>
			</form>
		</div>

</body>

<?php 
function saveConfigFile(){
	$File = "configuration.php";
	$Handle = fopen($File, 'w');
	
	
	$Data = "<?php" ."\n";
	fwrite($Handle, $Data);
	
	$Data = "\$baza='" . $_POST['dbname'] ."';\n";
	fwrite($Handle, $Data);
	
	$Data = "\$dsn ='mysql:dbname='. \$baza .';host=127.0.0.1;charset=utf-8'" . ";\n";
	fwrite($Handle, $Data);
	
	$Data = "\$user = '". $_POST['dbuser'] ."'" . ";\n";
	fwrite($Handle, $Data);	
	
	$Data = "\$password = '". $_POST['dbpass'] ."'" . ";\n";
	fwrite($Handle, $Data);
	
	print "Data Written";
	fclose($Handle);
}




function importData(){

include_once 'configuration.php';

try {
	$veza = new PDO($dsn, $user, $password);
	$veza->query("SET NAMES utf8");
	$izraz = $veza->prepare("");
	$rez = $izraz->execute();

	//zatvaranje veze s bazom
	$veza=null;
	} catch (PDOException $e) {
		echo $e;
	}
}
	
?>


</html>
