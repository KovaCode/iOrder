
<?php
$cityID=$_POST['cityId'];

require "configuration.php";

try{
	$cn = new PDO(Conf::cnstring(), Conf::$dbuser, Conf::$dbpass);
	$cn->query("SET NAMES utf8");
	$cm = $cn->prepare("select * from street where city=:cityID order by street_name;");
 	$cm->bindValue(":cityID",$cityID);
 	$cm->execute();
	$podaci = $cm->fetchAll();
         
    echo json_encode( $podaci );
		
	
	} catch (PDOException $e) {
		echo $e;
	}

?>