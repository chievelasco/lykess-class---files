<?php
session_start();
session_destroy();
session_start();

include "connect1.php";


if (isset($_POST["submit-logs"])) {
    // Check if the session variable is set
    if(isset($_SESSION['student_data'])) {
        // Get data from the session
        $studentData = $_SESSION['student_data'];

        // Get data from the form on page 2
        $fName = $_POST["parent-firstname"];
        $add = $_POST["address"];
        $relation = $_POST["relationship"];
        $contact = $_POST["contact-no"];
        $occu = $_POST["occupation"];
        $pass = $_POST["password"];
        $conpass = $_POST["confirm-password"];
        // Add the data from page 1 to the data from page 2
        $studentData['parent_fullname'] = $fName;
        $studentData['address'] = $add;
        $studentData['relation'] = $relation;
        $studentData['contact'] = $contact;
        $studentData['occu'] = $occu;
        $studentData['pass'] = $pass;
        $studentData['conpass'] = $conpass;

        // Check if the record with the studID_number already exists
        $checkQuery = "SELECT * FROM reg_info WHERE studID_number = '{$studentData['studID']}'";
        $checkResult = mysqli_query($conn, $checkQuery);

        // Rest of your code remains unchanged
        // ...
    } else {
        // Handle the case where the session variable is not set
        echo "Session variable 'student_data' not set.";
    }
}
?>

<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <title>Sign Up</title>
    </head>

    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #62969F;
            font-family: sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .container-fluid {
            max-width: 700px;
            width: 100%;
            background: #fff;
            left: 50%;
            top: 50%;
            position: absolute;
            transform: translate(-50%, -50%);
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
        }
        .avatar {
            width: 110px;
            height: 110px;
            position: absolute;
            left: 41%;
            top: -2%;
        }
        h1{
            margin: 0;
            padding: 0 0 20px;
            text-align: left;
            font-size: 18px;
            margin-top: 100px;
            color: #297582;
            font-weight: bold;
        }
        .col-12 p{
            font-size: 15px;
        }
        .col-12 span {
            color: red;
            font-style: italic;
        }
        .col-12 label {
            margin-left: 8px;
        }
        .col-12 .form-check4,.form-check5,
        .form-check6, .form-check8 {
            box-sizing: border-box;
            margin: 5px;
        }
        .page-link {
            color: #fff;
            background: #297582;
        }
        .page-link:hover {
            background: #3bafda !important;
            color: #fff;
        }
        .col-12 .btn  {
            margin-left: 520px;
            cursor: pointer;
            transition: all 0.3s ease-out;
            color: #fff;
            background: #5cb85c;
            border: none;
            padding: 8px;
        }
        .col-12 .btn:hover {
            background: #408f40;
        }
    </style>

    <body>
        <div class="container-fluid">
            <img src="https://i.ibb.co/vLvDRJ7/logo-2-1.png" class="avatar">
            <h1>Guardian's Information</h1>

            <form class="row g-3" method="POST">
                <div class="col-12">
                  <label for="student-firstname" class="form-label"></label>
                  <input type="text" class="form-control" id="parent-fname" name="parent-firstname" placeholder="Full Name" required>
                </div>
                <!--<div class="col-md-4">
                  <label for="student-middleinitial" class="form-label"></label>
                  <input type="text" class="form-control" id="stud-mname" name="parent-middleinitial" placeholder="Middle Initial">
                </div>
                <div class="col-md-4">
                    <label for="student-lastname" class="form-label"></label>
                    <input type="text" class="form-control" id="stud-lname" name="parent-lastname" placeholder="Last Name" required>
                 </div>  -->
                <div class="col-12">
                    <label for="address" class="form-label"></label>
                    <input type="text" class="form-control" id="add" name="address" placeholder="Complete Address" required>

                </div>
                <div class="col-md-4">
                  <label for="relation" class="form-label"></label>
                  <input type="text" class="form-control" id="relation" name="relationship" placeholder="Relation to the student" required>
                </div>
                <div class="col-md-4">
                  <label for="contact" class="form-label"></label>
                  <input type="text" class="form-control" id="contact" name="contact-no" placeholder="Contact Number" required>
                </div>
                <div class="col-md-4">
                  <label for="occ" class="form-label"></label>
                  <input type="text" class="form-control" id="occ" name="occupation" placeholder="Occupation" required>
                </div>
                
                <div class="col-md-6">
                    <label for="pass" class="form-label"></label>
                    <input type="password" class="form-control" id="pass" name="password" placeholder="Password" required>
                </div>
                <div class="col-md-6">
                    <label for="confirm-pass" class="form-label"></label>
                    <input type="password" class="form-control" id="confirm-pass" name="confirm-password" placeholder="Confirm Password" required>
                </div>
                
                <div class="col-12">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                          <li class="page-item"><a class="page-link" href="user-registration.php">Previous</a></li>
                          <button type="submit" class="btn btn-success" name="submit-logs">Sign In</button>
                        </ul>
                    </nav>
                    
                </div>
              </form>
        </div>
    </body>
</html>