<?php 

include_once 'configuration.php';
include_once 'header.php';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
	<meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
	<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title>My Orders...</title>
    <meta name="description" content="Custom Login Form Styling with CSS3" />
    <meta name="keywords" content="css3, login, form, custom, input, submit, button, html5, placeholder" />
        
    <meta name="author" content="KI" />

    <script src="js/vendor/custom.modernizr.js"></script> 
   	<link rel="stylesheet" href="css/custom.css" />
	<link rel="stylesheet" type="text/css" href="css/style.css" />
    <link rel="shortcut icon" href="../favicon.ico"> 
    <link rel="stylesheet" href="css/normalize.css" />
	<link rel="stylesheet" href="css/foundation.css" />

	


      
		<style>
			body {
				background: #e1c192 url(images/bg.jpg);
				html, body, #container { height: 100%; }
			}
		</style>
    </head>
    
    
    <body>




	<div
		class="container">

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
		</div>
		<!--/ Codrops top bar -->

		<header>

			<h1>
				My orders in <strong>iOrder</strong>
			</h1>
			<h2>What have I ordered so far...</h2>

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

		<!-- 			<div class="row"> -->
		<!-- 				<div class="large-12 columns"> -->
		<!-- 					<section class="main"> -->






		<!-- 			<a href="#" data-reveal-id="firstModal" class="radius button">Example Modal&hellip;</a> -->
		<!-- 			<a href='#'><img src="images/icons/add.gif"></a> -->


		<div class="row">
			<div class="small-12 columns">
				<form class="custom form-2" name="myOrders"
					action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">

					<table style="width: 100%;">
						<thead>
							<tr>
								<th>Order No.</th>
								<th>Type Name</th>
								<th>Order State</th>
								<th>Order List</th>
								<th style="width: 80px;">Total</th>
								<th>Location</th>
								<th style="text-align: center;">Map</th>
								<th style="text-align: right">Date</th>
								<th style="width: 150px; text-align: center;">Actions</th>
							</tr>
						</thead>

						<tbody>
							<?php
				
						try {
						$cn = new PDO(Conf::cnstring(), Conf::$dbuser, Conf::$dbpass);
						$cn->query("SET NAMES utf8");
						$cm = $cn->prepare("select  l.address,o.locationID,o.orderState,o.id,os.state,ot.typeName,concat(u.first_name,' ', u.last_name)person, o.date,sum(ml.price*ol.quantity)as total from orders o ".
											" inner join orderState os on o.orderState=os.id " . 
											" inner join orderType ot on o.orderType=ot.id " .
											" inner join ordersList ol on o.id=ol.orderNum  " .
											" inner join menulist ml on ml.id=ol.menuItemID " .
											" inner join locations l on o.locationID=l.id " .
											" inner join user u on o.userID=u.id where o.userID=:userID group by o.id order by o.id desc;");
			
			 			$cm->bindValue(":userID",  $userID);
						$rs = $cm->execute();
						$rs = $cm->fetchAll(PDO::FETCH_OBJ);
						$total = $cm->rowCount();

  						foreach ($rs as $row){
  						?>
							<tr>
								<td><strong><?php echo date("Y",strtotime($row->date)) ?>\<?php  echo $row->id;?>
								</strong></td>
								<td><?php echo $row->typeName;?></td>
								<td><?php echo $row->state;?></td>
								<td><a href="#" data-reveal-id="orderModal"
									class="tiny round button secondary showOrder"
									id="order_<?php echo $row->id;?>">...</a></td>

								<td><strong><font color="red"><?php echo $row->total?>kn</font>
								</strong></td>


								<td><?php echo $row->address;?></td>
								<td><a href="#" data-reveal-id="mapModal"
									class="tiny round button secondary mapOrder"
									id="map_<?php echo $row->locationID;?>">Map Location</a></td>

								<td style="text-align: right;"><?php echo date("d.m.Y.",strtotime($row->date));?>
								</td>

								<td style="text-align: right;"><?php 
								if ($row->orderState=="1"){
									?>
									<div class="small-12 columns">
										<div class="small-4 columns">
											<a href="#" class="verifyOrder" id="verify_<?php echo $row->id;?>" title="Verify">Verify</a>
										</div>

										<div class="small-4 columns">
											<a href="#" class="editOrder"
												id="edit_<?php echo $row->id;?>" title="Edit">
<!--  												<img src="images/icons/fill.gif"> -->
												Edit 
											</a>
										</div>

										<div class="small-4 columns">
											<a href="#" class=" cancelOrder"
												id="cancel_<?php echo $row->id;?>" title="CancelOrder">
<!-- 												<imgsrc="images/icons/get.gif"> -->
											Cancel</a>
										</div>
									</div> <?php 
								}
								?>
								</td>
							</tr>

							<?php 	
  						}

  						//zatvaranje veze s bazom
  						$cn=null;
						} catch (PDOException $e) {
							echo $e;
						}


						?>
						</tbody>
					</table>
					
