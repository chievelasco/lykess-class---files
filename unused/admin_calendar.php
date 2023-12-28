<?php
session_start();


include "connect1.php";
$query = "SELECT * FROM reg_info";
$results = mysqli_query($conn, $query);

if ($results) {
  while ($row = mysqli_fetch_assoc($results)) {
    $firstName = $row['stud_fname'];
    $mname = $row['stud_mname'];
    $surname = $row['stud_lname'];
    $idnumber = $row['studID_number'];

    if (isset($_POST["save_btn"])) {
      $studentId = $_POST["student_id"];
      $item = $_POST["inputItem"];
      $score = $_POST["inputScore"];
      $week = $_POST["inputWeek"];
      $average = $score / $item * 100;



      $checkQuery = "SELECT * FROM progress WHERE studID_number = '$studentId' AND week = '$week'";
      $checkResult = mysqli_query($conn, $checkQuery);

      if (mysqli_num_rows($checkResult) > 0) {
        $nameQuery = "SELECT stud_fname, stud_lname FROM reg_info WHERE studID_number = '$studentId'";
        $nameResult = mysqli_query($conn, $nameQuery);

        if ($nameRow = mysqli_fetch_assoc($nameResult)) {
          $firstName = $nameRow['stud_fname'];
          $surname = $nameRow['stud_lname'];

          $updateQuery = "UPDATE progress SET percent='$average', item='$item', score='$score', stud_fname='$firstName', stud_lname='$surname'
                            WHERE studID_number = '$studentId' AND week = '$week'";
          $results = executesQuery($updateQuery);
        } else {

          echo "Error: Student ID not found in reg_info";
        }
      } else {
        $nameQuery = "SELECT stud_fname, stud_lname FROM reg_info WHERE studID_number = '$studentId'";
        $nameResult = mysqli_query($conn, $nameQuery);

        if ($nameRow = mysqli_fetch_assoc($nameResult)) {
          $firstName = $nameRow['stud_fname'];
          $surname = $nameRow['stud_lname'];
          $insertQuery = "INSERT INTO progress (studID_number, percent, item, score, week, stud_fname, stud_lname)
                        VALUES ('$studentId', '$average', '$item', '$score', '$week', '$firstName', '$surname')";
          $results = executesQuery($insertQuery);
        }
      }
      $_SESSION["username"] = $studentId;

      header("Location: class_list.php");
      exit();
    }

  }
}
if (isset($_POST["remark-btn"])) {
  $remark = $_POST['remark'];
  $studentIdForRemarks = $_POST['student_id_for_remarks'];

  $checkQuery = "SELECT * FROM reg_info WHERE studID_number = '$studentIdForRemarks'";
  $checkResult = mysqli_query($conn, $checkQuery);

  if (mysqli_num_rows($checkResult) > 0) {
    $updateQuery = "UPDATE reg_info SET remarks = '$remark' WHERE studID_number = '$studentIdForRemarks'";
    $results = executesQuery($updateQuery);
  } else {
    $insertQuery = "INSERT INTO reg_info (studID_number, remarks) VALUES ('$studentIdForRemarks', '$remark')";
    $results = executesQuery($insertQuery);
  }

  header("Location: class_list.php");
  exit();
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <title>Responsive Sidebar</title>

  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
        <a href="classList.php">
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
        <a href="admin_calendar.php">
          <i class="fa fa-calendar"></i>
          <span class="link_name">Events Calendar</span>
        </a>
        <span class="tooltip">Events Calendar</span>
      </li>
      <li>
        <a href="profile real.php">
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
  <section class="class_list-section">
    <div class="text">Class List</div>
    <div class="grid auto-fit">

      <?php
      $query = "SELECT * FROM reg_info";
      $results = mysqli_query($conn, $query);
      if ($results) {
        while ($row = mysqli_fetch_assoc($results)) {
          $firstName = $row['stud_fname'];
          $mname = $row['stud_mname'];
          $surname = $row['stud_lname'];
          $idnumber = $row['studID_number'];
          $pfname = $row['parent_fullname'];
          $address = $row['address'];
          $contact = $row['contact_number'];
          $bday = $row['bday'];
          $none = $row['none'];
          $asthma = $row['asthma'];
          $eyesight = $row['eyesight'];
          $epilepsy = $row['epilepsy'];
          $allergy = $row['allergy'];
          $heart = $row['heart'];
          $pulmonary = $row['pulmonary'];

          $conditions = [];

          if ($none == 'yes' || $none == 'Yes') {
            $conditions[] = 'No health conditions specified';
          } else {
            if ($asthma == 'yes') {
              $conditions[] = 'Asthma';
            }
            if ($eyesight == 'yes') {
              $conditions[] = 'Eyesight';
            }
            if ($epilepsy == 'yes') {
              $conditions[] = 'Epilepsy';
            }
            if ($allergy != 'None') {
              $allergyType = $allergy;
              $conditions[] = "Allergy: $allergyType";
            }
            if ($heart != 'None') {
              $heartCondition = $heart;
              $conditions[] = "Heart: $heartCondition";
            }
            if ($pulmonary != 'None') {
              $pulmonaryCondition = $pulmonary;
              $conditions[] = "Pulmonary: $pulmonaryCondition";
            }
          }
          ?>

          <div class="container">

            <img src="https://i.pinimg.com/564x/fc/7a/1a/fc7a1aee0e1dd7f4acfe8b3347ac27c9.jpg">
            <h4>
              <h4>
                <?php echo $firstName . " " . $mname . " " . $surname; ?>
              </h4>
            </h4>
            <p>
              <?php echo $idnumber ?>
            </p>
            <div class="performance">
              <div class="progressbar-container">
                <div class="progressbar">
                  <div class="progressbar-rate">
                  </div>
                </div>
              </div>

              <button id="calcBtn" class="calcBtn">Grade Calculator</button>
              <div class="calcmodal" id="calc-modal">
                <div class="calcmodal-content">
                  <div class="calcmodal-header">
                    <span class="close-calc">&times;</span>
                    <h2>Grade Calculator</h2>
                    <div class="calcmodal-body">
                      <h4>Weekly Performance Rate</h4>
                      <div class="progress-container">
                        <div class="progress-rate">
                        </div>
                      </div>
                      <div class="input-container">
                        <form method="POST">
                          <input type="hidden" name="student_id" value="<?php echo $idnumber; ?>">
                          <div>
                            <h5>Total Score</h5>
                            <input type="number" name="inputScore" class="inputScore" id="inputScore">
                          </div>
                          <div>
                            <h5>Number of Items</h5>
                            <input type="number" class="inputItem" name="inputItem" id="inputItem">
                          </div>
                          <div>
                            <h5>Week</h5>
                            <input type="number" class="inputWeek" name="inputWeek" id="inputWeek">
                          </div>
                      </div>
                      <button class="progress-btn" id="progress-btn" type="button">Calculate</button>

                      <button class="save-btn" id="save-btn" name="save_btn" type="submit">Save</button>
                      </form>
                    </div>
                  </div>

                </div>
              </div>

            </div>
            <button id="myBtn" class="myBtn" name="myBtn">View Profile</button>
            <div class="modal" id="my-modal" name="modal">
              <div class="modal-content">
                <div class="modal-header">
                  <span class="close">&times;</span>
                  <h2>Profile Information</h2>
                </div>
                <div class="modal-body">
                  <h4>Parents Information</h4>
                  <li><span>Full Name: </span>
                    <?php echo $pfname ?>
                  </li>
                  <li><span>Full Address: </span>
                    <?php echo $address ?>
                  </li>
                  <li><span>Contact Number: </span>
                    <?php echo $contact ?>
                  </li>

                  <h4>Students Information</h4>
                  <li><span>Birthday: </span>
                    <?php echo $bday ?>
                  </li>
                  <li><span>Health Condition: </span>
                    <?php
                    if (!empty($conditions)) {
                      echo '<ul>';
                      foreach ($conditions as $condition) {
                        echo '<li>' . $condition . '</li>';
                      }
                      echo '</ul>';
                    } else {
                      echo '<li>No health conditions specified.</li>';
                    } ?>
                  </li>
                </div>
                <div class="modal-footer">
                  <h3>Kinder-Class 2023</h3>
                </div>
              </div>
            </div>
            <form method="POST">
              <input type="hidden" name="student_id_for_remarks" value="<?php echo $idnumber; ?>">
              <input type="textarea" class="remark" name="remark" placeholder="Your Remarks">
              <input type="submit" class="remark-btn" name="remark-btn" value="save"
                style="background-color: #73A9AD; border-radius:15px; padding-right: 10px; padding-left: 10px;">
            </form>
          </div>

          <?php
        }
      }
      ?>
    </div>
  </section>

  <div class="container" id="add-container" style="display: none;">
    <img src="https://i.pinimg.com/564x/fc/7a/1a/fc7a1aee0e1dd7f4acfe8b3347ac27c9.jpg">
    <h4>
      <input type="text" id="first-name" class="name-input" placeholder="First Name">
      <input type="text" id="middle-name" class="name-input" placeholder="Middle Name">
      <input type="text" id="last-name" class="name-input" placeholder="Last Name">
    </h4>
    <p id="student-id" class="student-info"></p>
    <div class="performance">
      <div class="progressbar-container">
        <div class="progressbar">
          <div class="progressbar-rate"></div>
        </div>
      </div>
    </div>
  </div>


  </div>

  <!-- Scripts -->
  <script src="scripts.js"></script>
  
</body>

</html>