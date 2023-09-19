<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(isset($_POST['log']))
{
  $email=$_POST['email'];
  $password=md5($_POST['password']);
  $sql ="SELECT * FROM tblusers WHERE EmailId=:email and Password=:password";
  $query= $dbh -> prepare($sql);
  $query-> bindParam(':email', $email, PDO::PARAM_STR);
  $query-> bindParam(':password', $password, PDO::PARAM_STR);
  $query-> execute();
  $results=$query->fetchAll(PDO::FETCH_OBJ);
  if($query->rowCount() > 0)
  {
    foreach($results as $result)
    { 
      $_SESSION['login']=$_POST['email'];
      $_SESSION['login2']=$result->FullName;
    }
    echo "<script type='text/javascript'> document.location = 'index.php'; </script>";
  } else{

    echo "<script>alert('Invalid Details');</script>";

  }
}

?>

<div class="modal fade" id="myModal4" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content modal-info">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>						
			</div>
			<div class="modal-body modal-spa">
				<div class="login-grids">
					<div class="login">
						<div class="login-right">
							<form method="post">
								<h3>Signin with your account </h3>
								<input type="text" name="email" id="email" placeholder="Enter your Email"  required="">	
								<input type="password" name="password" id="password" placeholder="Password" value="" required="">	
								<h4><a href="forgot_password.php">Forgot password</a></h4>
								<div class="modal-footer text-right">
									<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
									<button type="submit" name="log"  class="btn btn-primary">Login</button>
								</div>
							</form>
						</div>
						<div class="clearfix"></div>								
					</div>
				</div>
			</div>
		</div>
	</div>
</div>