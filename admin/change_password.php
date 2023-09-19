<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
error_reporting(0);
if (strlen($_SESSION['odmsaid']==0)) 
{
  header('location:logout.php');
} else{
  if(isset($_POST['submit']))
  {
    $adminid=$_SESSION['odmsaid'];
    $cpassword=md5($_POST['currentpassword']);
    $newpassword=md5($_POST['newpassword']);
    $sql ="SELECT ID FROM tbladmin WHERE ID=:adminid and Password=:cpassword";
    $query= $dbh -> prepare($sql);
    $query-> bindParam(':adminid', $adminid, PDO::PARAM_STR);
    $query-> bindParam(':cpassword', $cpassword, PDO::PARAM_STR);
    $query-> execute();
    $results = $query -> fetchAll(PDO::FETCH_OBJ);

    if($query -> rowCount() > 0)
    {
      $con="update tbladmin set Password=:newpassword where ID=:adminid";
      $chngpwd1 = $dbh->prepare($con);
      $chngpwd1-> bindParam(':adminid', $adminid, PDO::PARAM_STR);
      $chngpwd1-> bindParam(':newpassword', $newpassword, PDO::PARAM_STR);
      $chngpwd1->execute();

      echo '<script>alert("Your password successully changed")</script>';
    } else {
      echo '<script>alert("Your current password is wrong")</script>';

    }
  }
  ?>
  <!DOCTYPE html>
  <html lang="en">
  <script type="text/javascript">
    function checkpass()
    {
      if(document.changepassword.newpassword.value!=document.changepassword.confirmpassword.value)
      {
        alert('New Password and Confirm Password field does not match');
        document.changepassword.confirmpassword.focus();
        return false;
      }
      return true;
    }   

  </script>

  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="img/logo/logo.png" rel="icon">
    <title>Admin - Update User Profile</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="css/ruang-admin.min.css" rel="stylesheet">
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
  </head>

  <body id="page-top">
    <div id="wrapper">
      <!-- Sidebar -->
      <?php include('includes/sidebar.php');?>
      <!-- Sidebar -->
      <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
          <!-- TopBar -->
          <?php include('includes/header.php');?>
          <!-- Topbar -->
          <!-- Container Fluid-->
          <div class="container-fluid" id="container-wrapper">
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
              <h1 class="h3 mb-0 text-gray-800">Password</h1>
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Change Password</li>
              </ol>
            </div>

            <!-- Row -->
            <div class="row">
              <!-- Datatables -->
              <!-- DataTable with Hover -->
              <div class="col-lg-12">
                <div class="card mb-4">
                  <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Change Password</h6>
                  </div>
                  <div class="card-body">
                    <form method="post" onsubmit="return checkpass();" name="changepassword">
                      <div class="form-group row">
                        <label class="col-12" for="register1-username">Current Password:</label>
                        <div class="col-12">
                          <input type="password" class="form-control" name="currentpassword" id="currentpassword"required='true'>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-12" for="register1-email">New Password:</label>
                        <div class="col-12">
                         <input type="password" class="form-control" name="newpassword"  class="form-control"  required="true">
                       </div>
                     </div>
                     <div class="form-group row">
                      <label class="col-12" for="register1-password">Confirm Password:</label>
                      <div class="col-12">
                        <input type="password" class="form-control"  name="confirmpassword" id="confirmpassword"  required='true'>
                      </div>
                    </div>

                    <div class="form-group row">
                      <div class="col-12">
                        <button type="submit" class="btn btn-primary" name="submit">
                          <i class="fa fa-plus "></i> Change
                        </button>
                      </div>
                    </div>
                  </form>
                  
                </div>
              </div>
            </div>
          </div>
          <!--Row-->

          <!-- Modal Logout -->
          <?php include('includes/modal.php');?>

        </div>
        <!---Container Fluid-->
      </div>

      <!-- Footer -->
      <?php include('includes/footer.php');?>
      <!-- Footer -->
    </div>
  </div>

  <!-- Scroll to top -->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="js/ruang-admin.min.js"></script>
  <!-- Page level plugins -->
  <script src="vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Page level custom scripts -->
  <script>
    $(document).ready(function () {
      $('#dataTable').DataTable(); // ID From dataTable 
      $('#dataTableHover').DataTable(); // ID From dataTable with Hover
    });
  </script>

</body>

</html>
<?php
}  ?>