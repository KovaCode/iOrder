<!DOCTYPE html>

<?php

include_once 'configuration.php';

session_start();
$flgAuth = $_SESSION['auth'];
$userID = $_SESSION['userID'];
$user= $_SESSION['user'];
$email = $_SESSION['email'];
$privileges = $_SESSION['privileges'];
$orderID=$_SESSION['orderID'];
$address=initLocation($userID);


include_once 'header.php';

if(isset($_POST['submitDest'])){
	saveDestination($user,$orderID);
	header("location: myOrders.php");
	
}

?>



<head>
<meta charset="utf-8" />
<title>iOrder - Choose Destination</title>

<meta charset="utf-8" />
<meta name="viewport" content="width=device-width" />
<title>iOrder Main</title>

<link rel="stylesheet" type="text/css" href="css/style.css" />

<script src="js/modernizr.custom.63321.js"></script>
<script src="js/vendor/custom.modernizr.js"></script>
<link rel="stylesheet" href="css/normalize.css" />
<link rel="stylesheet" type="text/css" href="css/style.css" />
<link rel="stylesheet" href="css/custom.css" />
<script src="js/vendor/custom.modernizr.js"></script>

<link rel="stylesheet" href="css/foundation.css" />


<style type="text/css">

body {
	font: normal 14px Verdana;
}

h1 {
	font-size: 24px;
}

h2 {
	font-size: 18px;
}

#sidebar {
	float: right;
	width: 30%;
}

#main {
	padding-right: 15px;
}

.infoWindow {
	width: 220px;
}

