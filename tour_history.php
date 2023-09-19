<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['login'])==0)
{ 
  header('location:index.php');
}
else{
  if(isset($_REQUEST['bkid']))
  {
    $bid=intval($_GET['bkid']);
    $email=$_SESSION['login'];
    $sql ="SELECT FromDate FROM tblbooking WHERE UserEmail=:email and BookingId=:bid";
    $query= $dbh -> prepare($sql);
    $query-> bindParam(':email', $email, PDO::PARAM_STR);
    $query-> bindParam(':bid', $bid, PDO::PARAM_STR);
    $query-> execute();
    $results = $query -> fetchAll(PDO::FETCH_OBJ);
    if($query->rowCount() > 0)
    {
      foreach($results as $result)
      {
        $fdate=$result->FromDate;

        // $a=explode("/",$fdate);
        // $val=array_reverse($a);
        // $mydate =implode("/",$val);
        $cdate=date('Y/m/d');
        $date1=date_create("$cdate");
        $date2=date_create("$fdate");
        $diff=date_diff($date1,$date2);
        echo $df=$diff->format("%a");
        if($df>1)
        {
          $status=2;
          $cancelby='u';
          $sql = "UPDATE tblbooking SET status=:status,CancelledBy=:cancelby WHERE UserEmail=:email and BookingId=:bid";
          $query = $dbh->prepare($sql);
          $query -> bindParam(':status',$status, PDO::PARAM_STR);
          $query -> bindParam(':cancelby',$cancelby , PDO::PARAM_STR);
          $query-> bindParam(':email',$email, PDO::PARAM_STR);
          $query-> bindParam(':bid',$bid, PDO::PARAM_STR);
          $query -> execute();
          $msg="Booking Cancelled successfully";
        }
        else
        {
          $error="You can't cancel booking before 24 hours";
          //echo "<script>alert('You can't cancel booking before 24 hours');</script>";
        }
      }
    }
  }

  ?>
  <!doctype html>
  <html lang="en-gb" class="no-js">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <title>My Travel - my memories</title>
    <meta name="description" content="Traveller">
    <meta name="author" content="WebThemez">

    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <!-- <link href="assets/css/bootstrap.css" rel='stylesheet' type='text/css' /> -->
    <link rel="stylesheet" type="text/css" href="css/isotope.css" media="screen" />
    <link rel="stylesheet" href="js/fancybox/jquery.fancybox.css" type="text/css" media="screen" />
    <link rel="stylesheet" type="text/css" href="css/da-slider.css" />
    <!-- Owl Carousel Assets -->
    <link href="js/owl-carousel/owl.carousel.css" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css" />
    <!-- Font Awesome -->
    <!--animate-->
    <link href="assets/css/animate.css" rel="stylesheet" type="text/css" media="all">
    <link href="font/css/font-awesome.min.css" rel="stylesheet">
    
    <style>
      .errorWrap {
        padding: 10px;
        margin: 0 0 20px 0;
        background: #fff;
        border-left: 4px solid #dd3d36;
        -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
        box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
      }
      .succWrap{
        padding: 10px;
        margin: 0 0 20px 0;
        background: #fff;
        border-left: 4px solid #5cb85c;
        -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
        box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
      }
    </style>
  </head>

  <body>
    <header class="header">
    <?php if($_SESSION['login'])
    {?>
      <div class="top-header">
        <div class="container">
          <ul class="tp-hd-lft wow fadeInLeft animated" data-wow-delay=".5s">
            <li class="hm"><a href="index.php"><i class="fa fa-home"></i></a></li>
            <li class="prnt"><a href="profile.php">My Profile</a></li>
            <li class="prnt"><a href="change_password.php">Change Password</a></li>
            <li class="prnt"><a href="tour_history.php">My Tour History</a></li>
          </ul>
          <ul class="tp-hd-rgt wow fadeInRight animated" data-wow-delay=".5s"> 
            <li class="tol">Welcome :</li>        
            <li class="sig"><?php echo htmlentities($_SESSION['login']);?></li> 
            <li class="sigi"><a href="logout.php" >/ Logout</a></li>
          </ul>
          <div class="clearfix"></div>
        </div>
      </div>
      <?php 
    } else 
    {
      ?>
      <div class="top-header">
        <div class="container">
          <ul class="tp-hd-lft wow fadeInLeft animated" data-wow-delay=".5s">
            <li class="hm"><a href="admin/index.php">Admin Login</a></li>
          </ul>
          <ul class="tp-hd-rgt wow fadeInRight animated" data-wow-delay=".5s"> 
            <li class="tol">Toll Number : 123-4568790</li>        
            <li class="sig"><a href="#" data-toggle="modal" data-target="#myModal" >Sign Up</a></li> 
            <li class="sigi"><a href="#" data-toggle="modal" data-target="#myModal4" >&nbsp; Sign In</a></li>
          </ul>
          <div class="clearfix"></div>
        </div>
      </div>
      <?php 
    }?>
    <div class="container">
      <nav class="navbar navbar-inverse" role="navigation">
        <div class="navbar-header adeInDown animated animated" data-wow-delay=".5s" style="visibility: visible; animation-delay: 0.5s; animation-name: fadeInDown;">
          <a href="#" class="navbar-brand scroll-top logo"><b>Traveller</b></a>
          <button type="button" id="nav-toggle" class="navbar-toggle" data-toggle="collapse" data-target="#main-nav">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
        </div>
        <!--/.navbar-header-->
        <div id="main-nav" class="collapse navbar-collapse adeInDown animated animated" data-wow-delay=".5s" style="visibility: visible; animation-delay: 0.5s; animation-name: fadeInDown;">
          <ul class="nav navbar-nav" id="mainNav">
            <li ><a href="index.php" class="scroll-link">Home</a></li>
            <li><a href="index.php" class="scroll-link">About Us</a></li>
            <li><a href="index.php" class="scroll-link">Packages</a></li>
            <li><a href="index.php" class="scroll-link">Gallery</a></li>
            <li><a href="index.php" class="scroll-link">Contact Us</a></li>
          </ul>
        </div>
        <!--/.navbar-collapse-->
      </nav>
      <!--/.navbar-->
    </div>
    <!--/.container-->
  </header>
    <!--/.header-->
    <div id="#top"></div>
    <section id="home">
      <div class="banner-container" style="height: 300px;">
       <!-- <img src="images/banner-bg.jpg" alt="banner" /> -->
       <div class="container banner-content">
        <div id="da-slider" class="da-slider">
         <div>&nbsp;</div>
         <div class="">
          <h2>My Travel</h2>
          <p>Get your plans right away.. enjoy!!!</p>
          <div class="da-img"></div>
        </div>
      </div>
    </div>
  </div>
</section>

<!--Package-->
<section id="packages" class="secPad">
  <div class="container">
    <div class="heading text-center">
      <!-- Heading -->
      <h2>Tour History</h2>
      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit</p>
    </div>
    <div class="privacy">
      <div class="container">
        <h3 class="wow fadeInDown animated animated" data-wow-delay=".5s" style="visibility: visible; animation-delay: 0.5s; animation-name: fadeInDown;">My Tour History</h3>
        <form name="chngpwd" method="post" onSubmit="return valid();">
          <?php if($error){?><div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div><?php } 
          else if($msg){?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php }?>
          <p>
            <table class="table align-items-center table-flush table-hover table-bordered" width="100%">
              <tr align="center">
                <th>#</th>
                <th>Booking Id</th>
                <th>Package Name</th> 
                <th>From</th>
                <th>To</th>
                <th>Comment</th>
                <th>Status</th>
                <th>Booking Date</th>
                <th>Action</th>
              </tr>
              <?php 

              $uemail=$_SESSION['login'];;
              $sql = "SELECT tblbooking.BookingId as bookid,tblbooking.PackageId as pkgid,tbltourpackages.PackageName as packagename,tblbooking.FromDate as fromdate,tblbooking.ToDate as todate,tblbooking.Comment as comment,tblbooking.status as status,tblbooking.RegDate as regdate,tblbooking.CancelledBy as cancelby,tblbooking.UpdationDate as upddate from tblbooking join tbltourpackages on tbltourpackages.PackageId=tblbooking.PackageId where UserEmail=:uemail";
              $query = $dbh->prepare($sql);
              $query -> bindParam(':uemail', $uemail, PDO::PARAM_STR);
              $query->execute();
              $results=$query->fetchAll(PDO::FETCH_OBJ);
              $cnt=1;
              if($query->rowCount() > 0)
              {
                foreach($results as $result)
                { 
                  ?>
                  <tr align="center">
                    <td><?php echo htmlentities($cnt);?></td>
                    <td>#BK<?php echo htmlentities($result->bookid);?></td>
                    <td><a href="package-details.php?pkgid=<?php echo htmlentities($result->pkgid);?>"><?php echo htmlentities($result->packagename);?></a></td>
                    <td><?php echo htmlentities($result->fromdate);?></td>
                    <td><?php echo htmlentities($result->todate);?></td>
                    <td><?php echo htmlentities($result->comment);?></td>
                    <td><?php if($result->status==0)
                    {
                      echo "Pending";
                    }
                    if($result->status==1)
                    {
                      echo "Confirmed";
                    }
                    if($result->status==2 and  $result->cancelby=='u')
                    {
                      echo "Canceled by you at " .$result->upddate;
                    } 
                    if($result->status==2 and $result->cancelby=='a')
                    {
                      echo "Canceled by admin at " .$result->upddate;

                    }
                    ?></td>
                    <td><?php echo htmlentities($result->regdate);?></td>
                    <?php if($result->status==2)
                    {
                      ?><td>Cancelled</td>
                    <?php } else {?>
                      <td><a href="tour-history.php?bkid=<?php echo htmlentities($result->bookid);?>" onclick="return confirm('Do you really want to cancel booking')" >Cancel</a></td>
                    <?php }?>
                  </tr>
                  <?php $cnt=$cnt+1; 
                }
              } ?>
            </table>
          </p>
        </form>
      </div>
    </div>
  </div> 
</div>
</section>
<?php include('includes/footer.php'); ?>
<!-- signup -->
<?php include('includes/signup.php');?>     
<!-- //signu -->
<!-- signin -->
<?php include('includes/signin.php');?>     
<!-- //signin -->
<a href="#top" class="topHome"><i class="fa fa-chevron-up fa-2x"></i></a>
<script src="js/modernizr-latest.js"></script>
<script src="js/jquery-1.8.2.min.js" type="text/javascript"></script>
<script src="js/bootstrap.min.js" type="text/javascript"></script>
<script src="js/jquery.isotope.min.js" type="text/javascript"></script>
<script src="js/fancybox/jquery.fancybox.pack.js" type="text/javascript"></script>
<script src="js/jquery.nav.js" type="text/javascript"></script>
<script src="js/jquery.cslider.js" type="text/javascript"></script>
<script src="contact/contact_me.js"></script>
<script src="js/custom.js" type="text/javascript"></script>
<script src="js/owl-carousel/owl.carousel.js"></script>
</body>
</html>
<?php 
} ?>
