<?php
include("conection.php");
$conection = new Database();

$conection->insert("student", ["Name"=>"Vikash Shukla", "Role"=> 20]);

echo $conection->getResult()[0]. " is last inserted value's id";

?>