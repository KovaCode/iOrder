<?php


function checkText($attribute,$val,$min,$max){
	$errMessage="";
	$chk=true;
	
	if(strlen($val)<=$min){
		$errMessage=$errMessage . "<br />Dužina atributa " . $attribute . " mora biti ve�a od " . $min . "!  Trenutna du�ina je: " . strlen($val);
		$chk= false;
	}

	if(strlen($val)>$max){
		$errMessage=$errMessage . "<br />Dužina atributa " . $attribute . "  ne smije biti ve�a od " . $max . " znakova! Trenutna du�ina je: " . strlen($val);
		$chk= false;
	}
	return $chk;
}

?>







