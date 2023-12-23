<?php
session_start();
include "connect2.php";

      // Redirect to index.php if $_GET['id'] is not present in the URL
      // if(!isset($_GET['id'])){
      //   header("Location: index.php");
      // }

      $schedId = $_GET['id'];
      $query = "SELECT * FROM class_schedule WHERE id='$schedId'";
      $result1 =  mysqli_query($conn, $query);

      ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Responsive Sidebar</title>
  <!-- Link Styles -->
  <link rel="stylesheet" href="style2.css">
  <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <style>
    .website-logo{
      width: 50px;
      display: flex;
      align-items: center;
      position: relative;
      transition: all .5s ease;
    }
    .sidebar.open .website-logo{
      width: 200px;
      display: flex;
      align-items: center;
      position: relative;
      margin-top: -95px;
      transition: all .5s ease;
    }
  </style>
</head>
<body>
  <div class="sidebar">
    <div class="logo_details">
      <i class="fa fa-navicon" id="btn">
      </i>
    </div>
    <img src="https://i.ibb.co/9gPHTr8/kinder-class-logo-1.png" class="website-logo"> 
    <ul class="nav-list">
      <li>
        <a href="index.php" class="active">
          <i class="fa fa-home"></i>
          <span class="link_name">Home</span>
        </a>
        <span class="tooltip">Home</span>
      </li>
      <li>
        <a href="class_list.html">
          <i class="fa fa-address-book"></i>
          <span class="link_name">Class List</span>
        </a>
        <span class="tooltip">Class List</span>
      </li>
      <li>
        <a href="uploadFile.php">
          <i class="fa fa-book"></i>
          <span class="link_name">Performance Tracker</span>
        </a>
        <span class="tooltip">Performance Tracker</span>
      </li> 
      <li>
        <a href="calendar_admin.php">
          <i class="fa fa-calendar"></i>
          <span class="link_name">Events Calendar</span>
        </a>
        <span class="tooltip">Events Calendar</span>
      </li>
      <li>
        <a href="#">
          <i class="fa fa-gear"></i>
          <span class="link_name">Settings</span>
        </a>
        <span class="tooltip">Settings</span>
      </li>
      <li class="profile">
        <div class="profile_details">
          <div class="profile_content">
            <div class="name">Anna Jhon</div>
            <div class="designation">Admin</div>
          </div>
        </div>
        <i class="fa fa-sign-out" id="log_out"></i>
      </li>
    </ul>
  </div>

  <section class="home-section">
      <div class="text">Home</div>
        <div class="grid auto-fit">

          <!-- MODAL FOR EDIT -->
          <?php
          // <!-- EDIT QUERY FOR RULES -->
              if ($result1) {
                $row = mysqli_fetch_assoc($result1);
                $schedId = $row["id"];
                $startTime = $row["startTime"];
                $endTime = $row["endTime"];
                $newSched = $row["newSched"];


                if (isset($_POST["insertEditSched"])) {
                  $startTime = $_POST["startTime"] ;
                  $endTime = $_POST["endTime"] ;
                  $newSched = $_POST["newSched"];

                  $updatequery = "UPDATE class_schedule 
                                  SET startTime='$startTime', endTime='$endTime', newSched='$newSched'
                                  WHERE id='$schedId'";
                    if (mysqli_query($conn, $updatequery)) {
                      echo '<script type="text/javascript">alert("Update Successfully!");</script>';
                      
                  } else {
                      echo "Error updating record: " . mysqli_error($conn);
                  }
                }
              }

          ?>
            <form action=" " method="post" class="editSchedContainer">
                <h2>Edit Schedule</h2>
                <label for="newActivity">Start:</label>
                <input type="time" id="startTime" name="startTime" value="<?php echo $startTime?>">
                <label for="newActivity">End:</label>
                <input type="time" id="endTime" name="endTime" value="<?php echo $endTime?>">
                <br>
                <label for="duration">Schedule:</label>
                <input type="text" id="newSched" name="newSched" value="<?php echo $newSched?>">
                <br>
                  <div class="col-6 m-auto ">
                    <button name="insertEditSched" class="insertEditSched" id="insertEditSched">Save</button>
                    <button name="insertEditSched" class="insertEditSched"><a href="admin_home.php">Cancel</a></button>
                  </div>
            </form>

          <?php
    
    ?>
          <!-- END OF RULES CONTAINER -->
        </div>
  </section>
  <!-- Scripts -->
  <script src="script.js"></script>

</body>
</html>