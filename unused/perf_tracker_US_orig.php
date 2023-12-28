<?php
session_start();


include "connect1.php";


$userId = isset($_SESSION["username"]) ? $_SESSION["username"] : null;

$progressQuery = "SELECT week, percent, remark FROM progress WHERE studID_number = ?";
$progressStmt = mysqli_prepare($conn, $progressQuery);
mysqli_stmt_bind_param($progressStmt, "s", $userId);
mysqli_stmt_execute($progressStmt);
$progressResult = mysqli_stmt_get_result($progressStmt);


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Responsive Sidebar</title>
  <!-- Link Styles -->
  <link rel="stylesheet" href="style1.css">
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
    .remarks_container {
      width: auto;
      height: 100px;
      text-align: left;
      margin-left: 15px;
      margin-top: 15px;
      box-sizing: border-box;
      background: #fff;
      border-style: solid;
      border-color: #297582;
      margin-right: 15px;
    }
    .remarks_container h5 {
      font-size: 15px;
      color: #000;
      margin-left: 5px;
      font-weight: normal;
    }
    .remarks_container h5 span {
      font-size: 15px;
      color: #000;
      margin-left: 5px;
      font-weight: bold;
    }
    .weekly_pt {
      margin-top: 20px;
    }
  </style>
</head>

<body>
  <div class="sidebar">
    <div class="logo_details">
      <i class="fa fa-navicon" id="btn"></i>
    </div>
    <img src="https://i.ibb.co/9gPHTr8/kinder-class-logo-1.png" class="website-logo">

    <ul class="nav-list">

      <li>
        <a href="home.php" class="active">
          <i class="fa fa-home"></i>
          <span class="link_name">Home</span>
        </a>
        <span class="tooltip">Home</span>
      </li>
      <li>
        <a href="perf_tracker_US.php">
          <i class="fa fa-book"></i>
          <span class="link_name">Performance Tracker</span>
        </a>
        <span class="tooltip">Performance Tracker</span>
      </li>
      <li>
        <a href="calendar.php">
          <i class="fa fa-calendar"></i>
          <span class="link_name">Events Calendar</span>
        </a>
        <span class="tooltip">Events Calendar</span>
      </li>
      <li>
        <a href="profile-real3.php">
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
    <div class="text">Performance Tracker</div>

    <div class="weekly_container">
      <?php
      if (mysqli_num_rows($progressResult) > 0) {
        while ($progressRow = mysqli_fetch_assoc($progressResult)) {
          $week = $progressRow['week'];
          $progressPercent = $progressRow['percent'];
          $remarks = $progressRow['remark'];

          ?>
          <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">

            <h2>  <?php echo "WEEK" . $week ?> </h2>
            <div class="progressRate" style="width: <?php echo $progressPercent; ?>%;">
              <?php echo $progressPercent; ?>%
            </div>

            <div class="weekly_pt">
              <div class="exercises_pt">
                <div class="exercises_container">
                  <a>
                    <h3>Topic</h3>
                  </a>
                </div>
              </div>

              <div class="exercises_pt">
                <div class="exercises_container">
                  <a>
                    <h3>Worksheet</h3>
                  </a>
                </div>
              </div>

              <div class="exercises_pt">
                <div class="exercises_container">
                  <a>
                    <h3>Activities</h3>
                  </a>
                </div>
              </div>    
            </div>

            <div class="remarks">
              <div class="remarks_container">
                <h5><span>Remarks:</span> <br> <?php echo $remarks ?> </h5>
              </div>
            </div>

            <?php
              }
            } else {
              echo "No Grades Input";
            }
            ?>
            <div class="input-container" style="display: none;">
              <div>
                <h5>Total Score</h5>
                <input type="number" name="inputScore" class="inputScore" id="input-score">
              </div>
              <div>
                <h5>Number of Items</h5>
                <input type="number" name="inputItem" class="inputItem" id="input-item">
              </div>
            </div>
      </form>
    </div>
  </section>
  <script src="scripts.js"></script>
</body>

</html>