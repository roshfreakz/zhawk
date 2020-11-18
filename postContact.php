<?php

require_once('helper.php');

$responseobj = new ResponseModel();

if (isset($_POST["GetContact"])) {
    if (isset($_POST["Id"])) {
        GetContactDetails();
    } else {
        GetContactList();
    }
} else if (isset($_POST["ModifyContact"])) {
    switch ($_POST["ModifyContact"]) {
        case "Add":
            AddContact();
            break;
        case "Update":
            UpdateContact();
            break;
        case "Delete":
            DeleteContact();
            break;
    }
} else {
    http_response_code(401);
    $responseobj->Status = false;
    $responseobj->Result = "Unauthorized";
    print_r(json_encode($responseobj));
}

function GetContactList()
{
    global $responseobj;
    try {
        $query = "SELECT * from tbl_contact order by Id desc";
        $response = ExecuteQuery($query);
        $responseobj->Status = true;
        $responseobj->Result = json_encode($response);
    } catch (PDOException $e) {
        http_response_code(500);
        $responseobj->Status = false;
        $responseobj->Error = $e->getMessage();
    } finally {
        print_r(json_encode($responseobj));
    }
}

function GetContactDetails()
{
    global $responseobj;
    $Id = testinput($_POST["Id"]);
    try {
        $query = "SELECT * from tbl_contact where Id=" . $Id;
        $response = ExecuteSingleQuery($query);
        $responseobj->Status = true;
        $responseobj->Result = $response;
    } catch (PDOException $e) {
        http_response_code(500);
        $responseobj->Status = false;
        $responseobj->Error = $e->getMessage();
    } finally {
        print_r(json_encode($responseobj));
    }
}

function AddContact()
{
    global $responseobj;
    try {
        $userobj = AssignValues();
        $modelobj = array_keys(get_class_vars('UserModel'));
        $colname = implode(",", $modelobj);
        $colval = implode(",:", $modelobj);
        $query = 'INSERT INTO tbl_contact ( ' . $colname . ' ) VALUES (:' . $colval . '); ';
        ExecuteNonQuery($query, $userobj);
        $responseobj->Status = true;
        $responseobj->Result = "Contact Added Successfully";
    } catch (PDOException $e) {
        http_response_code(500);
        $responseobj->Status = false;
        $responseobj->Error = $e->getMessage();
    } finally {
        print_r(json_encode($responseobj));
    }
}

function UpdateContact()
{
    global $responseobj;
    $Id = testinput($_POST["Id"]);
    try {
        $userobj = AssignValues();
        $query = 'UPDATE tbl_contact SET Name=:Name, Mobile=:Mobile, Email=:Email, Notes=:Notes, Status=:Status, CDate=:CDate where Id=' . $Id;
        ExecuteNonQuery($query, $userobj);
        $responseobj->Status = true;
        $responseobj->Result = "Contact Updated Successfully";
    } catch (PDOException $e) {
        http_response_code(500);
        $responseobj->Status = false;
        $responseobj->Error = $e->getMessage();
    } finally {
        print_r(json_encode($responseobj));
    }
}

function DeleteContact()
{
    global $responseobj;
    $Id = testinput($_POST["Id"]);
    try {
        $query = "Delete from tbl_contact where Id = " . $Id;
        ExecuteNonObjectQuery($query);
        $responseobj->Status = true;
        $responseobj->Result = "Contact Deleted Successfully!";
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
    $userobj->Name = isset($_POST["Name"]) ? $_POST["Name"] : "";
    $userobj->Mobile = isset($_POST["Mobile"]) ? $_POST["Mobile"] : "";
    $userobj->Email = isset($_POST["Email"]) ? $_POST["Email"] : "";
    $userobj->Notes = isset($_POST["Notes"]) ? $_POST["Notes"] : "";
    $userobj->Status = isset($_POST["Status"]) ? $_POST["Status"] : "";
    $userobj->CDate = date('Y-m-d H:i:s');
    return $userobj;
}
