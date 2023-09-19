
<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if(isset($_POST['submit']))
  { 
    $password1=($_POST['newpassword']); 
    $password2=($_POST['confirmpassword']); 
   if($password1 != $password2)
    {
      echo "<script>alert('Password and Confirm Password Field do not match  !!');</script>";
    }else
    {
      $email=$_POST['email'];
      $mobile=$_POST['mobile'];
      $newpassword=md5($_POST['newpassword']);
      $sql ="SELECT Email FROM tbladmin WHERE Email=:email and MobileNumber=:mobile";
      $query= $dbh -> prepare($sql);
      $query-> bindParam(':email', $email, PDO::PARAM_STR);
      $query-> bindParam(':mobile', $mobile, PDO::PARAM_STR);
      $query-> execute();
      $results = $query -> fetchAll(PDO::FETCH_OBJ);
      if($query -> rowCount() > 0)
      {
      $con="update tbladmin set Password=:newpassword where Email=:email and MobileNumber=:mobile";
      $chngpwd1 = $dbh->prepare($con);
      $chngpwd1-> bindParam(':email', $email, PDO::PARAM_STR);
      $chngpwd1-> bindParam(':mobile', $mobile, PDO::PARAM_STR);
      $chngpwd1-> bindParam(':newpassword', $newpassword, PDO::PARAM_STR);
      $chngpwd1->execute();
      echo "<script>alert('Your Password succesfully changed');</script>";
      }
      else {
      echo "<script>alert('Email id or Mobile no is invalid');</script>"; 
      }
    }
  }

?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link href="img/logo/logo.png" rel="icon">
  <title>RuangAdmin - Login</title>
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="css/ruang-admin.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-login">
  <!-- Login Content -->
  <div class="container-login">
    <div class="row justify-content-center">
      <div class="col-xl-6 col-lg-12 col-md-9">
        <div class="card shadow-sm my-5">
          <div class="card-body p-0">
            <div class="row">
              <div class="col-lg-12">
                <div class="login-form">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Please enter below detail</h1>
                  </div>
                  <form role="form" id=""  method="post" enctype="multipart/form-data" class="form-horizontal">  
                    <div class="form-group mb-3">
                      <input type="email" class="form-control form-control-lg"  name="email" placeholder="Email"   required>
                    </div>
                    <div class="form-group mt-3" >
                      <input type="text"   name="mobile" class="form-control form-control-lg" id="exampleInputPassword1" placeholder="Mobile Number"  required>
                    </div>
                     <div class="form-group mb-3">
                      <input type="password" class="form-control form-control-lg"  name="newpassword"placeholder="New Password"   required>
                    </div>
                    <div class="form-group mt-3" >
                      <input type="password"  name="confirmpassword" class="form-control form-control-lg" id="exampleInputPassword1" placeholder="Confirm Password"  required>
                    </div>
                    <div class="mt-3">
                      <button name="submit" class="btn btn-primary btn-block">Reset</button>
                    </div>
                    <div class="text-center mt-4 font-weight-light"> 
                      <a href="index.php" class="text-primary"> 
                        Login
                      </a>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Login Content -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="js/ruang-admin.min.js"></script>
</body>

</html>