<!-- 					<a href="#" class="button alert round">New</a> -->
<!-- 					<a href="#" class="button alert round">Edit</a> -->
<!-- 					<a href="#" class="button alert round">Delete</a> -->
					
				</form>


				<div class="row" id="tableKI">
				
				</div>
			




			</div>
		</div>
	</div>

 

	<div id="orderModal" class="reveal-modal" align="center" style="width: 70%" >
	<div class="codrops-top">
    	<h2>Order List</h2>
    </div>
<!-- 		 <p>This is summary of order items</p> -->
		 <a class="close-reveal-modal">&#215;</a>
	</div>
			
			
			
			
			
	<div id="mapModal" class="reveal-modal" align="center" style="width: 70%">
		
		
		<div class="codrops-top">
	    	<h2>Destination Location (map)</h2>
	    </div>
		
		<p>See? It just slides into place after the other first modal. Very handy when you need subsequent dialogs, or when a modal option impacts or requires another decision.</p>
		
		<div id="map_canvas" style="width: 100%; height: 400px;"></div>
		
		<a class="close-reveal-modal">&#215;</a>
	</div>
		
		
		
		
		
		
		
	<script>
      document.write('<script src="http://foundation.zurb.com/docs/assets/vendor/'
        + ('__proto__' in {} ? 'zepto' : 'jquery')
        + '.js"><\/script>');
    </script>
    
    
    <script src="http://foundation.zurb.com/docs/assets/docs.js"></script>
    <script>
      $(document)
      
        .foundation();
     
    </script>
    
		
<?php 

include_once 'footer.php';



