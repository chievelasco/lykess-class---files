<?php
session_start();
include "connect2.php";

$id= $_GET['id'];
$query = "SELECT * FROM files WHERE id='$id' ";


$results = mysqli_query($conn, $query);

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Responsive Sidebar</title>

  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Link Styles -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="please.css">
</head>

<body>
  <div class="sidebar">
    <div class="logo_details">
      <i class="fa fa-navicon" id="btn"></i>
    </div>
    <ul class="nav-list">

      <li>
        <a href="admin_home.php" class="active">
          <i class="fa fa-home"></i>
          <span class="link_name">Home</span>
        </a>
        <span class="tooltip">Home</span>
      </li>
      <li>
        <a href="class_list.php">
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
        <a href="index.html">
          <i class="fa fa-calendar"></i>
          <span class="link_name">Events Calendar</span>
        </a>
        <span class="tooltip">Events Calendar</span>
      </li>
      <li>
        <a href="index.html">
          <i class="fa fa-gear"></i>
          <span class="link_name">Settings</span>
        </a>
        <span class="tooltip">Settings</span>
      </li>
      <li class="profile">
        <div class="profile_details">
          <img src="profile.jpeg" alt="profile image">
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
    <div class="text">Edit Week Files</div>
      <?php
      if ($results) {
        $row = mysqli_fetch_assoc($results);
        $weekNum = $row["weekNum"];
        $id = $row["id"];
        $topics_files = $row["file_t"];
        $worksheets_files = $row["file_w"];
        $eactivities_files = $row["file_a"];

        if (isset($_POST["btn_save"])) {
          $weekNum = isset($_POST["weekNum"]) ? $_POST["weekNum"] : '';
          $id = isset($_POST["id"]) ? $_POST["id"] : '';

          
          $topics_tmp = $_FILES["choosefile_topics"]["tmp_name"];
          $wsheets_tmp = $_FILES["choosefile_worksheets"]["tmp_name"];
          $eact_tmp = $_FILES["choosefile_eactivities"]["tmp_name"];

        
          $uploadDir = "uploads/";

          $topics = $uploadDir . basename($_FILES["choosefile_topics"]["name"]);
          $wsheets = $uploadDir . basename($_FILES["choosefile_worksheets"]["name"]);
          $eact = $uploadDir . basename($_FILES["choosefile_eactivities"]["name"]);

          move_uploaded_file($topics_tmp, $topics);
          move_uploaded_file($wsheets_tmp, $wsheets);
          move_uploaded_file($eact_tmp, $eact);


          $query = "UPDATE files 
                    SET file_t='$topics', file_w='$wsheets', file_a='$eact', weekNum='$weekNum'
                    WHERE id='$id'";

          if (mysqli_query($conn, $query)) {
            echo '<script type="text/javascript">alert("Edited Successfully!");</script>';
            header ("Location: admin_academicResources.php");
          } else {
              echo "Error updating record: " . mysqli_error($conn);
          }
        }
      }
      ?>
      <form action="" method="post" class="addweek_modal_content" enctype="multipart/form-data">
        <input type="text" name="id" value="<?php echo $id; ?>">
        <h3>Week Number</h3><input type="text" class="form_control" name="weekNum" value="<?php echo $weekNum; ?>" id="">
        <h4>Topic</h4>
        <input class="form-control" type="file" name="choosefile_topics" id="">
        <h4>Worksheet</h4>
        <input class="form-control" type="file" name="choosefile_worksheets" id="">
        <h4>Activities</h4>
        <input class="form-control" type="file" name="choosefile_eactivities" id="">
        <div class="col-6 m-auto ">
          <button type="submit" name="btn_save" class="btn_save">
            Save
          </button>
        </div>
      </form>


      <?php
          
          ?>

    </div>
  </section>
  <!-- Scripts -->
  <script src="script.js"></script>
</body>

</html>