body {
	background: #e1c192 url(images/bg.jpg);
}
</style>


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

	function init() {

		var osijek = new google.maps.LatLng(45.55564386255815, 18.691418170920997);
		
	    var mapOptions = {
	      zoom: 15,
	      center: center,
	      mapTypeId: google.maps.MapTypeId.ROADMAP
	    }
	     
	    map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
	     
	    directionsDisplay.setMap(map);
	    directionsDisplay.setPanel(document.getElementById('directions_panel'));
	
	
	    google.maps.event.addListener(map,'click',function(event) {
	    	  //document.getElementById('latlongclicked').value = event.latLng.lat() + ', ' + event.latLng.lng()
	    	  
	    	  placeMarker(event.latLng);
	    })
	        

	    
	        
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
	     
	    makeRequest('get_Locations.php', function(data) {
	         
	        var data = JSON.parse(data.responseText);
	        var selectBox = document.getElementById('destination');

			//alert (data.length)
	         
	        for (var i = 0; i < data.length; i++) {
				//alert (data[i]["name"] + "," +  data[i]["address"])
		        
	            //displayLocation(data[i]);
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
	                 
	                google.maps.event.addListener(marker, 'click', function() {
	                    infowindow.setContent(content);
	                    infowindow.open(map,marker);
	                });
	            }
	        });
	    } else {
	        var position = new google.maps.LatLng(parseFloat(location.lat), parseFloat(location.lon));
	        var marker = new google.maps.Marker({
	            map: map,
	            position: position,
	            title: location.name
	        });
	         
	        google.maps.event.addListener(marker, 'click', function() {
	            infowindow.setContent(content);
	            infowindow.open(map,marker);
	            placeMarker(event.latLng);

	            
	        });
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
            
            var start = document.getElementById('start').value;
            var destination = document.getElementById('end').value;
            var selectedMode = document.getElementById('mode').value;
             
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



</head>






<body onload="init();">

	<div class="container">
		<header>

			<h1>
				Please choose Your <strong>Destination</strong> 
			</h1>
			<h2>If Your destination differ from Your location, just click on map and select destination.</h2>

			<hr>

			<div class="support-note">
				<span class="note-ie">Sorry, only modern browsers.</span>
			</div>

		</header>

	
	
	<form id="services" class="form-2" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
		<input type="hidden" id="end" name="end" value="Osijek, Županijska 1" />

		<div class="row left"  align="left">
			<div class="large-12 columns">
				
<!-- 				<label for="dest"><i class="icon-user"></i>Destination:</label> -->
				<div class="large-6 columns">
				<input type="text" id="start" name="start" style="width: 400px" />
				</div>
				
<!-- 				<label for="mode"><i class="icon-user"></i>Mode of Travel:</label> -->
				<div class="large-3 columns">						
					<select id="mode">
						<option value="DRIVING">Driving</option>
						<option value="WALKING">Walking</option>
						<!--       <option value="BICYCLING">Bicycling</option> -->
						<!--       <option value="TRANSIT">Transit</option> -->
					</select>
				</div>
					 
				<div class="large-3 columns">	
					<input type="button" data-reveal-id="directionsModal" class="tiny round button alert" value="Display Directions" onclick="calculateRoute();" />
				</div>		
			</div>
			
				<input type="hidden" id="lat" name="lat"/>
				<input type="hidden" id="lng" name="lng"/>
		</div>
		
		<div id="map_canvas" class="large-12 columns" style="width: 100%; height: 560px;"></div>
			
		<input type="submit" id="submitDest" name="submitDest" class="small round button success" value="Next Step" style="width: 100%;"/>
			
		</form>
		
		
		
		<form class="custom" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">


			
		</form>	

	
			
	<hr>
	

	</div>
	
	
	
	
		<div id="directionsModal" class="reveal-modal" align="center" style="width: 70%" >
	<div class="codrops-top">
    	<h2>Directions</h2>
    </div>
		<div id="directions_panel" class="large-12 center"></div>
		 <a class="close-reveal-modal">&#215;</a>
	</div>
	
	
	
		<script>
      document.write('<script src="http://foundation.zurb.com/docs/assets/vendor/'
        + ('__proto__' in {} ? 'zepto' : 'jquery')
        + '.js"><\/script>');
    </script>
    
    
    
<!--     <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.1/jquery.js"></script> -->
<!-- 	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.0/jquery-ui.min.js"></script> -->
	<script src="http://foundation.zurb.com/docs/assets/docs.js"></script>
 	<script type="text/javascript" src="http://jqueryui.com/themeroller/themeswitchertool/"></script>
	<script type="text/javascript">
      $(document)
      
        .foundation();
     
    </script>
    
</body>



<?php 
function saveDestination($user,$orderID){
// 	echo "Ušao u saveDestination()!";
// 	echo "USER: ". $user . "<br>";
// 	echo "LAT: ". $_POST['lat'] . "<br>";
// 	echo "LNG: ". $_POST['lng'] . "<br>";
// 	echo "ADDRESS: ". $_POST['start'] . "<br>";
	
	
	try{
		$cn = new PDO(Conf::cnstring(), Conf::$dbuser, Conf::$dbpass);
		$cn->query("SET NAMES utf8");
	
		
		$cn->beginTransaction();
		$query = "insert into locations (name,address,lat,lon,description) values (:user,:address,:lat,:lon,:desc);";
	
		$cm = $cn->prepare($query);
		$cm->bindValue(":user",  $user);
		$cm->bindValue(":address",  $_POST['start']);
		$cm->bindValue(":lat",  $_POST['lat']);
		$cm->bindValue(":lon",  $_POST['lng']);
		$cm->bindValue(":desc",  "tests");
		$rs = $cm->execute();
		$id = $cn->lastInsertId();
		
		
// 		print "LAST ID: " . $id . "<br>";
// 		print "ORDER ID: " . $orderID . "<br>";
		
		$query2 = "update orders set locationID=:locationID where id=:orderID";
		$cm = $cn->prepare($query2);
		$cm->bindValue(":locationID",  $id);
		$cm->bindValue(":orderID",  $orderID);
		$cm->execute();
		
		$cn->commit();
		
		

		
		
		
	} catch (PDOException $e) {
		echo $e;
	}
	
	return $id;
	
}


function initLocation($userID){
	//echo $userID;
	
	try{
		$cn = new PDO(Conf::cnstring(), Conf::$dbuser, Conf::$dbpass);
		$cn->query("SET NAMES utf8");
		
		$query = "select o.orderID,o.userID,concat(c.city_name,', ', s.street_name,' ', u.street_no)as addr " .
				" from orders o inner join user u on o.userID = u.id inner join street s on u.street = s.id " .
				" inner join city c on u.city=c.id where o.status=0 and o.userID=:userID;";
		
		$cm = $cn->prepare($query);
		$cm->bindValue(":userID",  $userID);
		$rs = $cm->execute();
		$rs = $cm->fetchAll(PDO::FETCH_OBJ);
		$total = $cm->rowCount();
		
		foreach ($rs as $row){
			echo $row->addr;
		}
		
	} catch (PDOException $e) {
		echo $e;
	}
		
}


?>



</html>
