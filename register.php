<?php 
include_once 'configuration.php';
include_once 'functions.php';

if(isset($_POST['register'])){

	if (checkUser($_POST['email'],$_POST['password'])==true){
		saveUser();
		header("location:_login.php");
	}else{
		print "User already exists!";
	}

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="Custom Login Form Styling with CSS3" />
<meta name="keywords"
	content="css3, login, form, custom, input, submit, button, html5, placeholder" />
<meta name="author" content="KI" />
<link rel="shortcut icon" href="../favicon.ico">

<title>Welcome to iOrder</title>

<!-- <link rel="stylesheet" type="text/css" href="css/style.css" /> -->
<!-- <script src="js/modernizr.custom.63321.js"></script> -->
<!-- <script src="js/vendor/custom.modernizr.js"></script> -->

<link rel="stylesheet" type="text/css" href="css/style.css" />
<link rel="stylesheet" href="css/normalize.css" />
<link rel="stylesheet" href="css/foundation.css" />
<link rel="stylesheet" href="css/custom.css" />



<!--[if lte IE 7]><style>.main{display:none;} .support-note .note-ie{display:block;}</style><![endif]-->
<style>
body {
	background: #e1c192 url(images/bg.jpg);
}
</style>
</head>



<body>
	<div class="container">

		<header>

			<h1>
				Welcome to the <strong>iOrder</strong> Login
			</h1>
			<h2>Please input your neccessary data for successfull sign up! Thank
				You</h2>

			<!-- 				<nav class="codrops-demos"> -->
			<!-- 					<a href="index.html">Demo 1</a> -->
			<!-- 					<a class="current-demo" href="index2.html">Demo 2</a> -->
			<!-- 					<a href="index3.html">Demo 3</a> -->
			<!-- 					<a href="index4.html">Demo 4</a> -->
			<!-- 					<a href="index5.html">Demo 5</a> -->
			<!-- 				</nav> -->

			<div class="support-note">
				<span class="note-ie">Sorry, only modern browsers.</span>
			</div>

		</header>


		<div class="row">

			<div class="large-5 columns">

				<form class="custom form-2"	name="testform" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
					<h1>
						<span class="log-in"><span class="sign-up">sign up</span>
					
					</h1>

					<label for="first_name"><i class="icon-user"></i>First Name</label>
					 <input type="text" id="first_name" name="first_name" placeholder="John"> 
					
					<label for="last_name"><i class="icon-user"></i>Last Name</label>
					<input type="text" id="last_name" name="last_name" placeholder="Smith"> 
					
					<label for="email"><i class="icon-user"></i>Email</label>
					<input type="text" id="email" name="email" placeholder="john.smith@mail.com">
					
					<label for="phone"><i	class="icon-user"></i>Phone</label>
					<input type="text" id="phone" name="phone" placeholder="031 555-555">  
					
					<label for="mobile"><i	class="icon-user"></i>Mobile</label>
					<input type="text"	id="mobile" name="mobile" placeholder="091 555-555"> 
					
					<label for="city"><i class="icon-user"></i>City</label> 
					
					<select name="cmbCity" id="cmbCity">
						<?php
						fillComboCity();
						?>
					</select>
					
					<label for="street"><i class="icon-user"></i>Street</label>
					 <select id="cmbStreet" name="cmbStreet">
<!-- 						fill from JSON (cityDB)  -->
					</select>
									
					<label for="streetNo"><i class="icon-user"></i>Street Number</label>
					<input type="text" id="streetNo" name="streetNo" placeholder="12b"	style="width: 50px">
					
					<label for="floor"><i class="icon-user"></i>Floor</label>
					<input type="text" id="floor" name="floor" placeholder="4" style="width: 50px">


					<label for="appartmentNo"><i class="icon-user"></i>Appartment Number</label>
					<input type="text" id="appartmentNo" name="appartmentNo" placeholder="12b" style="width: 50px"> 
					
					<label for="password"><i class="icon-lock"></i>Password</label>
					<input type="password"	id="password" name="password" placeholder="Password"> 
					
					<label for="password2"><i class="icon-lock"></i>Retype Password</label>
					<input id="password2" type="password" name="password2" placeholder="Password">

					<hr>

					<p class="clearfix">
<!-- 						<input type="submit" name="small button round success" value="Register...">  -->
						<a href="login.php" class="small button round success">Register</a>
						<a href="login.php" class="small button round alert">Cancel</a>
					</p>

				</form>
			</div>
		</div>
	</div>


	<!-- jQuery if needed -->
	<script type="text/javascript"
		src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
	<script type="text/javascript">
			$(function(){
			    $(".showpassword").each(function(index,input) {
			        var $input = $(input);
			        $("<p class='opt'/>").append(
			            $("<input type='checkbox' class='showpasswordcheckbox' id='showPassword' />").click(function() {
			                var change = $(this).is(":checked") ? "text" : "password";
			                var rep = $("<input placeholder='Password' type='" + change + "' />")
			                    .attr("id", $input.attr("id"))
			                    .attr("name", $input.attr("name"))
			                    .attr('class', $input.attr('class'))
			                    .val($input.val())
			                    .insertBefore($input);
			                $input.remove();
			                $input = rep;
			             })
			        ).append($("<label for='showPassword'/>").text("Show password")).insertAfter($input.parent());
			    });

			    $('#showPassword').click(function(){
					if($("#showPassword").is(":checked")) {
						$('.icon-lock').addClass('icon-unlock');
						$('.icon-unlock').removeClass('icon-lock');    
					} else {
						$('.icon-unlock').addClass('icon-lock');
						$('.icon-lock').removeClass('icon-unlock');
					}
			    });
			});
		</script>
</body>





<?php 

function checkUser($email, $pass){
	$flgCheck=true;
	
	try{
		$cn = new PDO(Conf::cnstring(), Conf::$dbuser, Conf::$dbpass);
		$cn->query("SET NAMES utf8");	
		$cm = $cn->prepare("select * from user where email =:email and pass=:password;");
		$cm->bindValue(":email",  $email);
		$cm->bindValue(":password",  $pass);
		$rs = $cm->execute();
		$rs = $cm->fetchAll(PDO::FETCH_OBJ);
		
		$total = $cm->rowCount();
		
		if($total>0){
			$flgCheck=false;
		}
		
	} catch (Exception $e) {
		print $e;
	}
		return $flgCheck;
		
}




function saveUser(){
	try{
		$cn = new PDO(Conf::cnstring(), Conf::$dbuser, Conf::$dbpass);
		$cn->query("SET NAMES utf8");
		
		$query="INSERT INTO user " .
		" (first_name,last_name,email,pass,phone,mobile,priviledges,city,street,street_no,floor,appartemnt_no,date_of_change,operator) " .
		" VALUES" .
		" (:first_name,:last_name,:email,:password,:phone,:mobile,1,:cmbCity,:cmbStreet,:cmbStreet,:floor,:appartmentNo,Now(),1);";
		
		$cm = $cn->prepare($query);	
		$cm->bindValue(":first_name",  $_POST['first_name']);
		$cm->bindValue(":last_name",  $_POST['last_name']);
		$cm->bindValue(":email",  $_POST['email']);
		$cm->bindValue(":password",  $_POST['password']);
		$cm->bindValue(":phone",  $_POST['phone']);
		$cm->bindValue(":mobile",  $_POST['mobile']);
		$cm->bindValue(":cmbCity",  $_POST['cmbCity']);
		$cm->bindValue(":cmbStreet",  $_POST['cmbStreet']);
		$cm->bindValue(":streetNo",  $_POST['streetNo']);
		$cm->bindValue(":floor",  $_POST['floor']);		
		$cm->bindValue(":appartmentNo",  $_POST['appartmentNo']);
		$rs = $cm->execute();	
		
			
// 		print $query . "<br>";
// 		while (list ($key,$val) = each ($_POST)) {
// 			// 		$cm->bindValue(":".$key,  $_POST['name']);
// 			echo "\$$key = $val";
// 			echo "<br>";
// 		}

	} catch (Exception $e) {
		print $e;
	}
	
	print "All OK!";
}









function fillComboCity(){
 

try{
	$cn = new PDO(Conf::cnstring(), Conf::$dbuser, Conf::$dbpass);
	$cn->query("SET NAMES utf8");
	$cm = $cn->prepare("select * from city");
	$rs = $cm->execute();
	$rs = $cm->fetchAll(PDO::FETCH_OBJ);
	$total = $cm->rowCount();


		$selectCity="city";
		if (isset ($selectCity)&&$$selectCity!=""){
			$selectCity=$_POST ['NEW'];
		}

?>
<option value="0">--- Select ---</option>
<?php 
	
	
	foreach ($rs as $row){
		?>
		
		<option value="<?php echo $row->id; ?>"
		<?php if($row->id==$selectCity){ echo "selected"; } ?>>
			<?php echo $row->city_name;?>
		</option>

<?php

	}
	

	} catch (PDOException $e) {
		echo $e;
	}
	
	echo "SELECTED: " . $select;
	
} 

?>










<script type="text/javascript">

$(document).ready(function() {
	 $("#cmbCity").change(function(){
		   var id = $(this).val();
		   
		   $("#cmbStreet").prop("disabled","disable");


		  $.post("/iorder/cityDB.php", { cityId: id},
				   function(data) {
				       data=$.parseJSON(data);
				       //alert(data.desc);
				       $.each(data, function(i,item){
				    	   $('<option>').val(item.id).text(item.street_name).appendTo('#cmbStreet');
				      // alert(item.id);
				       });
				   })
				   .success(function(){
					   $("#cmbStreet").prop("disabled",false);
					   })
				   .error(function(){
					   alert('There was problem loading portfolio details.');
					   })
				   .complete(function(){});



		
		   return false;
	});

		
	});
  
</script>

</html>
