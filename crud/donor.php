<?php
session_start();

if(!isset($_SESSION['username'])){
    header('location: ../crud/login/login.php');
}

require_once ("login/config.php");
//require_once ("component.php");

function inputElement($icon, $placeholder, $name, $value){
    $ele = "
        
        <div class=\"input-group mb-2\">
                        <div class=\"input-group-prepend\">
                            <div class=\"input-group-text bg-warning\">$icon</div>
                        </div>
                        <input type=\"text\" name='$name' value='$value' autocomplete=\"off\" placeholder='$placeholder' class=\"form-control\" id=\"inlineFormInputGroup\" placeholder=\"Username\">
                    </div>
    
    ";
    echo $ele;
}

function buttonElement($btnid, $styleclass, $text, $name, $attr){
    $btn = "
        <button name='$name' '$attr' class='$styleclass' id='$btnid'>$text</button>
    ";
    echo $btn;
}


// $con = Createdb();

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
    $donorid = textboxValue("donor_id");
    $donorname = textboxValue("donor_name");
    $fundamount = textboxValue("fund_amount");
    $transactionid = textboxValue("transaction_id");
    $paymentmethod = textboxValue("payment_method");
    $dateofdonation = textboxValue("date_of_donation");

    if($donorname && $fundamount && $transactionid && $paymentmethod && $dateofdonation){

        $sql = "INSERT INTO donors (donor_id, donor_name, fund_amount,transaction_id,payment_method,date_of_donation) 
                        VALUES ('$donorid','$donorname','$fundamount','$transactionid','$paymentmethod','$dateofdonation')";

        if(mysqli_query($GLOBALS['conn'], $sql)){
            TextNode("success", "Record Successfully Inserted...!");
        }else{
            echo "Error";
        }

    }else{
            TextNode("error", "Provide Data in the Textbox");
    }
}
function textboxValue($value){
    $textbox = mysqli_real_escape_string($GLOBALS['conn'], trim($_POST[$value]));
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
    $sql = "SELECT * FROM donors";

    $result = mysqli_query($GLOBALS['conn'], $sql);

    if(mysqli_num_rows($result) > 0){
        return $result;
    }
}
// update dat
function UpdateData(){
    $donorid = textboxValue("donor_id");
    $donorname = textboxValue("donor_name");
    $fundamount = textboxValue("fund_amount");
    $transactionid = textboxValue("transaction_id");
    $paymentmethod = textboxValue("payment_method");
    $dateofdonation = textboxValue("date_of_donation");
    if($donorid && $donorname && $fundamount && $transactionid && $paymentmethod && $dateofdonation){
        $sql = "
                    UPDATE donors SET donor_name='$donorname', fund_amount = '$fundamount', transaction_id =' $transactionid', payment_method = '$paymentmethod', date_of_donation = '$dateofdonation' WHERE donor_id='$donorid';                    
        ";

        if(mysqli_query($GLOBALS['conn'], $sql)){
            TextNode("success", "Data Successfully Updated");
        }else{
            TextNode("error", "Enable to Update Data");
        }

    }else{
        TextNode("error", "Select Data Using Edit Icon");
    }


}

