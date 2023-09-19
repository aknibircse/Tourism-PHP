<?php
include('includes/checklogin.php');
check_login();
// code for cancel
if(isset($_REQUEST['bkid']))
{
  $bid=intval($_GET['bkid']);
  $status=2;
  $cancelby='a';
  $sql = "UPDATE tblbooking SET status=:status,CancelledBy=:cancelby WHERE  BookingId=:bid";
  $query = $dbh->prepare($sql);
  $query -> bindParam(':status',$status, PDO::PARAM_STR);
  $query -> bindParam(':cancelby',$cancelby , PDO::PARAM_STR);
  $query-> bindParam(':bid',$bid, PDO::PARAM_STR);
  $query -> execute();
  if ( $query -> execute()) {
   echo '<script>alert("Booking Cancelled successfully")</script>';
 }else{
  echo '<script>alert("Something Went Wrong. Please try again")</script>';
}
}
if(isset($_REQUEST['bckid']))
{
  $bcid=intval($_GET['bckid']);
  $status=1;
  $cancelby='a';
  $sql = "UPDATE tblbooking SET status=:status WHERE BookingId=:bcid";
  $query = $dbh->prepare($sql);
  $query -> bindParam(':status',$status, PDO::PARAM_STR);
  $query-> bindParam(':bcid',$bcid, PDO::PARAM_STR);
  $query -> execute();
  if ( $query -> execute()) {
    echo '<script>alert("Booking Confirmed successfully")</script>';
  }else{
    echo '<script>alert("Something Went Wrong. Please try again")</script>';
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
  <title>Admin - manage Bookings</title>
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
            <h1 class="h3 mb-0 text-gray-800">Bookings</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Manage Bookings</li>
            </ol>
          </div>

          <!-- Row -->
          <div class="row">
            <!-- Datatables -->
            <!-- DataTable with Hover -->
            <div class="col-lg-12">
              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Manage Bookings</h6>
                  <?php if($error){?>
                    <div class="errorWrap">
                      <strong>ERROR</strong>:<?php echo htmlentities($error); ?> 
                    </div>
                    <?php
                  } 
                  else if($msg){?>
                    <div class="succWrap">
                      <strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?>
                    </div>
                    <?php 
                  }?>
                </div>
                <div class="table-responsive p-3">
                  <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                    <thead class="thead-light">
                      <tr>
                        <th>Booikn id</th>
                        <th>Name</th>
                        <th>Mobile No.</th>
                        <th>Email Id</th>
                        <th>RegDate </th>
                        <th>From /To </th>
                        <th>Comment </th>
                        <th>Status </th>
                        <th>Action </th>
                      </tr>
                    </thead>
                    <tbody>
                     <?php $sql = "SELECT tblbooking.BookingId as bookid,tblusers.FullName as fname,tblusers.MobileNumber as mnumber,tblusers.EmailId as email,tbltourpackages.PackageName as pckname,tblbooking.PackageId as pid,tblbooking.FromDate as fdate,tblbooking.ToDate as tdate,tblbooking.Comment as comment,tblbooking.status as status,tblbooking.CancelledBy as cancelby,tblbooking.UpdationDate as upddate from tblusers join  tblbooking on  tblbooking.UserEmail=tblusers.EmailId join tbltourpackages on tbltourpackages.PackageId=tblbooking.PackageId";
                     $query = $dbh -> prepare($sql);
                     $query->execute();
                     $results=$query->fetchAll(PDO::FETCH_OBJ);
                     $cnt=1;
                     if($query->rowCount() > 0)
                     {
                      foreach($results as $result)
                        {       ?>    
                          <tr>
                            <td>#BK-<?php echo htmlentities($result->bookid);?></td>
                            <td><?php echo htmlentities($result->fname);?></td>
                            <td><?php echo htmlentities($result->mnumber);?></td>
                            <td><?php echo htmlentities($result->email);?></td>
                            <td><a href="update_packages.php?pid=<?php echo htmlentities($result->pid);?>"><?php echo htmlentities($result->pckname);?></a></td>
                            <td><?php echo htmlentities($result->fdate);?> To <?php echo htmlentities($result->tdate);?></td>
                            <td><?php echo htmlentities($result->comment);?></td>
                            <td><?php if($result->status==0)
                            {
                              echo "Pending";
                            }
                            if($result->status==1)
                            {
                              echo "Confirmed";
                            }
                            if($result->status==2 and  $result->cancelby=='a')
                            {
                              echo "Canceled by you at " .$result->upddate;
                            } 
                            if($result->status==2 and $result->cancelby=='u')
                            {
                              echo "Canceled by User at " .$result->upddate;

                            }
                            ?></td>

                            <?php if($result->status==2)
                            {
                              ?><td>Cancelled</td>
                              <?php 
                            }elseif($result->status==1)
                            {?>
                              <td>Confirmed</td>
                              <?php
                            } else {?>
                              <td>
                                <a href="manage_bookings.php?bkid=<?php echo htmlentities($result->bookid);?>" onclick="return confirm('Do you really want to cancel booking')" >Cancel</a>&nbsp;<a href="manage_bookings.php?bckid=<?php echo htmlentities($result->bookid);?>" onclick="return confirm('Do you really want to confirm booking')" >Confirm</a>
                              </td>
                              <?php 
                            }?>

                          </tr>
                          <?php $cnt=$cnt+1;
                        } 
                      }?>
                    </tbody>
                  </table>
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