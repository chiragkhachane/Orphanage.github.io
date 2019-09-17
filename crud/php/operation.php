<?php

require_once ("db.php");
require_once ("component.php");

$con = Createdb();

// create button click
if(isset($_POST['create'])){
    createData();
}

if(isset($_POST['update'])){
    UpdateData();
}

if(isset($_POST['delete'])){
    deleteRecord();
}

if(isset($_POST['deleteall'])){
    deleteAll();

}

function createData(){

    $firstname = trim(textboxValue("firstname"));
    $lastname = trim(textboxValue("lastname"));
    $age = trim(textboxValue("age"));
    $gender = trim(textboxValue("gender"));

    if ($firstname && $lastname && $age && $gender){

        $sql = "INSERT INTO student (fname,lname, age, gender) 
                        VALUES ('$firstname','$lastname','$age','$gender')";

        if(mysqli_query($GLOBALS['con'], $sql)){
            TextNode("success", "Record Successfully Inserted...!");
        }else{
            echo "Error";
        }

    }else{
            TextNode("error", "Provide Data in the Textbox");
    }
}

function textboxValue($value){
    $textbox = mysqli_real_escape_string($GLOBALS['con'], trim($_POST[$value]));
    if(empty($textbox)){
        return false;
    }else{
        return $textbox;
    }
}


// messages
function TextNode($classname, $msg){
    $element = "<h6 class='$classname'>$msg</h6>";
    echo $element;
}


// get data from mysql database
function getData(){
    $sql = "SELECT * FROM student";

    $result = mysqli_query($GLOBALS['con'], $sql);

    if(mysqli_num_rows($result) > 0){
        return $result;
    }
}

// UPDATE DATA
function UpdateData(){
    $c_id = textboxValue("ID");
    $Firstname = textboxValue("firstname");
    $Lastname = textboxValue("lastname");
    $Age = textboxValue("age");
    $Gender = textboxValue("gender");


    if($c_id && $Firstname && $Lastname && $Age && $Gender){
        $sql = "
                    UPDATE student SET fname='$Firstname', lname = '$Lastname', age = '$Age',gender='$Gender' WHERE id='$c_id';                    
        ";

        if(mysqli_query($GLOBALS['con'], $sql)){
            TextNode("success", "Data Successfully Updated");
        }else{
            TextNode("error", "Enable to Update Data");
        }

    }else{
        TextNode("error", "Select Data Using Edit Icon");
    }


}

// DELETE DATA
function deleteRecord(){
    $id = (int)textboxValue("ID");

    $sql = "DELETE FROM student WHERE id=$id";

    if(mysqli_query($GLOBALS['con'], $sql)){
        TextNode("success","Record Deleted Successfully!");
    }else{
        TextNode("error","Enable to Delete Record...!");
    }

}


function deleteBtn(){
    $result = getData();
    $i = 0;
    if($result){
        while ($row = mysqli_fetch_assoc($result)){
            $i++;
            if($i > 3){
                buttonElement("btn-deleteall", "btn btn-danger" ,"<i class='fas fa-trash'></i> Delete All", "deleteall", "");
                return;
            }
        }
    }
}


function deleteAll(){
    $sql = "TRUNCATE TABLE student";

    if(mysqli_query($GLOBALS['con'], $sql)){
        TextNode("success","All Record deleted Successfully...!");
        Createdb();
    }else{
        TextNode("error","Something Went Wrong Record cannot deleted...!");
    }
}


// set id to textbox
function setID(){
    $getid = getData();
    $id = 0;
    if($getid){
        while ($row = mysqli_fetch_assoc($getid)){
            $id = $row['ID'];
        }
    }
    return ($id + 1);
}








