<?php
include('includes/checklogin.php');
check_login();

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
  <title>Admin - Permissions</title>
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
            <h1 class="h3 mb-0 text-gray-800">Permissions</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">User Permissions</li>
            </ol>
          </div>

          <div class="row">
            <div class="col-lg-12 mb-4">
              <!-- Simple Tables -->
              <div class="card">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">User Permissions</h6>
                </div>
                <!--  start  modal -->
                <div id="editData" class="modal fade">
                  <div class="modal-dialog ">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title">Change permissions</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body" id="info_update">
                        <?php @include("change_permissions.php");?>
                      </div>
                      <div class="modal-footer ">
                      </div>
                      <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                  </div>
                  <!-- /.modal -->
                </div>
                <!--   end modal -->
                <div class="table-responsive">
                  <table class="table align-items-center table-flush " >
                    <thead>
                      <tr>
                        <th class="text-center">No.</th>
                        <th class="d-none d-sm-table-cell" style="width: 20%">Permission Name</th>
                        <th class="d-none d-sm-table-cell text-center" >Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $companyname=$_SESSION['companyname'];
                      $sql="SELECT * from permissions  ";
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

                            <td><?php  echo htmlentities($row->permission);?></td>
                            <td class="d-none d-sm-table-cell text-center">
                             <button class="btn btn-primary btn-sm edit_data" id="<?php echo  ($row->id); ?>" title="click for edit">Change Permission</button>
                           </td>
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
        url:"change_permissions.php",
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