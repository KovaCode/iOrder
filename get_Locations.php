<?php
     
    require 'configuration.php';
     
    
    if (isset($_GET['idMap'])){
    	$mapID = $_GET['idMap'];
    }else{
    	$mapID=0;
    }
    
    try {
        $db =  new PDO(Conf::cnstring(), Conf::$dbuser, Conf::$dbpass);
        $db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
         
        
        if ($mapID==0){
        	$sth = $db->query("SELECT * FROM locations");
        }else{
        	$sth = $db->query("SELECT * FROM locations where id=" . $mapID);
        }
        
        $locations = $sth->fetchAll();
         
        echo json_encode( $locations );
         
    } catch (Exception $e) {
        echo $e->getMessage();
    }
    