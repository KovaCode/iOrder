<?php
include_once 'configuration.php';


 if (isset($_POST['dataPoint']) && isset($_POST['data'])){
// 	if (isset($_GET['dataPoint']) && isset($_GET['data'])){
	
	$dataPoint=$_POST['dataPoint'];
	$data=$_POST['data'];
	
		
// 		$dataPoint=$_GET['dataPoint'];
// 		$data=$_GET['data'];
	
	


	switch ($dataPoint){
		
		
		//add items in mainframe
		case "addOrderItem":
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
		break;
		
		
		
		
		
		
		
		
		//add items in registration form for combo filling
		case "addStreetItem":
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
			break;
			
			
			
			
			case "editOrder":
				require "configuration.php";
				
				try{
					$cn = new PDO(Conf::cnstring(), Conf::$dbuser, Conf::$dbpass);
					$cn->query("SET NAMES utf8");
					$cm = $cn->prepare("update orders set orderState=0 where id=:orderID;");
					$cm->bindValue(":orderID",$data);
					$cm->execute();
					$podaci = $cm->fetchAll();
						
					echo "OK";
					
					header("location: mainframe.php");
					
						
						
				} catch (PDOException $e) {
					echo $e;
				}
				break;
			
			
			
			
			
			
			
			
		case "cancelOrder":
			require "configuration.php";
				
			try{
				$cn = new PDO(Conf::cnstring(), Conf::$dbuser, Conf::$dbpass);
				$cn->query("SET NAMES utf8");
				$cm = $cn->prepare("update orders set orderState=7 where id=:orderID;");
				$cm->bindValue(":orderID",$data);
				$cm->execute();
				$podaci = $cm->fetchAll();
					
				echo "OK";
					
					
			} catch (PDOException $e) {
				echo $e;
			}
		
		break;
			
			
			
			
			
			
			
			
			
			
		

			
			
			case "verifyOrder":
				try{
					$cn = new PDO(Conf::cnstring(), Conf::$dbuser, Conf::$dbpass);
					$cn->query("SET NAMES utf8");
				
				
					$query = "update orders set orderState=2 where id=:orderID;";
				
					$cm = $cn->prepare($query);
					$cm->bindValue(":orderID",  $data);
					$rs = $cm->execute();
				
					$id = $cn->lastInsertId();
				
				
				} catch (PDOException $e) {
					echo $e;
				}
				
				return $id;
				break;
			
				
				
				
				
				
				
				
				
				
			case "showOrderList";
				try {
					$cn = new PDO(Conf::cnstring(), Conf::$dbuser, Conf::$dbpass);
					$cn->query("SET NAMES utf8");
						
					$query="select cat.categoryName,ol.id,ml.name,ol.quantity,ml.price,ml.unit,(ol.quantity*ml.price)total " .
							"from ordersList ol " .
							"inner join menuList ml on ol.menuItemID=ml.id " .
							"inner join category cat on cat.id=ml.category " .
							"where ol.orderNum=:orderID group by ol.id;";
						
					$cm = $cn->prepare($query);
						
					$cm->bindValue(":orderID",  $data);
					$rs = $cm->execute();
					$rs = $cm->fetchAll(PDO::FETCH_OBJ);
					$total = $cm->rowCount();
						
					$dataResponse = "<div class=\"small-12 columns\" id=\"orderData\"> " .
									"<form class=\"custom form-2\" name=\"myOrders\" style=\"width: 100%\"action=\"<?php echo \$_SERVER['PHP_SELF'];?>\" method=\"post\"> " .
									"<table style=\"width: 100%;\">". 
									"<thead> " .
									"<tr> " . 
									"<th>ID</th>".
									"<th>Category</th>".
									"<th>Name</th>" .
									"<th>Quantity</th>". 
									"<th align=\"right\">Price</th>" . 
									"<th align=\"right\">Total</th>".
									"<th></th>" .
									"</tr>" . 
									"</thead> ".
									"<tbody>";
					
					foreach ($rs as $row){
						
					$dataResponse = $dataResponse ."<tr>" .
												   
												   "<td>" . $row->id . "</td>" . 
												   "<td>(" . $row->categoryName . ")</td>" .
												   "<td>" . $row->name . "</td>" .
												   "<td> (" . $row->quantity . " x)</td>" .
												   "<td align=\"right\"><strong>" . $row->price . " kn</strong></td>" .
												   "<td align=\"right\"><strong><font color=\"red\">" . $row->total ." kn</font></strong></td>" .
												   "<td></td>" .
												   "</tr>";		
					}
					
					$dataResponse = $dataResponse . "</tbody>" . 
													"<tfoot>" .
													"<tr>" .
													"<td></td>" .
													"<td></td>" .
													"<td></td>" .
													"<td></td>" .
													"<th align=\"right\">0,00 kn</td>" .
													"<th align=\"right\">0,00 kn</td>" .
													"<td></td>" .
													"<tr>" .
													"</tfoot>". 
												  "</table> " .
												  "</form>" . 
												  "</div>" .
												  "</div>" ;

					
					
					echo $dataResponse;
					
					$cn=null;
						
				} catch (PDOException $e) {
					echo $e;
				}
			break;
			
			
			
			
			
			case "fillOrderData":
				$price=0;
				$dataResponse="";
				
				$cn = new PDO(Conf::cnstring(), Conf::$dbuser, Conf::$dbpass);
				$cn->query("SET NAMES utf8");
				
				
				$query = "select (ol.id)as olID,o.id,ol.menuItemID,ml.name,ml.price,ol.quantity,(ml.price*ol.quantity)sumPrice" .
						" from orders o inner join".
						" orderslist ol on o.id=ol.ordernum inner join menulist ml on ol.menuItemID=ml.id".
						" where o.id=:orderID and o.orderState=1;";
				
				$cm = $cn->prepare($query);
				$cm->bindValue(":orderID",$data);
				$rs = $cm->execute();
				$rs = $cm->fetchAll(PDO::FETCH_OBJ);
				$total = $cm->rowCount();
				
				
				
				
				$dataResponse = "<li class=\"price\">Your Order </b></li>";
				$dataResponse =$dataResponse . "<li class=\"description\" id=\"totalItems\">Total Items: " . $total ." </li>";
				
				
				foreach ($rs as $row){
					$dataResponse = $dataResponse . "<li class=\"bullet-item\" value= \"" . $row->id . "\" id=\"priceItems_" . $row->olID ."\"> - <b>" . $row->name ."</b> (x" .  $row->quantity .")" . $row->price ." = " . $row->sumPrice;
					$dataResponse = $dataResponse . "<a href=\"#\" class=\"tiny round button alert removeProduct\" id=\"remove_".  $row->olID ."\">x</a>";
					$dataResponse = $dataResponse . "</li>";
					$price = $price + $row->sumPrice;
				} 
				
				$dataResponse = $dataResponse . "<li class=\"price\" name=\"total\" id=\"total\">TOTAL: <b>". number_format($price, 2, ',', '.') ." kn</b></li>";								
				$dataResponse = $dataResponse . "<li class=\"price\">";
				$dataResponse = $dataResponse . "<form class=\"custom\" action=\"gmaps.php\" method=\"post\">";
				$dataResponse = $dataResponse . "<input type=\"submit\" class=\"small round button success\" value=\"Next Step\" name=\"btnCommit\" />";
				$dataResponse = $dataResponse . "<input type=\"hidden\" name=\"orderID\" id=\"orderID\" value=\"". $data ."\" />";
				$dataResponse = $dataResponse . "</form>";
				$dataResponse = $dataResponse . "</li>";
								
					
					echo $dataResponse;
					
				break;
				
				
			case "chooseUnit":
				try{
					$cn = new PDO(Conf::cnstring(), Conf::$dbuser, Conf::$dbpass);
					$cn->query("SET NAMES utf8");
					$cm = $cn->prepare("select unitVal,name from unit where unitVal=:unitVal;");
					$cm->bindValue(":unitVal",$data);
					$cm->execute();
					$podaci = $cm->fetchAll();
					 
					echo json_encode( $podaci );
				
				
				} catch (PDOException $e) {
					echo $e;
				}
				break;
				
				
				
				
			case "fillMenuTable":
				try {
					$cn = new PDO(Conf::cnstring(), Conf::$dbuser, Conf::$dbpass);
					$cn->query("SET NAMES utf8");
				
					$query = "select *,getTypeName(type)typename,getUnitVal(unit)unitName, getOperName(operator)opername,
							 getCategoryName(category)category from menuList where category=". $data;
				
					$cm = $cn->prepare($query);
						
					$rs = $cm->execute();
					$rs = $cm->fetchAll(PDO::FETCH_OBJ);
// 					$total = $cm->rowCount();
				
					echo json_encode($rs);
					
					
					
					
					
// 					foreach ($rs as $row){
										
// 							$dataResponse = $dataResponse .	"<tr id=\"row_".  $row->id . "\" class=\"red\" onmouseover=\"mouseOver(this)\" onmouseout=\"mouseOut(this)\" onclick=\"mouseClick(this)\">";
// 							$dataResponse = $dataResponse . "<td id=\"id_". $row->id ."\" class=\"cell\">". $row->id; "</td>";
// 							$dataResponse = $dataResponse .	"<td id=\"name_" . $row->id . "\" class=\"cell\">".  $row->name; "</td>";
// 							$dataResponse = $dataResponse . "<td hidden id=\"category_" .$row->id . "\" class=\"cell\">" . $row->category; "</td>";
// 							$dataResponse = $dataResponse . "<td id=\"type_" .  $row->id . "\" class=\"cell\">" . $row->typename; "</td>";
// 							$dataResponse = $dataResponse . "<td id=\"unit_". $row->id ."\" class=\"cell\">" . $row->unit . "</td>";
// 							$dataResponse = $dataResponse . "<td id=\"price_".  $row->id ."\" class=\"cell\">" . $row->price ."</td>";
// 							$dataResponse = $dataResponse . "<td id=\"ingridients_" . $row->id ."\" class=\"cell\">" . $row->ingridients ."</td>";
// 							$dataResponse = $dataResponse . "<td id=\"date_". $row->id ." class=\"cell\"> date(\"d.m.Y.\",strtotime(" . $row->date ."))" ."</td>";
// 							$dataResponse = $dataResponse . "<td id=\"operator_" .  $row->id . "\" class=\"cell\">". $row->opername ."</td>";	
// 							$dataResponse = $dataResponse . "<td>";
// 							$dataResponse = $dataResponse .  "<a href=\"#\" class=\"tiny round button new\" id=\"new_" . $row->id . "\">New</a>";
// 							$dataResponse = $dataResponse . "<a href=\"#\" class=\"tiny round button alert deactivate\" id=\"deactivate_" .  $row->id .">Deactivate</a>";
// 							$dataResponse = $dataResponse . "</td>";
// 							$dataResponse = $dataResponse . "</tr>";
// 	  				}			
// 	  				echo $dataResponse;
	  				
  					//zatvaranje veze s bazom
  					$cn=null;
  							
					} catch (PDOException $e) {
						echo $e;
					}
				break;
				
			
				
			case "fillOrdersTable":
				try {
					$cn = new PDO(Conf::cnstring(), Conf::$dbuser, Conf::$dbpass);
					$cn->query("SET NAMES utf8");
				
					$query = "select (ml.id) as mlid,ml.name,ol.quantity,ml.price,(ol.quantity*ml.price)totalPrice,ol.orderNum  " .
                                 " from ordersList ol " .
								 " inner join menuList ml on ol.menuItemID=ml.id where ol.orderNum=". $data ;
				
					$cm = $cn->prepare($query);
				
					$rs = $cm->execute();
					$rs = $cm->fetchAll(PDO::FETCH_OBJ);
					$total = $cm->rowCount();
				
					echo json_encode($rs);
					
					$cn=null;
						
					} catch (PDOException $e) {
						echo $e;
					}
					
			break;
			
	}
	
}

