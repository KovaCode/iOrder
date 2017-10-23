<?php

class Conf{
	public static $rootdir = 'C:/xampp/htdocs';
	public static $dataroot = '/DATA99';
	public static $host='localhost';
	public static $dbname='iorder';
	public static $dbuser = 'iorder';
	public static $dbpass = 'iorder';
	public static $dbprefix = 'iorder1_';
	
	public static function cnstring(){
		return 'mysql:dbname=' . self::$dbname .' ;host=' . self::$host.';charset=utf-8';
	}
	
}

