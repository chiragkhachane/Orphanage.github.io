<?php
// include("../crud/login/login.php");
session_start();

if(!isset($_SESSION['username'])){
    header('location: ../crud/login/login.php');
}

require_once ("../crud/php/component.php");
require_once ("../crud/php/operation.php");



?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Child Record</title>

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
        <a class="nav-link" href="home.php">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="childrec.php">Child Record <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="adopter.php">Adopters <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="#">Expences <span class="sr-only">(current)</span></a>
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
        <h1 class="py-4 bg-dark text-light rounded"><i class="fas fa-swatchbook"></i>Child record</h1>

        <div class="d-flex justify-content-center">
            <form action="" method="post" class="w-50">
                <!-- <div class="input-group-text">@</div> -->   
                <div class="pt-2">
                    <!-- <?php echo inputElement("<i class='fas fa-id-badge'></i>","ID", "id",setID()); ?> -->
                    <input type="text" id="inlineFormInputGroup" name="ID" value="" class="form-control" placeholder="ID" autocomplete="off" >
                </div>
                
                <div class="row pt-2">
                    <div class="col">
                    <input type="text" id="inlineFormInputGroup" name="firstname" value="" class="form-control" placeholder="Firstname">
                    </div>
                
                    <div class="col">
                    <input type="text" id="inlineFormInputGroup" name="lastname" value="" class="form-control" placeholder="Lastname">
                    </div>
                </div>
                <div class="row pt-2">
                    <div class="col">
                        <input type="text" id="inlineFormInputGroup" name="age" value="" class="form-control" placeholder="Age">
                    </div>
                    <div class="col">
                        <input type="text" id="inlineFormInputGroup" name="gender" value="" class="form-control" placeholder="Gender">
                    </div>
                </div>
                <div class="d-flex justify-content-center">
                        <!-- <?php 
                        buttonElement("btn-create","btn btn-success","<i class='fas fa-plus'></i>","create","data-toggle='tooltip' data-placement='bottom' title='Create'"); 
                        ?>
                        <?php buttonElement("btn-read","btn btn-primary","<i class='fas fa-sync'></i>","read","data-toggle='tooltip' data-placement='bottom' title='Read'"); ?>
                        <?php buttonElement("btn-update","btn btn-light border","<i class='fas fa-pen-alt'></i>","update","data-toggle='tooltip' data-placement='bottom' title='Update'"); ?>
                        <?php buttonElement("btn-delete","btn btn-danger","<i class='fas fa-trash-alt'></i>","delete","data-toggle='tooltip' data-placement='bottom' title='Delete'"); ?>
                        <?php deleteBtn();?> -->
                        <button name='create' text="<i class='fas fa-plus'></i>"  class='btn btn-success' dat-toggle='tooltip' data-placement='bottom' title="Create" id='$btn-create'><i class='fas fa-plus'></i> </button>
                        <button name='read' text="<i class='fas fa-sync'></i>" class='btn btn-primary' dat-toggle='tooltip' data-placement='bottom' title="Read" id='$btn-read'><i class='fas fa-sync'></i> </button>
                        <button name='update' text="<i class='fas fa-pen-alt'></i>" class='btn btn-light border' dat-toggle='tooltip' data-placement='bottom' title="Update" id='$btn-update'><i class='fas fa-pen-alt'></i> </button>
                        <button name='delete' text="<i class='fas fa-trash-alt'></i>" class='btn btn-danger' dat-toggle='tooltip' data-placement='bottom' title="Delete" id='$btn-delete'><i class='fas fa-trash-alt'></i> </button>
                </div>
            </form>
        </div>

        <!-- Bootstrap table  -->
        <div class="d-flex table-data">
            <table class="table table-striped table-dark">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Age</th>
                        <th>Gender</th>
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
                                   <td data-id="<?php echo $row['id']; ?>"> <?php echo $row['id']; ?></td>
                                   <td data-id="<?php echo $row['id']; ?>"> <?php echo $row['fname']; ?></td>
                                   <td data-id="<?php echo $row['id']; ?>"> <?php echo $row['lname']; ?></td>
                                   <td data-id="<?php echo $row['id']; ?>"> <?php echo $row['age']; ?></td>
                                   <td data-id="<?php echo $row['id']; ?>"> <?php echo $row['gender']; ?></td>
                                   <td><i class="fas fa-edit btnedit" data-id="<?php echo $row['id']; ?>"></i></td>
                                   <!-- <td><i class="fas fa-edit btnedit" data-id="<?php echo $row['id']; ?>"></i></td> -->
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
</main>

<div class="container text-center">
    <div class="py-4 bg-dark text-light rounded">
        <div class="container center-div shadow">
            <a href="../crud/login/logout.php" class="btn btn-danger">Logout</a>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

<script src="../js/one.js"></script>
</body>
</html>
