<?php
include_once 'configuration.php';



if(isset($_POST['orderID']) && isset($_POST['productID']) && isset($_POST['quantity']) ){
	

	try {
			
		$cn = new PDO(Conf::cnstring(), Conf::$dbuser, Conf::$dbpass);
		$cn->query("SET NAMES utf8");
		$cm = $cn->prepare("insert into orderslist (menuItemID,quantity,orderNum,date,operator) values(:menuItemID,:quantity,:orderNum,now(),'1');");		
		
		$cm->bindValue(":menuItemID",$_POST['productID']);
		$cm->bindValue(":quantity",$_POST['quantity']);
		$cm->bindValue(":orderNum",$_POST['orderID']);
		$rs = $cm->execute();
	
		
//	 		echo $cm->queryString . $_POST['orderID'] . " - " .  $_POST['productID'] . " - " . $_POST['quantity'];
		//echo "OK";
		
		
// 		$cn = new PDO(Conf::cnstring(), Conf::$dbuser, Conf::$dbpass);
// 		$cn->query("SET NAMES utf8");
		
		
		$query = "select (ol.id)as olID,o.id,ol.menuItemID,ml.name,ml.price,ol.quantity,(ml.price*ol.quantity)sumPrice" .
				" from orders o inner join".
				" orderslist ol on o.id=ol.ordernum inner join menulist ml on ol.menuItemID=ml.id".
				" where o.id=:orderID and o.orderState=1;";
		
		$cm2 = $cn->prepare($query);
		$cm2->bindValue(":orderID",$_POST['orderID']);
		$rs2 = $cm2->execute();
		$rs2 = $cm2->fetchAll(PDO::FETCH_OBJ);
		$total = $cm2->rowCount();
				
		foreach ($rs2 as $row){
			echo "<li class=\"bullet-item\" value=\"1\" id=\"priceItems_". $row->olID ."\"> - <b>". $row->name ."</b> (x ". $row->quantity .") ". $row->price ." = ". $row->sumPrice ." " .
				 "<a href=\"#\" class=\"tiny round button alert removeProduct\" id=\"remove_". $row->olID ."\">x</a>	" .
				 "</li>";
		}

		
	} catch (PDOException $e) {
		print $e->getMessage();
	}

}


