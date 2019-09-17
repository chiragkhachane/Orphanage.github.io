<?php
session_start();

if(!isset($_SESSION['username'])){
    header('location: ../crud/login/login.php');
}

include_once "../crud/login/config.php";

function TextNode($classname, $msg){
    $element = "<h6 class='$classname'>$msg</h6>";
    echo $element;
}

if(isset($_POST['add'])){
    $name=trim($_POST['name']);
    $email=trim($_POST['email']);
    $phone=trim($_POST['phone']);

    $photo=$_FILES['image']['name'];
    $upload="uploads/".$photo;

    $sql = "INSERT INTO adopters(name,email,phone,photo)VALUES(?,?,?,?)";

    $stmt=$conn->prepare($sql);

    $stmt->bind_param("ssss",$name,$email,$phone,$upload);
    $stmt->execute();
    move_uploaded_file($_FILES['image']['tmp_name'],$upload);

    $_SESSION['response']="Record Successfully Added";
    $_SESSION['res_type']="success";

}

if(isset($_GET['delete'])){
    $id=trim($_GET['delete']);

    $query="SELECT photo FROM adopters WHERE id=?";
    $stmt2=$conn->prepare($query);
    $stmt2->bind_param("i",$id);
    $stmt2->execute();
    $result2=$stmt2->get_result();
    $row=$result2->fetch_assoc();

    $imagepath=$row['photo'];
    unlink($imagepath);

    $sql="DELETE FROM adopters WHERE id=$id";
    // $stmt=$conn->prepare($sql);
    // $stmt->bind_param("i",$id);
    // $stmt->execute();

    mysqli_query($conn, $sql);
    
    header("location: adopter.php");
    $_SESSION['response']="Record Successfully Deleted";
    $_SESSION['res_type']="danger";
}

$update=false;
$id="";
$name="";
$email="";
$phone="";
$photo="";

if(isset($_GET['edit'])){
    $id=$_GET['edit'];

    $sql="SELECT * FROM adopters where id=?";
    $stmt=$conn->prepare($sql);
    $stmt->bind_param("i",$id);
    $stmt->execute();
    $result=$stmt->get_result();
    $row=$result->fetch_assoc();

    $id=$row['id'];
    $name=$row['name'];
    $email=$row['email'];
    $phone=$row['phone'];
    $photo=$row['photo'];

    $update=true;

}

if(isset($_POST['update'])){
    $id=$_POST['id'];
    $name=$_POST['name'];
    $email=$_POST['email'];
    $phone=$_POST['phone'];
    $oldimage=$_POST['oldimage'];

    if(isset($_FILES['image']['name']) && ($_FILES['image']['name']!="")){
        $newimage="uploads/".$_FILES['image']['name'];
        unlink($oldimage);
        move_uploaded_file($_FILES['image']['tmp_name'], $newimage);
    }
    else{
        $newimage=$oldimage;
    }

    $sql="UPDATE adopters SET name=?, email=?, phone=?,photo=? WHERE id=?";
    $stmt=$conn->prepare($sql);
    $stmt->bind_param("ssssi",$name,$email,$phone,$newimage,$id);
    $stmt->execute();

    $_SESSION['response']="Updated Successfully";
    $_SESSION['res_type']="primary";
    header('location: adopter.php');

}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</head>
<body>
    
<nav class="navbar navbar-expand-md bg-dark navbar-dark">
  <!-- Brand -->
  <a class="navbar-brand" href="login/logout.php">Pheonix Home</a>

  <!-- Toggler/collapsibe Button -->
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
    <span class="navbar-toggler-icon"></span>
  </button>

  <!-- Navbar links -->
  <div class="collapse navbar-collapse" id="collapsibleNavbar">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" href="home.php">Home</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="Childrec.php">Child Records</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="adopter.php">Adopters</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="teachers.php">Teachers</a>
        </li>
        <li class="nav-item active">
        <a class="nav-link" href="donor.php">Donations <span class="sr-only">(current)</span></a>
      </li>
    </ul>
  </div> 
  <form class="form-inline" action="/action_page.php">
            <input class="form-control mr-sm-2" type="text" placeholder="Search">
            <button class="btn btn-primary" type="submit">Search</button>
    </form>  
    </div>

</nav>

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <h3 class="text-center text-dark mt-2">Adopter Detail</h3>
                <hr> 
                <?php if(isset($_SESSION['response'])){ ?>
                <div class="alert alert-<?= $_SESSION['res_type'] ?> alert-dissmissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <?= $_SESSION['response']; ?>
                </div>
                <?php } unset($_SESSION['response']);?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <h3 class="text-center text-info">Add Record</h3>
                <form action="" method="post" enctype="multipart/form-data">
                     <input type="hidden" name="id" value="<?= $id; ?>">
                    <div class="form-group">
                        <input type="text" name="name" value="<?=$name; ?>" class="form-control" placeholder="Name" required>
                    </div>
                    <div class="form-group">
                        <input type="email" name="email" value="<?=$email; ?>" class="form-control" placeholder="E-mail" required>
                    </div>

                    <div class="form-group">
                        <input type="tel" name="phone" value="<?=$phone; ?>" class="form-control" placeholder="Mobile no" required>
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="oldimage" value="<? $photo; ?>">
                        <input type="file" name="image" class="custom-file">
                        <img src="<?= $photo; ?>" width="120" class="img-thumbnail ">
                    </div>
                    <div class="form-group">
                        <?php if($update==true) { ?>
                            <input type="submit" name="update" class="btn btn-success btn-block" value="Update Record"> 
                        <?php } else{ ?>
                        <input type="submit" name="add" class="btn btn-primary btn-block" value="Add Record">
                        <?php } ?>
                    </div>
                </form>
            </div>
            <div class="col-md-8">
                <?php 
                    $sql="SELECT * FROM adopters";
                    $stmt=$conn->prepare($sql);
                    $stmt->execute();
                    $result=$stmt->get_result();               
                ?>
                <h3 class="text-center text-info">Records </h3> 

                <div class="container">
                    <table class="table table-border table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($row=$result->fetch_assoc()){ ?>
                            <tr>
                                <td><?= $row['id']; ?></td>
                                <td><img src="<?= $row['photo']; ?>" width="25"></td>
                                <td><?= $row['name']; ?></td>
                                <td><?= $row['email']; ?></td>
                                <td><?= $row['phone']; ?></td>
                                <td> 
                                    <!-- <a href="details/adopterdetails.php?details=<?= $row['id']; ?>" class="badge badge-primary p-2">Details</a> | -->
                                    | <a href="adopter.php?edit=<?= $row['id']; ?>" class="badge badge-success p-2">Edit</a> |
                                    <a href="adopter.php?delete=<?= $row['id']; ?>" class="badge badge-danger p-2" onclick="return confirm('Confirm delete?')">Delete</a> |
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

<div class="container text-center">
    <div class="py-4 bg-dark text-light rounded">
        <div class="container center-div shadow">
            <a href="../crud/login/logout.php" class="btn btn-danger">Logout</a>
        </div>
    </div>
</div>

</body>
</html>