<?php

require_once('model.php');

$responseobj = new ResponseModel();

if (isset($_POST["CheckLogin"])) CheckLogin();
else if (isset($_POST["RegisterUser"])) RegisterUser();
else if (isset($_POST["getstaffdetails"])) GetStaffDetails();
else {
    http_response_code(401);
    $responseobj->Status = false;
    $responseobj->Result = "Unauthorized";
    print_r(json_encode($responseobj));
}

function CheckLogin()
{
    global $responseobj;
    $Email = testinput($_POST["Email"]);
    $Password = testinput($_POST["Password"]);
    try {
        $query = "SELECT * from tbl_user where Email = '" . $Email . "'";
        $response = ExecuteSingleQuery($query);
        if ($response) {
            $passwordHash = $response["Password"];
            if (password_verify($Password, $passwordHash)) {
                $responseobj->Status = true;
                $responseobj->Result = json_encode($response);
            } else {
                $responseobj->Status = false;
                $responseobj->Error = "Incorrect Password";
            }
        } else {
            $responseobj->Status = false;
            $responseobj->Error = "Incorrect Email";
        }
    } catch (PDOException $e) {
        http_response_code(500);
        $responseobj->Status = false;
        $responseobj->Error = $e->getMessage();
    } finally {
        print_r(json_encode($responseobj));
    }
}

function RegisterUser()
{
    global $responseobj;
    try {
        $staffobj = AssignValues();
        $modelobj = array_keys(get_class_vars('UserModel'));
        $colname = implode(",", $modelobj);
        $colval = implode(",:", $modelobj);
        $query = 'INSERT INTO tbl_user ( ' . $colname . ' ) VALUES (:' . $colval . '); ';
        $response = ExecuteNonQuery($query, $staffobj);
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
    $staffobj = new UserModel();

    $staffobj->FullName = isset($_POST["FullName"]) ? $_POST["FullName"] : "";
    $staffobj->Email = isset($_POST["Email"]) ? $_POST["Email"] : "";
    $PasswordHash =  isset($_POST["Password"]) ? $_POST["Password"] : "";
    $staffobj->Password = password_hash($PasswordHash, PASSWORD_DEFAULT);
    $staffobj->Status = true;
    $staffobj->CDate = date('Y-m-d H:i:s');

    return $staffobj;
}

function GetStaffList()
{
    $responseobj = new ResponseModel();
    try {
        $query = "SELECT * from tbl_staff order by StaffId desc";
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

function GetStaffDetails()
{
    $StaffId = testinput($_POST["StaffId"]);
    $responseobj = new ResponseModel();
    try {
        $query = "SELECT * from tbl_staff where StaffId = " . $StaffId;
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
