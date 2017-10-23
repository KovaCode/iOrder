<?php
include_once 'configuration.php';
session_start();
session_destroy();
header("location: welcome.php");