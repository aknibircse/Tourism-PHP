<?php
include('includes/checklogin.php');
check_login();
if(isset($_POST['submit']))
{
  $adminid=$_SESSION['odmsaid'];
  $AName=$_POST['username'];
  $fName=$_POST['firstname'];
  $lName=$_POST['lastname'];
  $mobno=$_POST['mobilenumber'];
  $email=$_POST['email'];
  $sql="update tbladmin set UserName=:adminname,FirstName=:firstname,LastName=:lastname,MobileNumber=:mobilenumber,Email=:email where ID=:aid";
  $query = $dbh->prepare($sql);
  $query->bindParam(':adminname',$AName,PDO::PARAM_STR);
  $query->bindParam(':firstname',$fName,PDO::PARAM_STR);
  $query->bindParam(':lastname',$lName,PDO::PARAM_STR);
  $query->bindParam(':email',$email,PDO::PARAM_STR);
  $query->bindParam(':mobilenumber',$mobno,PDO::PARAM_STR);
  $query->bindParam(':aid',$adminid,PDO::PARAM_STR);
  $query->execute();
  echo '<script>alert("Profile has been updated")</script>';
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
            <h1 class="h3 mb-0 text-gray-800">Profile</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Update User Profile</li>
            </ol>
          </div>

          <!-- Row -->
          <div class="row">
            <!-- Datatables -->
            <!-- DataTable with Hover -->
            <div class="col-lg-12">
              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Update User Profile</h6>
                </div>
                <div class="card-body">
                  <form method="post">
                    <?php
                    $adminid=$_SESSION['odmsaid'];
                    $sql="SELECT * from  tbladmin where ID=:aid";
                    $query = $dbh -> prepare($sql);
                    $query->bindParam(':aid',$adminid,PDO::PARAM_STR);
                    $query->execute();
                    $results=$query->fetchAll(PDO::FETCH_OBJ);
                    $cnt=1;
                    if($query->rowCount() > 0)
                    {
                      foreach($results as $row)
                      {  
                        ?>
                        <div class="container rounded bg-white mt-5">
                          <div class="row">
                            <div class="col-md-4 border-right">
                              <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                               <?php 
                               if($row->Photo=="avatar15.jpg"){ ?>
                                <img class="rounded-circle mt-5" src="img/avatar15.jpg"  width="90">
                                <?php 
                              } else { ?>
                                <img class="rounded-circle mt-5"  src="profileimages/<?php  echo $row->Photo;?>" width="90">
                                <?php 
                              } ?><span class="font-weight-bold"><?php  echo $row->FirstName;?> <?php  echo $row->LastName;?></span><span class="text-black-50"><?php  echo $row->Email;?></span><span>+1&nbsp;<?php  echo $row->MobileNumber;?></span>
                              <div class="mt-3">
                                <a href="update_userimage.php?id=<?php echo $adminid;?>">Edit Image</a>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-8">
                            <div class="p-3 py-5">
                              <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="d-flex flex-row align-items-center back"><i class="fa fa-long-arrow-left mr-1 mb-1"></i>
                                </div>
                                <h6 class="text-right">Edit Profile</h6>
                              </div>
                              <div class="row mt-2">
                                <div class="col-md-6"><input type="text" class="form-control" name="firstname" value="<?php  echo $row->FirstName;?>" required='true'></div>
                                <div class="col-md-6"><input type="text" class="form-control" value="<?php  echo $row->LastName;?> " name="lastname" required></div>
                              </div>
                              <div class="row mt-3">
                                <div class="col-md-6"><input type="text" class="form-control" name="email" value="<?php  echo $row->Email;?>" required></div>
                                <div class="col-md-6"><input type="text" class="form-control" value="0<?php  echo $row->MobileNumber;?>" name="mobilenumber" required></div>
                              </div>
                              <div class="row mt-3">
                                <div class="col-md-6">
                                  <label class="form-group">User Name</label>
                                  <input type="text" class="form-control" name="username" value="<?php  echo $row->UserName;?>" required></div>
                                  <div class="col-md-6">
                                    <label class="form-group">Permission</label>
                                    <input type="text" class="form-control"name="adminname" value="<?php  echo $row->AdminName;?>" readonly="true"></div>
                                  </div>
                                  <div class="row mt-3">
                                    <div class="col-md-6">
                                     <label class="form-group">Reg Date</label>
                                     <input type="text" class="form-control"  value="<?php  echo $row->AdminRegdate;?>" readonly="true">
                                   </div>
                                 </div>
                                 <div class="mt-5 text-right"><button class="btn btn-primary profile-button" type="submit" name="submit">Update Profile</button></div>
                               </div>
                             </div>
                           </div>
                         </div>
                         <?php 
                       }
                     } ?>
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