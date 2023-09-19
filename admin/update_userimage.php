<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
include('includes/checklogin.php');
check_login();
if (strlen($_SESSION['odmsaid']==0)) 
{
  header('location:logout.php');
}else{
  $pid=intval($_GET['id']);// product id
  if(isset($_POST['submit']))
  {
    $adminid=$_SESSION['odmsaid'];
    $productname=$_POST['productName'];
    $productimage1=$_FILES["productimage1"]["name"];
    move_uploaded_file($_FILES["productimage1"]["tmp_name"],"profileimages/".$_FILES["productimage1"]["name"]);
    $sql="update  tbladmin set Photo=:productimage1 where ID=:aid";
    $query = $dbh->prepare($sql);
    $query->bindParam(':productimage1',$productimage1,PDO::PARAM_STR);
    $query->bindParam(':aid',$pid,PDO::PARAM_STR);
    $query->execute();
    $_SESSION['msg']="profile Image Updated Successfully !!";
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
              <h1 class="h3 mb-0 text-gray-800">User Image</h1>
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Update User Image</li>
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
                   <?php if(isset($_POST['submit']))
                   {?>
                    <div class="alert alert-success">
                      <button type="button" class="close" data-dismiss="alert">×</button>
                      <strong>Well done!</strong> <?php echo htmlentities($_SESSION['msg']);?><?php echo htmlentities($_SESSION['msg']="");?>
                    </div>
                  <?php } ?>
                  <br/>
                  <form class="form-horizontal row-fluid" name="insertproduct" method="post" enctype="multipart/form-data">
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
                        <div class="control-group">
                          <label class="control-label" for="basicinput">Names</label>
                          <div  class="col-6">
                            <input type="text"   class="form-control" name="productName"  readonly value="<?php  echo $row->FirstName;?>&nbsp;<?php  echo $row->LastName;?>" class="span6 tip" required>
                          </div>
                        </div>
                        <br>
                        <div class="control-group"> 
                          <label class="control-label" for="basicinput">Current Image</label>
                          <div class="controls">
                            <?php 
                            if($row->Photo=="avatar15.jpg")
                            { 
                              ?>
                              <img class="" src="assets/img/avatars/avatar15.jpg" alt="" width="100" height="100">
                              <?php 
                            } else
                            { 
                              ?>
                              <img src="profileimages/<?php  echo $row->Photo;?>" width="170" height="150"> 
                              <?php
                            } ?> 
                          </div>
                        </div>
                        <br>
                        <div class="form-group col-md-6">
                          <label>New Image</label>
                          <input type="file" name="productimage1" id="productimage1" class="file-upload-default">
                        </div>
                        <?php 
                      }
                    } ?>
                    <br>
                    <div class="form-group row">
                      <div class="col-12">
                        <button type="submit" class="btn btn-primary " name="submit">
                          <i class="fa fa-plus "></i> Update
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