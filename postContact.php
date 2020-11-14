<?php

require_once('helper.php');

$responseobj = new ResponseModel();

if (isset($_POST["GetUserList"])) GetUserList();
else if (isset($_POST["AddContact"])) AddContact();
else if (isset($_POST["GetUserDetails"])) GetUserDetails();
else if (isset($_POST["DeleteContact"])) DeleteContact();
else if (isset($_POST["UpdateStatus"])) UpdateStatus();
else {
    http_response_code(401);
    $responseobj->Status = false;
    $responseobj->Result = "Unauthorized";
    print_r(json_encode($responseobj));
}


function AddContact()
{
    global $responseobj;
    try {
        $userobj = AssignValues();
        $modelobj = array_keys(get_class_vars('UserModel'));
        $colname = implode(",", $modelobj);
        $colval = implode(",:", $modelobj);
        $query = 'INSERT INTO tbl_user ( ' . $colname . ' ) VALUES (:' . $colval . '); ';
        $response = ExecuteNonQuery($query, $userobj);
        $responseobj->Status = true;
        $responseobj->Result = "User Registered Successfully!";
    } catch (PDOException $e) {
        http_response_code(500);
        $responseobj->Status = false;
        $responseobj->Error = $e->getMessage();
    } finally {
        print_r(json_encode($responseobj));
    }
}

function AssignValues()
{
    $userobj = new UserModel();

    $userobj->FullName = isset($_POST["FullName"]) ? $_POST["FullName"] : "";
    $userobj->Mobile = isset($_POST["Mobile"]) ? $_POST["Mobile"] : "";
    $userobj->Email = isset($_POST["Email"]) ? $_POST["Email"] : "";
    $userobj->Notes = isset($_POST["Notes"]) ? $_POST["Notes"] : "";
    $PasswordHash =  isset($_POST["Password"]) ? $_POST["Password"] : "";
    $userobj->Password = password_hash($PasswordHash, PASSWORD_DEFAULT);
    $userobj->Status = isset($_POST["Status"]) ? $_POST["Status"] : "";
    $userobj->CDate = date('Y-m-d H:i:s');

    return $userobj;
}

function GetUserList()
{
    $responseobj = new ResponseModel();
    try {
        $query = "SELECT * from tbl_user order by UserId desc";
        $response = ExecuteQuery($query);
        $responseobj->Status = "Success";
        $responseobj->Result = json_encode($response);
    } catch (PDOException $e) {
        http_response_code(500);
        $responseobj->Status = "Failed";
        $responseobj->Error = $e->getMessage();
    } finally {
        print_r(json_encode($responseobj));
    }
}

function GetUserDetails()
{
    $UserId = testinput($_POST["UserId"]);
    $responseobj = new ResponseModel();
    try {
        $query = "SELECT * from tbl_user where UserId = " . $UserId;
        $response = ExecuteQuery($query);
        $responseobj->Status = "Success";
        $responseobj->Result = json_encode($response);
    } catch (PDOException $e) {
        http_response_code(500);
        $responseobj->Status = "Failed";
        $responseobj->Error = $e->getMessage();
    } finally {
        print_r(json_encode($responseobj));
    }
}

function DeleteContact()
{
    $UserId = testinput($_POST["UserId"]);
    $responseobj = new ResponseModel();
    try {
        $query = "Delete from tbl_user where UserId = " . $UserId;
        $response = ExecuteNonObjectQuery($query);
        $responseobj->Status = "Success";
        $responseobj->Result = json_encode($response);
    } catch (PDOException $e) {
        http_response_code(500);
        $responseobj->Status = "Failed";
        $responseobj->Error = $e->getMessage();
    } finally {
        print_r(json_encode($responseobj));
    }
}

function UpdateStatus()
{
    $UserId = testinput($_POST["UserId"]);
    $Status = testinput($_POST["Status"]);
    $responseobj = new ResponseModel();
    try {
        $query = "Update tbl_user  set Status = '" . $Status . "' where UserId = " . $UserId;
        $response = ExecuteNonObjectQuery($query);
        $responseobj->Status = "Success";
        $responseobj->Result = json_encode($response);
    } catch (PDOException $e) {
        http_response_code(500);
        $responseobj->Status = "Failed";
        $responseobj->Error = $e->getMessage();
    } finally {
        print_r(json_encode($responseobj));
    }
}