function deleteRecord(){
    $donorid = (int)textboxValue("donor_id");

    $sql = "DELETE FROM donors WHERE donor_id=$donorid";

    if(mysqli_query($GLOBALS['conn'], $sql)){
        TextNode("success","Record Deleted Successfully...!");
    }else{
        TextNode("error","Unable to Delete Record...!");
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
// set id to textbox
function setID(){
    $getid = getData();
    $donorid = 0;
    if($getid){
        while ($row = mysqli_fetch_assoc($getid)){
            $donorid = $row['donor_id'];
        }
    }
    return ($donorid + 1);
}


?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Donor Information</title>

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <!-- Custom stylesheet -->
    <link rel="stylesheet" href="style.css">

</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="login/logout.php">Pheonix Home</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="Childrec.php">Child Record <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="adopter.php">Adopters <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="teachers.php">Teachers <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="donor.php">Donations <span class="sr-only">(current)</span></a>
      </li>
    </ul>
    <form class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>
  </div>
</nav>

<main>
    <div class="container text-center p-2">
        <h1 class="py-4 bg-dark text-light rounded"><i class="fas fa-swatchbook"></i> Donor Information</h1>

        <div class="d-flex justify-content-center">
            <form action="" method="post" class="w-50">
                <div class="pt-2">
                <div class="row pt-2">
                    <div class="col-md-6">
                        <?php inputElement("<i class='fas fa-id-badge'></i>","Donor ID", "donor_id",""); ?>
                        <!-- <input type="text" id="inlineFormInputGroup" name="donor_id" value="" class="form-control" placeholder="Donor ID" autocomplete="off" > -->
                    </div>
                    <div class="col-md-6">
                        <?php inputElement("<i class='fas fa-book'></i>","Donor Name", "donor_name",""); ?>
                    </div>
                    <div class="col-md-6">
                        <?php inputElement("<i class='fas fa-hand-holding-usd'></i>","Fund Amount", "fund_amount",""); ?>
                    </div>
                    <!-- <div class="row pt-2"> -->
                    <div class="col-md-6">
                        <?php inputElement("<i class='fas fa-id-badge'></i>","Transaction ID", "transaction_id",""); ?>
                    </div>
                    <div class="col-md-6">
                        <?php inputElement("<i class='fas fa-book'></i>","Payment method", "payment_method",""); ?>
                    </div>
                    <div class="col-md-6">
                        <?php inputElement("<i class='fas fa-calendar-week'></i>","Date of donation", "date_of_donation",""); ?>
                    </div>
                    
                </div>
                <div class="d-flex justify-content-center">
                        <?php buttonElement("btn-create","btn btn-success","<i class='fas fa-plus'></i>","create","data-toggle='tooltip' data-placement='bottom' title='Create'"); ?>
                        <?php buttonElement("btn-read","btn btn-primary","<i class='fas fa-sync'></i>","read","data-toggle='tooltip' data-placement='bottom' title='Read'"); ?>
                        <?php buttonElement("btn-update","btn btn-light border","<i class='fas fa-pen-alt'></i>","update","data-toggle='tooltip' data-placement='bottom' title='Update'"); ?>
                        <?php buttonElement("btn-delete","btn btn-danger","<i class='fas fa-trash-alt'></i>","delete","data-toggle='tooltip' data-placement='bottom' title='Delete'"); ?>
                        <?php deleteBtn();?>
                    </div>
            </div>
            </form>
        </div>

        <!-- Bootstrap table  -->
        <div class="d-flex table-data">
            <table class="table table-striped table-dark">
                <thead class="thead-dark">
                    <tr>
                        <th>Donor ID</th>
                        <th>Donor Name</th>
                        <th>Fund amount</th>
                        <th>Transaction ID</th>
                        <th> Payment method </th>
                        <th> Date of Donation </th>
                        <th>Edit</th>
                    </tr>
                </thead>
                <tbody id="tbody">
                <?php


if(isset($_POST['read'])){
    $result = getData();

    if($result){

        while ($row = mysqli_fetch_assoc($result)){ ?>

            <tr>
                <td data-id="<?php echo $row['id']; ?>"><?php echo $row['donor_id']; ?></td>
                <td data-id="<?php echo $row['id']; ?>"><?php echo $row['donor_name']; ?></td>
                <td data-id="<?php echo $row['id']; ?>"><?php echo $row['fund_amount']; ?></td>
                <td data-id="<?php echo $row['id']; ?>"><?php echo $row['transaction_id']; ?></td>
                <td data-id="<?php echo $row['id']; ?>"><?php echo $row['payment_method']; ?></td>
                <td data-id="<?php echo $row['id']; ?>"><?php echo $row['date_of_donation']; ?></td>
                <td ><i class="fas fa-edit btnedit" data-id="<?php echo $row['id']; ?>"></i></td>
            </tr>

<?php
        }

    }
}


?>
</tbody>
</table>
</div>


</div>
<div class="container text-center">
    <div class="py-4 bg-dark text-light rounded">
        <div class="container center-div shadow">
            <a href="../crud/login/logout.php" class="btn btn-danger">Logout</a>
</div>
</div>
</div> 
</main>




<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

<script src="../js/donor.js"></script>
</body>
</html>