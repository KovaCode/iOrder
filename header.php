<?php
session_start();

$flgAuth = $_SESSION['auth'];
$userID = $_SESSION['userID'];
$user= $_SESSION['user'];
$email = $_SESSION['email'];
$privileges = $_SESSION['privileges'];
$orderID=$_SESSION['orderID'];

if($_SESSION['auth']!=1){
	header("location: welcome.php");	
}

?>

			<!-- Codrops top bar -->
            <div class="codrops-top">
<!--                 <a href="http://tympanus.net/Tutorials/RealtimeGeolocationNode/"> -->
<!-- <!--                     <strong>&laquo; Previous Demo: </strong>Real-Time Geolocation Service with Node.js --> 
<!--                 </a> -->
                
                <span class="sign-up right">
                    <a href="logout.php">
                        Logout  <strong><?php echo $user;?></strong>
                    </a>
                </span>
                
                <span class="sign-up left">
                    <a href="myOrders.php">
                        Look at my previous <strong>Orders >></strong>
                    </a>
                </span>
                
            </div>
            
			<div class="support-note">
				<span class="note-ie">Sorry, only modern browsers.</span>
			</div>


