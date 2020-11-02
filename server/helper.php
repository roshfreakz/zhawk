<?php

require_once('config.php');

function testinput($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = addslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function GetRandomString($len)
{
    return substr(md5(time()), 0, $len);
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
