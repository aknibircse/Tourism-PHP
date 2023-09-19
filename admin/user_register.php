<?php
include('includes/checklogin.php');
check_login();
if(isset($_GET['delid']))
{
  $rid=intval($_GET['delid']);
  $sql="update tbladmin set Status='0' where ID='$rid'";
  $query=$dbh->prepare($sql);
  $query->bindParam(':rid',$rid,PDO::PARAM_STR);
  $query->execute();
  if ($query->execute()){
    echo "<script>alert('User blocked');</script>"; 
    echo "<script>window.location.href = 'user_register.php'</script>";
  }else{
    echo '<script>alert("update failed! try again later")</script>';
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
  <title>Admin - User Register</title>
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="css/ruang-admin.min.css" rel="stylesheet">
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
            <h1 class="h3 mb-0 text-gray-800">Users</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">User Register</li>
            </ol>
          </div>

          <div class="row">
            <div class="col-lg-12 mb-4">
              <!-- Simple Tables -->
              <div class="card">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">User Register</h6>
                  <div class="card-tools" style="float: right;">
                    <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#delete" ></i> Blocked users
                    </button>
                    <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#registeruser" ><i class="fas fa-plus" ></i> Register User
                    </button>
                  </div>  
                </div>
                <div class="modal fade" id="registeruser">
                  <div class="modal-dialog ">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h4 class="modal-title">Register user</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <!-- <p>One fine body&hellip;</p> -->
                        <?php @include("newuser_form.php");?>
                      </div>
                    </div>
                    <!-- /.modal-content -->
                  </div>
                  <!-- /.modal-dialog -->
                </div>
                <!-- /.modal -->
                <div class="modal fade" id="delete">
                  <div class="modal-dialog modal-xl ">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h4 class="modal-title">Deleted user</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <!-- <p>One fine body&hellip;</p> -->
                        <?php @include("deleted_users.php");?>
                      </div>
                    </div>
                    <!-- /.modal-content -->
                  </div>
                  <!-- /.modal-dialog -->
                </div>
                <!-- /.modal -->
                <!--  start  modal -->
                <div id="editData" class="modal fade">
                  <div class="modal-dialog ">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title">Edit user info</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body" id="info_update">
                        <?php @include("update_user.php");?>
                      </div>
                      <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                  </div>
                  <!-- /.modal -->
                </div>
                <!--   end modal -->
                <div class="table-responsive">
                  <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                    <thead>
                      <tr>
                        <th class="text-center">No.</th>
                        <th class="">Name</th>
                        <th class="text-center">Mobile number</th>
                        <th class="">Email</th>
                        <th class=" text-center">Date registered</th>
                        <th class="text-center" style="width: 15%;">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $sql="SELECT * from tbladmin where Status='1'  ";
                      $query = $dbh -> prepare($sql);
                      $query->execute();
                      $results=$query->fetchAll(PDO::FETCH_OBJ);
                      $cnt=1;
                      if($query->rowCount() > 0)
                      {
                        foreach($results as $row)
                        {    
                          ?>
                          <tr>
                            <td class="text-center"><?php echo htmlentities($cnt);?></td>
                            <td><?php  echo htmlentities($row->FirstName);?>&nbsp;<?php  echo htmlentities($row->LastName);?></td>
                            <td class="text-center">0<?php  echo htmlentities($row->MobileNumber);?></td>
                            <td><?php  echo htmlentities($row->Email);?></td>
                            <td class="text-center">
                              <span ><?php  echo htmlentities(date("d-m-Y", strtotime($row->AdminRegdate)));?></span>
                            </td>
                            <td class=" text-center">
                              <a href="#"  class=" edit_data  btn btn-sm btn-primary" id="<?php echo  ($row->ID); ?>" title="click for edit" >Edit</a>
                              <a href="user_register.php?delid=<?php echo ($row->ID);?>" onclick="return confirm('Do you really want to Delete ?');" title="Delete this User" class="btn btn-sm btn-danger">Block</a> </td>
                            </tr>
                            <?php $cnt=$cnt+1;
                          }
                        } ?>
                      </tbody>
                    </table>
                  </div>
                  <div class="card-footer"></div>
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
  <script type="text/javascript">
    $(document).ready(function(){
      $(document).on('click','.edit_data',function()
      {
        var edit_id=$(this).attr('id');
        $.ajax(
        {
          url:"update_user.php",
          type:"post",
          data:{edit_id:edit_id},

          success:function(data)
          {
            $("#info_update").html(data);
            $("#editData").modal('show');
          }

        });
      });
    });
  </script>

</body>

</html>