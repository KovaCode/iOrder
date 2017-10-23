<?php
include_once 'configuration.php';

if(isset($_POST['productID'])){
	
// 	print $_POST['productID'];
	
	try {
		$cn = new PDO(Conf::cnstring(), Conf::$dbuser, Conf::$dbpass);
		$cn->query("SET NAMES utf8");
		$cm = $cn->prepare("delete from orderslist where id=:productID;");
		$cm->bindValue(":productID",$_POST['productID']);
		$rs = $cm->execute();
	
		
// 		echo $cm->queryString . $_POST['orderID'] . " - " .  $_POST['productID'] . " - " . $_POST['quantity'];
		echo "OK";
		
	} catch (PDOException $e) {
		print $e->getMessage();
	}

}