?>
		
		
</body>

	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.1/jquery.js"></script>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.0/jquery-ui.min.js"></script>
	<script type="text/javascript" src="js/ui.spinner.js"></script>
 	<script type="text/javascript" src="http://jqueryui.com/themeroller/themeswitchertool/"></script>
	<script type="text/javascript">

	
	$(document).ready(function() {	
  	  	
		 $(".mapOrder").click(function(){
			   var id = $(this).attr("id").substring($(this).attr("id").indexOf("_")+1);
			   alert("Show map ID:" + id);
			   initMap(id); 
			   calculateRoute();
	
		 });	


		 $(".showOrder").click(function(){
			   var id = $(this).attr("id").substring($(this).attr("id").indexOf("_")+1);
    		   //alert("Show order ID:" + id);

    		   $.ajax({
    		         type: "POST",
    		         url: "/iorder/DATA.php",
    		         data: "dataPoint=showOrderList&data=" + id ,
    		         dataType: "html",
    		         success: function (msg) {
        		                 		         
    		         	 if(msg!="Error"){
    		         		//$("#remove_" + id).parent().remove();             		

    		         			$("#orderData").remove();
    	                		$("#orderModal").append(msg);
    	                		
       		         		
    		         	 }else{
    							alert("Pogreška: " + msg);
    		         	 }
    		         }
    		     });
    		    
	
		 });	
		 


		 $(".verifyOrder").click(function(){
			   var id = $(this).attr("id").substring($(this).attr("id").indexOf("_")+1);

	  		   alert("Verify order ID:" + id); 

			   $.ajax({
  		         type: "POST",
  		         url: "/iorder/DATA.php",
  		         data: "dataPoint=verifyOrder&data=" + id ,
  		         dataType: "html",
  		         success: function (msg) {
      		                 		         
  		         	 if(msg!="Error"){
  		         		//$("#remove_" + id).parent().remove();             		

  		         			//$("#orderData").remove();
  	                		//$("#orderModal").append(msg);
  	                		
     		         		
  		         	 }else{
  							alert("Pogre�ka: " + msg);
  		         	 }
  		         }
  		     });
	  		   
	
		 });
		 

		 $(".editOrder").click(function(){
			   var id = $(this).attr("id").substring($(this).attr("id").indexOf("_")+1);

	  		   alert("Edit order ID:" + id); 


    		   $.ajax({
  		         type: "POST",
  		         url: "/iorder/DATA.php",
  		         data: "dataPoint=editOrder&data=" + id ,
  		         dataType: "html",
  		         success: function (msg) {
      		                 		         
  		         	 if(msg!="Error"){

  		         		alert("Pogre�ka: " + msg)
  		         		//$("#remove_" + id).parent().remove();             		

  		         			//$("#orderData").remove();
  	                		//$("#orderModal").append(msg);
  	                		
     		         		
  		         	 }else{
  							;
  		         	 }
  		         }
  		     });
	  			
		 });

		 

		 $(".cancelOrder").click(function(){
			   var id = $(this).attr("id").substring($(this).attr("id").indexOf("_")+1);

	  		   alert("Cancel order ID:" + id);
    		   //alert("Show order ID:" + id);

    		   $.ajax({
    		         type: "POST",
    		         url: "/iorder/DATA.php",
    		         data: "dataPoint=cancelOrder&data=" + id ,
    		         dataType: "html",
    		         success: function (msg) {
        		                 		         
    		         	 if(msg!="Error"){
    		         		//$("#remove_" + id).parent().remove();             		

    		         			//$("#orderData").remove();
    	                		//$("#orderModal").append(msg);
    	                		
       		         		
    		         	 }else{
    							alert("Pogre�ka: " + msg);
    		         	 }
    		         }
    		     });
	
		 });


		 	
		 
		 
	});
    </script>
	
	
	
	
	
	
	

	
<script type="text/javascript"
	src="http://maps.google.com/maps/api/js?sensor=false">
</script>

<script type="text/javascript">
        //<![CDATA[
       
