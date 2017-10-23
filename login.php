<?php 
include_once 'configuration.php';

$errors = "";
if(isset($_POST['submit'])){
	if(isset($_POST['email']) &&  isset($_POST['password'])){
		checkLogin($_POST['email'],$_POST['password']);
	}
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<link rel="shortcut icon" href="../favicon.ico">

<title>Welcome to iOrder</title>

<link rel="stylesheet" type="text/css" href="css/style.css" />

<!-- <script src="js/modernizr.custom.63321.js"></script> -->
<link rel="stylesheet" href="css/normalize.css" />
<link rel="stylesheet" href="css/foundation.css" />
<!-- <link rel="stylesheet" href="css/custom.css" /> -->
<!-- <link rel="stylesheet" type="text/css" href="css/style.css" /> -->
<!-- <script src="js/vendor/custom.modernizr.js"></script> -->

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
				Welcome to the iOrder <strong>Login</strong> 
			</h1>
			<h2>Please input your email & password</h2>
			<hr>
			

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


		
		<?php 
// 			if(strlen($errors)>0){
// 			?>

<!-- 			<div class="row"> -->
<!-- 				<div class="small-12 columns"> -->
<!-- 					<div class="alert-box alert round" align="center"> -->
			  			<?php echo $errors;?>
<!-- 			  				<a href="" class="close">&times;</a> -->
<!-- 					</div> -->
<!-- 				</div> -->
<!-- 			</div> -->
			<?php 
// }
			?>
		
			<div class="row">
				<div class="large-12 columns">
							
					<div class="large-6 columns">
							<form class="form-2" name="logForm" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
								<h1><span class="log-in">Log in</span> or <span class="sign-up">sign up</span></h1>
								
								<div class="row">
									<div class="large-12 columns">
										<label for="email"><i class="icon-user"></i>Username</label>
										<input type="text" name="email" placeholder="Username or email" value="admin">
									</div>
								</div>
										
								<div class="row">
									<div class="large-12 columns">
										<label for="password"><i class="icon-lock"></i>Password</label>
										<input type="password" name="password"  placeholder="Password" class="showpassword" value="admin100">
									</div>
								</div>
								
								<div class="row">
									<div class="large-12 columns">
										<input type="submit" id="submit" name="submit" class="small button success" style="width: 45%;height: 30px" value="Login">
										<a href="register.php" class="small button alert" style="width: 45%;height: 30px" >Sign Up</a>
									</div>
								</div>
							</form>
					</div>
				
					<div class="large-7 columns">
					
					</div>
					
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
function checkLogin($email,$pass){
	
	echo $email . " " . $pass;
	
	$cn = new PDO(Conf::cnstring(), Conf::$dbuser, Conf::$dbpass);
	$cn->query("SET NAMES utf8");
	$cm = $cn->prepare("select id,getOperName(id)as user,email,pass,priviledges from user where email=:email and pass=MD5(:pass);");
	$cm->bindValue(":email",  $email);
	$cm->bindValue(":pass",  $pass);
	$rs = $cm->execute();
	$rs = $cm->fetchAll(PDO::FETCH_OBJ);
	
	foreach ($rs as $row){
		$userID=$row->id;
		$user=$row->user;
		$email=$row->email;
		$privileges=$row->priviledges;
	}
	
	
	$total = $cm->rowCount();
	
	if ($total>0){
			$orderID = checkInitOrder($userID);

			print "OrderID=" . $orderID . "<br>";
			
			if ($orderID==0){
				print "ušao";
				$orderID = initOrder($userID);
			}
			
	
			
			session_start();
			$_SESSION['auth']=true;
			$_SESSION['userID']=$userID;
			$_SESSION['user']=$user;
			$_SESSION['email']=$email;
			$_SESSION['privileges']=$privileges;
			$_SESSION['sessionID']=session_id();
			$_SESSION['orderID']=$orderID;
			
 			header("location: mainframe.php");
	}else{
		
		$errors= $errors . "Login data incorrect! Please try again...<br>";
		print $errors;
	}
	
}




function checkInitOrder($userID){
	
	$cn = new PDO(Conf::cnstring(), Conf::$dbuser, Conf::$dbpass);
	$cm = $cn->prepare("select id from orders where userID=:userID and orderState in(0,1)");
	$cm->bindValue(":userID",  $userID);
	$rs = $cm->execute();
	$rs = $cm->fetchAll(PDO::FETCH_OBJ);
	
	
	foreach ($rs as $row){
		$id=$row->id;
	}
	
	return $id;
}



function initOrder($userID){
	
	//print "uÅ¡ao u initOrder!";
	
// // 	$cn->query("SET NAMES utf8");
// 	$cm = $cn->prepare("select * from menuList where category =:categ;");
// 	$cm->bindValue(":categ",  $categ);
// 	$rs = $cm->execute();
// 	$rs = $cm->fetchAll(PDO::FETCH_OBJ);
	print "<br>". "USER ID: " . $userID ."<br>";

	try {
		$cn = new PDO(Conf::cnstring(), Conf::$dbuser, Conf::$dbpass);
		$cn->query("SET NAMES utf8");
		
		
		$query = "INSERT INTO orders (orderState,orderType,userID,date,operator,locationID) values(1,1,:userID,Now(),1,1)";
		
// 		$cm = $cn->prepare("INSERT INTO orders (orderState,orderType,userID,date,operator,status) VALUES(?,?,?,?,?,?)");
		$cm = $cn->prepare($query);
		$cm->bindValue(":userID",  $userID );
		$cm->execute();
		
		print $query;
		
		$tempOrderID = $cn->lastInsertId();
		print "<br>". "order ID: " . $tempOrderID ."<br>";
		
// 		try {
// // 			$cn->beginTransaction();
// // 			$cm->execute(array(1,1,$userID,'2012-02-01',0));
// // 			$cn->commit();
// //  			print $cn->lastInsertId();
//  			$temp = $cm->fetch(PDO::FETCH_ASSOC);
 			
//  			print "<br>". "ID: " . $temp ."<br>";

// 			print "END";
			
		} catch(PDOExecption $e) {
			print "Error!: " . $e->getMessage() . "</br>";
		}
// 	} catch( PDOExecption $e ) {
// 		print "Error!: " . $e->getMessage() . "</br>";
// 	}
		return $tempOrderID;	
}





function checkData(){
	include_once 'functions.php';

	$errors="";

	if (checkText("Username", $_POST["email"], 2, 50)==false){
		$errors=$errors . "Please fill out 'Username' field!<br>";
	};

	if (checkText("Password", $_POST["password"], 2, 50)==false){
		$errors= $errors . "Please fill out 'Password' field!<br>";
	};

	// 	if (checkText("Password", $_POST["dbprefix"], 2, 50)==false){
	// 		$errors= $errors ."Please fill out 'Database Prefix' field!<br>";
	// 	};

	return $errors;

}

?>

</html>
