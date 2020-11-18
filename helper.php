<?php

$dbserver = "mysql:host=localhost;dbname=zhawk";
$dbuser = "root";
$dbpass = "";
$conn = new PDO($dbserver, $dbuser, $dbpass);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


class ResponseModel
{
    public $Status;
    public $Result;
    public $Error;
}

class UserModel
{
    public $Name;
    public $Mobile;
    public $Email;
    public $Status;
    public $Notes;
    public $CDate;
}

function testinput($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = addslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function ExecuteQuery($query)
{
    global $conn;
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $results;
}

function ExecuteSingleQuery($query)
{
    global $conn;
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $results = $stmt->fetch();
    return $results;
}

function ExecuteNonQuery($query, $obj)
{
    global $conn;
    $stmt = $conn->prepare($query);
    $stmt->execute((array)$obj);
    return true;
}


function ExecuteNonObjectQuery($query)
{
    global $conn;
    $stmt = $conn->prepare($query);
    $stmt->execute();
    return true;
}
