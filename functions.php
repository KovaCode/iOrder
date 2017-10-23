<?php


function checkText($attribute,$val,$min,$max){
	$errMessage="";
	$chk=true;
	
	if(strlen($val)<=$min){
		$errMessage=$errMessage . "<br />DuÅ¾ina atributa " . $attribute . " mora biti veæa od " . $min . "!  Trenutna duina je: " . strlen($val);
		$chk= false;
	}

	if(strlen($val)>$max){
		$errMessage=$errMessage . "<br />DuÅ¾ina atributa " . $attribute . "  ne smije biti veæa od " . $max . " znakova! Trenutna duina je: " . strlen($val);
		$chk= false;
	}
	return $chk;
}

?>







