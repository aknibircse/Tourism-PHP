 <nav class="navbar navbar-expand navbar-light bg-navbar topbar mb-4 static-top">
  <button id="sidebarToggleTop" class="btn btn-link rounded-circle mr-3">
    <i class="fa fa-bars"></i>
  </button>
  <ul class="navbar-nav ml-auto">
    <li class="nav-item dropdown no-arrow">
      <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-search fa-fw"></i>
      </a>
      <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"aria-labelledby="searchDropdown">
        <form class="navbar-search">
          <div class="input-group">
            <input type="text" class="form-control bg-light border-1 small" placeholder="What do you want to look for?"
            aria-label="Search" aria-describedby="basic-addon2" style="border-color: #3f51b5;">
            <div class="input-group-append">
              <button class="btn btn-primary" type="button">
                <i class="fas fa-search fa-sm"></i>
              </button>
            </div>
          </div>
        </form>
      </div>
    </li>
    <div class="topbar-divider d-none d-sm-block"></div>
    <li class="nav-item dropdown no-arrow">
      <?php
      $aid=$_SESSION['odmsaid'];
      $sql="SELECT * from  tbladmin where ID=:aid";
      $query = $dbh -> prepare($sql);
      $query->bindParam(':aid',$aid,PDO::PARAM_STR);
      $query->execute();
      $results=$query->fetchAll(PDO::FETCH_OBJ);
      $cnt=1;
      if($query->rowCount() > 0)
      {
        foreach($results as $row)
        { 
          ?>
          <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
           <?php 
           if($row->Photo=="avatar15.jpg")
           { 
            ?>
            <img class="img-profile rounded-circle"src="img/avatar15.jpg" style="max-width: 60px">
            <?php 
          } else { 
            ?>
            <img class="img-profile rounded-circle" src="profileimages/<?php  echo $row->Photo;?>" style="max-width: 60px"> 
            <?php 
          } ?>

          <span class="ml-2 d-none d-lg-inline text-white small"><?php  echo $row->FirstName;?> <?php  echo $row->LastName;?></span>
        </a>
        <?php
      }
    } ?>
    <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
      <a class="dropdown-item" href="profile.php">
        <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
        Profile
      </a>
      <a class="dropdown-item" href="change_password.php">
        <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
        Settings
      </a>
      <div class="dropdown-divider"></div>
      <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" data-target="#logoutModal">
        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
        Logout
      </a>
    </div>
  </li>
</ul>
</nav>