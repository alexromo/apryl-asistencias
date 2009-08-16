<?php
// session check
//include_once('adodb/session/adodb-session2.php');
//include_once("php/conf/dbsessionconfig.php");

//adodb_sess_open(false,false,$connectMode=false);
session_start();

if (!isset($_SESSION['uid']))
{
	// if session check fails, invoke error handler
	header("Location: index.php");
	exit();
}
?>