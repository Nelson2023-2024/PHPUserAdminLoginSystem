<?php 

try{
DEFINE("HOSTNAME","localhost");
DEFINE("USERNAME","root");
DEFINE("DBPASS","");
DEFINE("DBNAME","simpledb");

$dbcon = new mysqli(HOSTNAME, USERNAME, DBPASS, DBNAME);
mysqli_set_charset($dbcon, 'utf8');

if($dbcon->connect_error)echo "connection failed";
}
catch(Exception $e){
    echo $e->getMessage();
}

