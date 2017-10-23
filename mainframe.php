<?php 

include_once 'configuration.php';
include_once 'header.php';



// echo "auth: " .  $_SESSION['auth'] ."<br>";
// echo "user: " .  $_SESSION['user'] ."<br>";
// echo "email: " .  $_SESSION['email'] ."<br>";
// echo "privileges: " .  $_SESSION['privileges'] ."<br>";
// echo "orderID: " .  $_SESSION['orderID'] ."<br>";


if(isset($_POST['btnCommit'])){
	commitOrder($orderID);	
	header("location: gmaps.php");	
	
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
<title>iOrder Main</title>

<link rel="stylesheet" type="text/css" href="css/style.css" />


<link rel="stylesheet" type="text/css" href="css/demoAcc.css" />
<link rel="stylesheet" type="text/css" href="css/styleAcc.css" />


<link rel="stylesheet" href="css/normalize.css" />
<link rel="stylesheet" href="css/foundation.css" />
<link rel="stylesheet" href="css/custom.css" />
<link rel="stylesheet" type="text/css" href="css/style.css" />

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.1/jquery-ui.min.js"></script>

<!-- <link href="css/prettify.css" type="text/css" rel="stylesheet" /> -->
<!-- <script type="text/javascript" src="js/prettify.js"></script> -->
<script type="text/javascript" src="js/jquery.slimscroll.js"></script>


<style type="text/css">

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
				<strong>Choose</strong> desired menu item 
			</h1>
			<h2>If Your destination differ from Your location, just click on map and select destination.</h2><script type="text/javascript" src="rating.js"></script>

			<hr>

			<div class="support-note">
				<span class="note-ie">Sorry, only modern browsers.</span>
			</div>

		</header>
		
							
<!--	<div data-magellan-expedition="fixed" style=""> -->
<!--          <dl class="sub-nav"> -->
<!--            <dd data-magellan-arrival="1" class="active"><a href="#">APPETIZERS</a></dd> -->
<!--            <dd data-magellan-arrival="2" class=""><a href="#">SALADS & MORE</a></dd> -->
<!--            <dd data-magellan-arrival="3" class=""><a href="#">MAIN COURSES</a></dd> -->
<!--            <dd data-magellan-arrival="4" class=""><a href="#">DESSERTS</a></dd> -->
<!--     	</dl> -->
<!--     </div> -->
						
	<div class="row">
			<div class="large-9 columns">			
				<?php fillCategory();?>
		</div>

			
		<div class="large-3 columns">
		
				<ul class="pricing-table" style="width: 300px">
<!-- 					<li class="price">Your Order </b></li> -->
				
				<?php fillOrder($orderID)?>
				
				</ul>
			</div>
			
		</div>
		




	<script>
  document.write('<script src=' +
  ('__proto__' in {} ? 'js/vendor/zepto' : 'js/vendor/jquery') +
  '.js><\/script>')
  </script>

	<script src="js/foundation.min.js"></script>
</div>
</body>




<?php

function fillCategory(){
	try {
 		//			print Conf::cnstring() . "<br>";
		// 			print Conf::$dbuser. "<br>";
		// 			print Conf::$dbpass. "<br>";

		$cn = new PDO(Conf::cnstring(), Conf::$dbuser, Conf::$dbpass);
		$cn->query("SET NAMES utf8");
		$cm = $cn->prepare("select * from category;");
		// 		$cm->bindValue(":naziv",  $_POST['naziv'] );
		$rs = $cm->execute();
		$rs = $cm->fetchAll(PDO::FETCH_OBJ);

		// 			echo "ok1";

		foreach ($rs as $row){
			?>


			<section class="ac-container">
				<div class="large-12 columns">

					<input id="ac-<?php echo $row->id;?>" name="accordion-<?php echo $row->id;?>" type="checkbox"/>
					<label for="ac-<?php echo $row->id;?>" style="width: 100%;">- <?php echo $row->categoryName;?> -</label>
					<article class="ac-small">
					
						<div class="scroller" id="scroll-<?php echo $row->id;?>">
						
						<h3 data-magellan-destination="<?php echo $row->id;?>" hidden><?php echo $row->categoryName;?></h3>
								<?php
 								fillContent($cn,$row->id);
// 							 	?>
							
						</div>
												
					</article>
				</div>
				

			</section>
<?php 
		}
		$cn=null;

	} catch (PDOException $e) {
		echo $e;
	}
}








function fillContent($cn,$categ){
	//print $cn . " - " . $categ;
	
	try {
		// 			$cn = new PDO(Conf::cnstring(), Conf::$dbuser, Conf::$dbpass);
		// 			$cn->query("SET NAMES utf8");
		$cm2 = $cn->prepare("select * from menuList where category =:categ;");
		$cm2->bindValue(":categ",  $categ);
		$rs2 = $cm2->execute();
		$rs2 = $cm2->fetchAll(PDO::FETCH_OBJ);

		$total = $cm2->rowCount();
			
		// 			print $total;
			
		foreach ($rs2 as $row2){
			

			?>

	<div class="row product" id="product_<?php echo $row2->id?>" onmouseover="mouseOver(this)" onmouseout="mouseOut(this)">
		<div class="rm-middle">
			<div class="rm-inner">
				<div class="rm-content">
<!-- 									<h4>Main Courses</h4> -->
					<dl>
						<div class="large-12 columns">
							<div class="large-3 columns">
								<a href="#" class="th"><img src="http://placehold.it/250x250"> </a>		
							</div>
							
							<div class="large-9 columns">
								<dt>
									<a href="#" class="rm-viewdetails" data-thumb="images/11.jpg"><?php echo $row2->name?></a>								
								</dt>
								
								<div class="large-12 columns" align="left">
									<dd><?php echo $row2->ingridients?></dd>
								</div>								
								
								<dd>
									<div class="large-4 columns" align="left">
									 Price: <strong><font color="red"><?php echo $row2->price?>kn</font></strong>	
									</div>
									
									<div class="large-6 columns" align="right">
										<input type="text" id="quantity_<?php echo $row2->id;?>" name="quantity"  class="spinnerhide" value="0" style="width:40%"/>
									</div>
									
									<div class="large-2 columns" align="right">
										<a href="#" class="tiny round button success addProduct" id="addProduct_<?php echo $row2->id;?>">Add</a>
									</div>
								</dd>
									
								</div>
							</div>

						<hr>
					</dl>
				</div><!-- /rm-content -->
				<div class="rm-overlay"></div>
			</div><!-- /rm-inner -->
		</div>
	</div>

<?php
	}
	} catch (PDOException $e) {
		echo $e;
	}
}





function fillOrder($orderID){
	
$price=0;

$cn = new PDO(Conf::cnstring(), Conf::$dbuser, Conf::$dbpass);
$cn->query("SET NAMES utf8");


$query = "select (ol.id)as olID,o.id,ol.menuItemID,ml.name,ml.price,ol.quantity,(ml.price*ol.quantity)sumPrice" .
		" from orders o inner join".
		" orderslist ol on o.id=ol.ordernum inner join menulist ml on ol.menuItemID=ml.id".
		" where o.id=:orderID and o.orderState=0;";

$cm = $cn->prepare($query);
$cm->bindValue(":orderID",$orderID);
$rs = $cm->execute();
$rs = $cm->fetchAll(PDO::FETCH_OBJ);
$total = $cm->rowCount();

?>
	<li class="description" id="totalItems">Total Items: <?php echo $total?></li>

<?php 
foreach ($rs as $row){
	?>	
				<li class="bullet-item" value=<?php echo $row->id;?> id="priceItems_<?php echo $row->olID;?>"> - <b><?php echo $row->name;?></b> (x<?php echo $row->quantity;?>) <?php echo $row->price;?> = <?php echo $row->sumPrice;?>
					<a href="#" class="tiny round button alert removeProduct" id="remove_<?php echo $row->olID;?>">x</a>	
				</li>
				
		<?php 
		$price = $price + $row->sumPrice;
		} 

		
		
		?>
				<li class="price" name="total" id="total">TOTAL: <b><?php echo number_format($price, 2, ',', '.');?> kn</b></li>
				
				<li class="price">
					<form class="custom" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
						<input type="submit" class="small round button success" value="Next Step" name="btnCommit"/>
						<input type="hidden" name="orderID" id="orderID" value="<?php echo $orderID?>" />
					</form>
				</li>


<?php 		
 }
 
 
 
 
 


function commitOrder($orderID){
	try {
		$cn = new PDO(Conf::cnstring(), Conf::$dbuser, Conf::$dbpass);
		$cn->query("SET NAMES utf8");
		$cm = $cn->prepare("update orders set status=1 where id=:orderID;");
		$cm->bindValue(":orderID",$orderID);
		$rs = $cm->execute();

	} catch (PDOException $e) {
		print $e->getMessage();
	}

}




include_once 'footer.php';
?>




<!-- 	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.1/jquery.js"></script> -->
<!-- 	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.0/jquery-ui.min.js"></script> -->
<!-- 	<script type="text/javascript" src="js/ui.spinner.js"></script> -->
<!--  	<script type="text/javascript" src="http://jqueryui.com/themeroller/themeswitchertool/"></script> -->
	<script type="text/javascript">

	var TableBackgroundNormalColor = "#ffffff";
	var TableBackgroundMouseoverColor = "#80B8CE";

	// These two functions need no customization.
	function mouseOver(row) {
		row.style.backgroundColor = TableBackgroundMouseoverColor; 
	}


	function mouseOut(row) {
		row.style.backgroundColor = TableBackgroundNormalColor;
		
	}

	
	jQuery().ready(function($) {
		
		initScroller();		
		initSpinner();
		fillDataOnOrder();
		
		
	});

	
	
  	$(document).ready(function() {
  		//initSpinner();
  		
  	  // $('#rate1').rating('www.url.php', {maxvalue:5});
  	  	
	  $(".kicontent").hide();
	   $(".category").click(function(){
		   $(".kicontent").hide();
				var id = $(this).attr("id").substring($(this).attr("id").indexOf("_")+1);
				$("#content_"+id).show();				
				//alert(id);
	});


	   

	 $(".addProduct").click(function(){
		   var id = $(this).attr("id").substring($(this).attr("id").indexOf("_")+1);
		   var kolicina = $("#quantity_" + id).val();
		   var orderID = $("#orderID").val();
		   //var bulletID = $("#priceItems_").val();

		   //alert(id + ": " + kolicina + ": " + orderID); //*+ ":" + bulletID*//);
		   //alert(id + ": " + orderID); //*+ ":" + bulletID*//);
		   		   
		   $.ajax({
               type: "POST",
               url: "/iorder/addItem.php",
               data: "orderID="+ $("#orderID").val() +"&productID=" + id + "&quantity=" + kolicina,
               dataType: "html",
               success: function (msg) {
               	 if(msg=="GRESKA"){
               		alert("GREŠKA");
       				//maknuti zadnji s sadnjeg i staviti novi zanji
            		//tu dodati dinamičko dodavanje item-a
               		
               		//document.getElementById("totalItems").parent.remove();
               	 }else{
                   	$(".bullet-item").remove();
               		$("#totalItems").after(msg);
               		$(".spinnerhide").val("0");
               		
               		removeItem();
               		
               	 }
               }
           });
		   return false;
		});




	 removeItem();




	 $(".commit").click(function(){
		   var id = $(this).attr("id").substring($(this).attr("id").indexOf("_")+1);
		   //alert(id); //*+ ":" + bulletID*//);
		   		   
		   $.ajax({
         type: "POST",
         url: "/iorder/mainFrame.php",
         data: "productID=" + id,
         dataType: "html",
         success: function (msg) {
         	 if(msg=="OK"){
         		//alert("SVE OK!");

        		//tu dodati dinamičko dodavanje item-a
           	//document.getElementById("priceItems_" + id).remove();
           	
           	//$("a#"+clan).parent().parent().remove();
           	
         	 }else{
					alert("Pogreška: " + msg);
         	 }
         }
     });
		   return false;
	});

		
});




function removeItem(){
	 $(".removeProduct").click(function(){
		   var id = $(this).attr("id").substring($(this).attr("id").indexOf("_")+1);
		   //alert(id); //*+ ":" + bulletID*//);
		   		   
		   $.ajax({
         type: "POST",
         url: "/iorder/removeItem.php",
         data: "productID=" + id,
         dataType: "html",
         success: function (msg) {
         	 if(msg=="OK"){
         		$("#remove_" + id).parent().remove();             		
         	 }else{
					alert("Pogreška: " + msg);
         	 }
         }
     });
		   return false;
	});
}


function fillDataOnOrder(){
	   var id = $("#orderID").val();
	   //alert("Show order ID:" + id);

	   $.ajax({
	         type: "POST",
	         url: "/iorder/DATA.php",
	         data: "dataPoint=fillOrderData&data=" + id ,
	         dataType: "html",
	         success: function (msg) {
		                 		         
	         	 if(msg!="Error"){
	         			$(".bullet-item").remove();
	         			$(".description").remove();
	         			$(".price").remove();

	         			//alert(msg);
                		$(".pricing-table").append(msg);
                		removeItem();
	         	 }else{
						alert("Pogreska: " + msg);
	         	 }
	         }
	     });
	   
}

function initSpinner(){
	$('.spinnerhide').spinner({ min: 0, max: 100, showOn: 'both' });
}


function initScroller(){
	$('.scroller').slimScroll({
        height: '500px'
    });
}


		
	</script>

	
	
	
	
	  <script>
      $(document)
      
        .foundation();
      

      // For Kitchen Sink Page
      $('#start-jr').on('click', function() {
        $(document).foundation('joyride','start');
      });
    </script>
</html>
