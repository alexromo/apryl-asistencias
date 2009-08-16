<?php
// logout.php - destroys session and returns to login form

// destroy all session variables
//include_once('adodb/session/adodb-session2.php');
//include_once("php/conf/dbsessionconfig.php");

//$driver = 'mysql'; $host = 'localhost'; $user = 'asistdbuser'; $pwd = 'asistencia'; $database = 'asistencia';
//ADOdb_Session::config($driver, $host, $user, $pwd, $database,$options=false);
//adodb_sess_open(false,false,$connectMode=false);
session_start();
session_destroy();

// redirect browser back to login page
header("Location: index.php");
?>
