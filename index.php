<!DOCTYPE html>
<html lang="en">
    <head>
	<meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
	<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title>Welcome to iOrder</title>
    <meta name="description" content="Custom Login Form Styling with CSS3" />
    <meta name="keywords" content="css3, login, form, custom, input, submit, button, html5, placeholder" />
        
    <meta name="author" content="KI" />
    
    <link rel="shortcut icon" href="../favicon.ico"> 
    <link rel="stylesheet" href="css/normalize.css" />
	<link rel="stylesheet" href="css/foundation.css" />
	<link rel="stylesheet" href="css/custom.css" />
	<link rel="stylesheet" type="text/css" href="css/style.css" />


<script src="js/vendor/custom.modernizr.js"></script> 
      
		<style>
			body {
				background: #e1c192 url(images/bg.jpg);
			}
		</style>
    </head>
    
    
    <body>
        <div class="container">
		
			<!-- Codrops top bar -->
            <div class="codrops-top">
<!--                 <a href="http://tympanus.net/Tutorials/RealtimeGeolocationNode/"> -->
<!--                     <strong>&laquo; Previous Demo: </strong>Real-Time Geolocation Service with Node.js -->
<!--                 </a> -->
<!--                 <span class="right"> -->
<!--                     <a href="http://tympanus.net/codrops/?p=11372"> -->
<!--                         <strong>Back to the Codrops Article</strong> -->
<!--                     </a> -->
<!--                 </span> -->
            </div><!--/ Codrops top bar -->
			
			<header>
			
				<h1>Welcome to <strong>iOrder</strong> Login Form...</h1>
				<h2>Please input following data</h2>
				
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
				<div class="large-7 columns">
					<section class="main">
						<form class="custom form-2"	name="loginForm" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
							<h1><span class="log-in">Log in</span> or <span class="sign-up">sign up</span></h1>
							<div class="row">
								<div class="large-12 columns">
									<label for="login"><i class="icon-user"></i>Username</label>
									<input type="text" name="login" placeholder="Username or email">

								</div>
							</div>
									
							<div class="row">
								<div class="large-12 columns">
									<label for="password"><i class="icon-lock"></i>Password</label>
									<input type="password" name="password" placeholder="Password" class="showpassword">
								</div>
							</div>
							
							<div class="row">
								<div class="large-12 columns">
									<input type="submit" name="submit" value="Login">
									<a href="register.php" class="log-twitter">Sign Up</a>
								</div>
							</div>
							
						</form>​​
					</section>
				</div>
			</div>
        </div>
		
<?php 
	function checkUser($email, $pass){
	$flgCheck=true;
	
	try{
		$cn = new PDO(Conf::cnstring(), Conf::$dbuser, Conf::$dbpass);
		$cn->query("SET NAMES utf8");	
		$cm = $cn->prepare("select count(id) from user where email =:email and pass=:password;");
		$cm->bindValue(":email",  $email);
		$cm->bindValue(":password",  $pass);
		$rs = $cm->execute();
		$rs = $cm->fetchAll(PDO::FETCH_OBJ);
		
		$total = $cm->rowCount();
		
		if($total>0){
			$flgCheck=false;
		}else{
			
		}
		
	} catch (Exception $e) {
		print $e;
	}
		return $flgCheck;
		
}
		
?>
		
		
		<!-- jQuery if needed -->
		    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
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
</html>