var map;
var center = new google.maps.LatLng(45.55564386255815, 18.691418170920997);		//Osijek
var geocoder = new google.maps.Geocoder();
var infowindow = new google.maps.InfoWindow();
var directionsService = new google.maps.DirectionsService();
var directionsDisplay = new google.maps.DirectionsRenderer();

	function initMap(id) {

		var osijek = new google.maps.LatLng(45.55564386255815, 18.691418170920997);
		
	    var mapOptions = {
	      zoom: 15,
	      center: center,
	      mapTypeId: google.maps.MapTypeId.ROADMAP
	    }
	     
	    map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
	     
	    directionsDisplay.setMap(map);
	    directionsDisplay.setPanel(document.getElementById('directions_panel'));
	
	
//	    google.maps.event.addListener(map,'click',function(event) {
//	    	  //document.getElementById('latlongclicked').value = event.latLng.lat() + ', ' + event.latLng.lng()
//	    	  
//	    	  placeMarker(event.latLng);
//	    })
	        

	    
	        
	    google.maps.event.addListener(map,'mousemove',function(event) {
	    	  //document.getElementById('latspan').innerHTML = event.latLng.lat() + " °"
	    	  //document.getElementById('lngspan').innerHTML = event.latLng.lng() + " °"
	    	  //document.getElementById('latlong').innerHTML = event.latLng.lat() + " °, " + event.latLng.lng() + " °"
	    });
	    
	
	
	    
	    // Detect user location
	    if(navigator.geolocation) {
	        navigator.geolocation.getCurrentPosition(function(position) {
	             
	            var userLocation = new google.maps.LatLng(position.coords.latitude,position.coords.longitude);
	             
	            geocoder.geocode( { 'latLng': userLocation }, function(results, status) {
	                if (status == google.maps.GeocoderStatus.OK) {
	                    document.getElementById('start').value = results[0].formatted_address
	                }
	            });
	             
	        }, function() {
	            alert('Geolocation is supported, but it failed');
	        });
	    }
	     
	    makeRequest('get_Locations.php?idMap=' + id, function(data) {
	         
	        var data = JSON.parse(data.responseText);
	        var selectBox = document.getElementById('destination');

			//alert (data.length)
	         
	        for (var i = 0; i < data.length; i++) {
				//alert (data[i]["name"] + "," +  data[i]["address"])
		        
	            displayLocation(data[i]);
	            //addOption(selectBox, data[i]['name'], data[i]['address']);
	        }
	    });

	}


 
	function addOption(selectBox, text, value) {
	    var option = document.createElement("OPTION");
	    option.text = text;
	    option.value = value;
	    selectBox.options.add(option);
	}






	function displayLocation(location) {
        
	    var content =   '<div class="infoWindow"><strong>'  + location.name + '</strong>'
	                    + '<br/>'     + location.address
	                    + '<br/>'     + location.description + '</div>';
	     
	    if (parseInt(location.lat) == 0) {
	        geocoder.geocode( { 'address': location.address }, function(results, status) {
	            if (status == google.maps.GeocoderStatus.OK) {
	                 
	                var marker = new google.maps.Marker({
	                    map: map,
	                    position: results[0].geometry.location,
	                    title: location.name
	                });
	                 
//	                google.maps.event.addListener(marker, 'click', function() {
//	                    infowindow.setContent(content);
//	                    infowindow.open(map,marker);
//	                });
	            }
	        });
	    } else {
	        var position = new google.maps.LatLng(parseFloat(location.lat), parseFloat(location.lon));
	        var marker = new google.maps.Marker({
	            map: map,
	            position: position,
	            title: location.name
	        });
	         
//	        google.maps.event.addListener(marker, 'click', function() {
//	            infowindow.setContent(content);
//	            infowindow.open(map,marker);
//	            placeMarker(event.latLng);
//	        });
	    }
	}
	




	
        function makeRequest(url, callback) {
            var request;
            if (window.XMLHttpRequest) {
                request = new XMLHttpRequest(); // IE7+, Firefox, Chrome, Opera, Safari
            } else {
                request = new ActiveXObject("Microsoft.XMLHTTP"); // IE6, IE5
            }
            request.onreadystatechange = function() {
                if (request.readyState == 4 && request.status == 200) {
                    callback(request);
                }
            }
            request.open("GET", url, true);
            request.send();
        }



        
        function calculateRoute() {
        	var end;
        	            
            var start = "Ulica kneza Trpimira 4, 31000, Osijek, Hrvatska";



            
            //var destination = document.getElementById('end').value;
            var selectedMode = document.getElementById(1).value;
             
            if (start == '') {
                start = center;
            }
             
            var request = {
                origin: start,
                destination: destination,
                //travelMode: google.maps.DirectionsTravelMode.DRIVING
                travelMode: google.maps.TravelMode[selectedMode]
            };
            directionsService.route(request, function(response, status) {
                if (status == google.maps.DirectionsStatus.OK) {
                    directionsDisplay.setDirections(response);
                }
            });
        }



   	   var marker;
 	    function placeMarker(location) {
 	        if(marker){ //on vérifie si le marqueur existe
 	            marker.setPosition(location); //on change sa position
 	        }else{
 	            marker = new google.maps.Marker({ //on créé le marqueur
 	                position: location, 
 	                map: map
 	            });
 	        }
 	       document.getElementById('lat').value=location.lat();
 	       document.getElementById('lng').value=location.lng();
 	        getAddress(location);
 	    }
        

  	  function getAddress(latLng) {
  	  	  	
		    geocoder.geocode( {'latLng': latLng},
		      function(results, status) {
		        if(status == google.maps.GeocoderStatus.OK) {
		          if(results[0]) {
		            //document.getElementById("address").value = results[0].formatted_address;
		            document.getElementById("start").value = results[0].formatted_address;
		          }
		          else {
		            document.getElementById("start").value = "No results";
		            //document.getElementById("end").value = "No results;
		          }
		        }
		        else {
		          document.getElementById("start").value = status;
		          //document.getElementById("end").value = status;
		        }
		      });
		   }
  	    	  
        
        </script>
	
</html>