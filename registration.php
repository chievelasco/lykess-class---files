<?php
session_start();
session_destroy();
session_start();

include "connect1.php";

if  (isset($_POST["submit-log"]) ){
    $firstName = $_POST["student-firstname"];
    $mname = $_POST["student-midname"];
    $parentname = $_POST["parent-name"];
    $surname = $_POST["student-surname"];
    $address = $_POST["address"];
    $idnumber = $_POST["student-idnumber"];
    $contact = $_POST["contact-number"];
    $password = $_POST["password"];
    $confirmpass = $_POST["confirm-password"];
    $bday = $_POST["student-bday"];

    $insertquery = "INSERT INTO reg_info (stud_fname, stud_mname, stud_lname, studID_number, parent_fullname, address, contact_number, password, confirm_pass, bday) VALUES ('$firstName', '$mname', '$surname', '$idnumber', '$parentname', '$address', '$contact', '$password', '$confirmpass', '$bday')";
    $results = executesQuery($insertquery);
    header("Location: index.php");
}
?>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <title>Sign Up</title>

    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #62969F;
            font-family: sans-serif;
        }

        .registration-box {
            width: 700px;
            height: 480px;
            background: #fff;
            top: 50%;
            left: 50%;
            position: absolute;
            transform: translate(-50%, -50%);
            box-sizing: border-box;
            padding: 70px 30px;
        }

        .avatar {
            width: 130px;
            height: 130px;
            position: absolute;
            left: 41%;
            top: -2%;
        }

        h1 {
            margin: 0;
            padding: 0 0 20px;
            text-align: center;
            font-size: 15px;
            margin-top: 20px;
            color: #297582;
            margin-left: 10px;
        }

        .registration-box p {
            margin: 0;
            padding: 0;
            font-weight: bold;
        }

        .registration-box input {
            width: 100%;
            margin-bottom: 10px;
            left: 10px;

        }

        .registration-box input[type="text"],
    .registration-box input[type="password"] {
        border: none;
        border-bottom: 1px solid #fff;
        background: #D9D9D9;
        outline: none;
        height: 40px;
        width: 300px;
        color: #545454;
        font-size: 16px;
        border-radius: 10px;
        padding-left: 20px;
        padding-right: 20px;
        margin-left: 10px;
        position: relative;
    }

        .registration-box button {
            border: none;
            outline: none;
            height: 35px;
            width: 100px;
            background: #1c8adb;
            font-size: 18px;
            border-radius: 10px;
            margin-bottom: 10px;
            margin-top: 10px;
            margin-left: 260px;
            color: #fff;
        }

        .registration-box button:hover {
            cursor: pointer;
            background: #39dc79;
            color: #000;
        }

        .registration-box a {
            text-decoration: none;
            font-size: 14px;
            color: #62969F;


        }

        .registration-box p span {
            font-size: 12px;
            text-decoration: none;
            color: gray;
            margin-left: 170px;
        }

        .registration-box a:hover {
            color: #39dc79;
        }

       
    </style>
</head>

<body>
    <div class="registration-box">
        <form method="POST" >
            <img src="https://i.ibb.co/vLvDRJ7/logo-2-1.png" class="avatar">
            <h1>Registration</h1>
            <!--<p>Student Information</p> -->
            <input type="text" name="student-firstname" id="student-firstname"placeholder="Student First Name">
            <input type="text" name="student-bday" id="student-bday"placeholder="* Student's Birthday DD/MM/YYY">
            <input type="text" name="student-midname"id="student-midname"placeholder="* Student Middle Name">
            <input type="text" name="parent-name"  id="parent-name" placeholder="* Parent Name">
            <input type="text" name="student-surname" id="student-surname" placeholder="* Student Surname">
            <!--<p>Parent's Information</p> -->
            <input type="text" name="student-idnumber"  id="student-idnumber" placeholder=" Student ID Number">
            <input type="text" name="contact-number"  id="contact-number" placeholder=" Contact Number">
            <input type="text" name="password"  id="password" placeholder=" Password">
            <input type="text" name="confirm-password" id="confirm-password" placeholder=" Confirm Password">
            <input type="text" name="address"  id="address" placeholder=" Address">

            <button class="submit-log" type="submit" name="submit-log" id="submit-log">Login</button><br>
            <p><span>Already have an account?</span> <a href="index.php">Login Here</a></p>
        </form>
    </div>

</body>

</html>