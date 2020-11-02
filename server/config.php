<?php
$dbserver = "mysql:host=localhost;dbname=zhawk";
$dbuser = "root";
$dbpass = "";
$conn = new PDO($dbserver, $dbuser, $dbpass);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

