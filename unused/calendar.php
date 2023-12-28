<?php
include "connect1.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["addEvent"])) {
  $eventDate = $_POST["eventDate"];
  $eventTitle = $_POST["eventTitle"];
  $eventDescription = $_POST["eventDescription"];

  $startDatetime = $eventDate; 
  $endDatetime = $eventDate . " 23:59:59"; 

  $insertQuery = "INSERT INTO schedule_list (title, description, start_datetime, end_datetime) 
  VALUES ('$eventTitle', '$eventDescription', '$startDatetime', '$endDatetime')";

  if ($conn->query($insertQuery) === TRUE) {
    header("Location: calendar.php");
    exit(); 
    echo "Error: " . $insertQuery . "<br>" . $conn->error;
  }

}

$schedules = $conn->query("SELECT * FROM schedule_list");
$sched_res = [];
foreach ($schedules->fetch_all(MYSQLI_ASSOC) as $row) {
  $row['sdate'] = date("F d, Y h:i A", strtotime($row['start_datetime']));
  $row['edate'] = date("F d, Y h:i A", strtotime($row['end_datetime']));
  $sched_res[] = $row;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Responsive Sidebar</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css" />

  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>

  
  <link rel="stylesheet" href="style.css">
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
    .wrapper {
      max-width: 1100px;
      margin: 15px auto;
    }

    /* Calendar container */
    .container-calendar {
      background: #ffffff;
      padding: 15px;
      max-width: 900px;
      margin: 0 auto;
      overflow: auto;
      box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
      display: flex;
      justify-content: space-between;
      border-radius: 20px;
    }
    .row:after {
      content: "";
      display: table;
      clear: both;
    }
    .column1 {
      width: 270%;
      padding: 10px;
    } 
    .column2 {

      width: 250px;
      margin: 30px;
    } 
    /* Responsive layout - makes the two columns stack on top of each other instead of next to each other */
    @media screen and (max-width: 600px) {
      .column1 {
        width: 100%;
      }
      .column2 {
        width: 100%;
      }
    }

    /* Event section styling */
    #event-section {
      padding: 10px;
      background: #f5f5f5;
      margin: 20px 0;
      border: 1px solid #ccc;
    }
    #event-section2 {
      padding: 10px;
      background: #f5f5f5;
      margin: 20px 0;
    }


    .container-calendar #left h1 {
      color: var(--color-default);;
      text-align: center;
      background-color: #f2f2f2;
      margin: 0;
      padding: 10px 0;
    }

    #event-section h3 {
      color: var(--color-default);;
      font-size: 18px;
      margin: 0;
    }

    #event-section input[type="date"],
    #event-section input[type="text"] {
      margin: 10px 0;
      padding: 5px;
      width: 100%;
      border: 1px solid var(--color-default);
      border-radius: 10px;
    }
    #event-section input[type="time"],
    #event-section input[type="time"] {
      margin: 10px 0;
      padding: 5px;
      width: 100%;
      border: 1px solid var(--color-default);
      border-radius: 10px;
    }
    #event-section textarea {
      margin: 10px 0;
      padding: 5px;
      width: 100%;
      border: 1px solid var(--color-default);
      border-radius: 10px;
        
    }
    #event-section label {
      margin:0;
      padding: 0;
    }

    .eventbutton {
      background: var(--color-default);;
      color: white;
      border: none;
      border-radius: 10px;
      padding: 5px 10px;
      cursor: pointer;
    }

    .event-marker {
      position: relative;
    }

    .event-marker::after {
      content: '';
      display: block;
      width: 6px;
      height: 6px;
      background-color: red;
      border-radius: 50%;
      position: absolute;
      bottom: 0;
      left: 0;
    }

    /* event tooltip styling */
    .event-tooltip {
      position: absolute;
      background-color: rgba(234, 232, 232, 0.763);
      color: black;
      padding: 10px;
      border-radius: 4px;
      bottom: 20px;
      left: 50%;
      transform: translateX(-50%);
      display: none;
      transition: all 0.3s;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
      z-index: 1;
    }

    .event-marker:hover .event-tooltip {
      display: block;
    }

    /* Reminder section styling */
    #reminder-section {
      background: #ffffff;
      padding: 15px;
      max-width: 900px;
      margin: 0 auto;
        margin-top: 10px;
      box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2); 
        border-radius: 20px;
    }

    #reminder-section h3 {
      color: var(--color-default);;
      font-size: 18px;
      margin: 0;
    }

    #reminderList {
      list-style: none;
      padding: 0;
    }

    #reminderList li {
      margin: 5px 0;
      font-size: 16px;
    }
    #reminder-section button {
        background: var(--color-default);
        color: white;
        border: none;
        border-radius: 10px;
        padding: 2px 5px;
        cursor: pointer;
        float: right;
        width: 80px;
        margin-right: 2px;
    }
    /* Style for the delete buttons */
    .delete-event {
      background: rgb(237, 19, 19);
      color: white;
      border: none;
      padding: 5px 10px;
      cursor: pointer;
      margin-left: 10px;
      align-items: right;
    }

    /* Buttons in the calendar */
    .button-container-calendar button {
      cursor: pointer;
      background: var(--color-default);;
      color: #fff;
      border: 1px solid var(--color-default);;
      border-radius: 4px;
      padding: 5px 10px;
    }

    /* Calendar table */
    .table-calendar {
      border-collapse: collapse;
      width: 100%;
    }

    .table-calendar td,
    .table-calendar th {
      padding: 5px;
      border: 1px solid #e2e2e2;
      text-align: center;
      vertical-align: top;
    }

    /* Date picker */
    .date-picker.selected {
      background-color: #f2f2f2;
      font-weight: bold;
      outline: 1px dashed #00BCD4;
    }

    .date-picker.selected span {
      border-bottom: 2px solid currentColor;
    }

    /* Day-specific styling */
    .date-picker:nth-child(1) {
      color: red;
      /* Sunday */
    }

    .date-picker:nth-child(6) {
      color: var(--color-default);;
      /* Friday */
    }

    /* Hover effect for date cells */
    .date-picker:hover {
      background-color: var(--color-default);;
      color: white;
      cursor: pointer;
    }

    /* Header for month and year */
    #monthAndYear {
      text-align: center;
      margin-top: 0;
    }

    /* Navigation buttons */
    .button-container-calendar {
      position: relative;
      margin-bottom: 1em;
      overflow: hidden;
      clear: both;
    }

    #previous {
      float: left;
    }

    #next {
      float: right;
    }

    /* Footer styling */
    .footer-container-calendar {
      margin-top: 1em;
      border-top: 1px solid #dadada;
      padding: 10px 0;
    }

    .footer-container-calendar select {
      cursor: pointer;
      background: #ffffff;
      color: #585858;
      border: 1px solid #bfc5c5;
      border-radius: 3px;
      padding: 5px 1em;
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
    <!-- Main wrapper for the calendar application -->
    <div class="wrapper">
      <div class="container-calendar">
        <div class="row">
          <div class="column1" id="left">
            <h3 id="monthAndYear"></h3>
            <div class="button-container-calendar">
              <button id="previous" onclick="previous()">
                ‹
              </button>
              <button id="next" onclick="next()">
                ›
              </button>
            </div>
            <table class="table-calendar" id="calendar" data-lang="en">
              <thead id="thead-month"></thead>
              <!-- Table body for displaying the calendar -->
              <tbody id="calendar-body"></tbody>
            </table>
            <div class="footer-container-calendar">
              <label for="month">Jump To: </label>
              <!-- Dropdowns to select a specific month and year -->
              <select id="month" onchange="jump()">
                <option value=0>Jan</option>
                <option value=1>Feb</option>
                <option value=2>Mar</option>
                <option value=3>Apr</option>
                <option value=4>May</option>
                <option value=5>Jun</option>
                <option value=6>Jul</option>
                <option value=7>Aug</option>
                <option value=8>Sep</option>
                <option value=9>Oct</option>
                <option value=10>Nov</option>
                <option value=11>Dec</option>
              </select>
              <!-- Dropdown to select a specific year -->
              <select id="year" onchange="jump()"></select>
            </div>
          </div>
            <div class="column2" id="right">
              <h1>Events Calendar</h1>
              <?php
                $query = "SELECT * FROM schedule_list";
                $results = mysqli_query($conn, $query);

                if ($results) {
                  while ($row = mysqli_fetch_assoc($results)) {
                    $title = $row['title'];
                    $start = $row['start_datetime'];
                    
                    ?>
                    <!-- List to display reminders -->
                    <ul id="reminderList">
                      <li data-event-id="1">
                        <strong>Event:</strong>
                          <?php echo $title ?>
                        </strong>
                        <?php echo ' ' . ' ' . $start ?>
                      </li>
                    </ul>
                    <?php
                  }
                }
                if (isset($conn)) {
                  $conn->close();
                }
                ?>
            </div>
        </div>
      </div>
      
  </section>
  <!-- Include the JavaScript file for the calendar functionality -->
</body>
<script>
  // newscript.js
  function addEvent() {
    // Your existing logic...

    // Assuming you have a form with the id "event-section"
    var form = document.getElementById("event-section");

    // Submit the form
    form.submit();
  }
</script>
<script src="newscript.js"></script>

</html>