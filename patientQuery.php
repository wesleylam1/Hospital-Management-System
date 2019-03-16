<?php
require ('functions.php');
$db_conn = dbConnect();
//$success = true;
?>

<!DOCTYPE html>
<html lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/3/w3.css">
    <link rel="stylesheet" href="./css/short_result_table.css" />
    <head>
        <title> Hospital Mgmt Sys </title>
    <style> 
    * {
        box-sizing: border-box;
    }
    body {
        font-family: Arial, Helvetica, sans-serif;
        margin: 0;
    }
    /* Style the header */
    .header {
        padding: 5px;
        text-align: left;
        background: rgb(255, 255, 255);
        color: rgb(0, 0, 0);
    }

    /* Increase font size of h1 elemet */
    .header h1 {
        font-size: 30px;
    }

    /* Style the navigation bar links */
    .navbar {
        overflow: hidden;
        background-color: rgb(174, 179, 224);
    }

    /* Style the navigation bar links */
    .navbar a {
        float: left;
        display: block;
        color: black;
        text-align: center;
        padding: 14px 20px;
        text-decoration: none;
    }

    /* Right-aligned link */
    .navbar a.right {
        float: right;
    }

    /* Change color on hover */
    .navbar a:hover {
        background-color: rgb(107, 134, 96);
        color: whitesmoke;
    }

    /* Column container */
    .row {
        display: flex;
        flex-wrap: wrap;
    }

    /* Create 2 unequal columns that sits next to each other */
    /* Sidebar (left column) */
    /*
    .side {
        flex: 20%;
        background-color: bisque;
        padding: 20px;
    }
    */

    /* Main column */
    .main {
        flex: 80%;
        background-color: whitesmoke;
        padding: 20px;
    }

    /* Fake image */
    .fakeimg {
        background-color: #aaaaaa;
        width: 100%;
        padding: 20px;
    }

    /* Footer */
    .footer {
        padding: 10px;
        text-align: center;
        background: #ddd;
    }  

    /* Responsive layout - when the screen is less than 700px wide, make the two columns stack on top of each other instead of next to each other */
    @media screen and (max-width: 700px) {
    .row {   
        flex-direction: column;
    }
    }

    /* Responsive layout - when the screen is less than 400px wide, make the navigation links stack on top of each other instead of next to each other */
    @media screen and (max-width: 400px) {
    .navbar a {
        float: none;
        width:100%;
    }
    }
    </style>

    <div class = "header">
        <h1>Hospital Management System</h1>
        <p>UBC CPSC304 Project </p>
    </div>

    </head>

    <body>
        <div class="navbar">
            <a href="home.php">Home</a>
            <a href="patientQuery.php">Patient Query</a>
            <a href="patientList.php">Patient List</a>
        </div>
            <div class="main">
                <h6>Three tables will be generated for the given patient: treatment & prescription history, appointment table and disease table.</h6>
                <h6>Please enter the patient id below:</h6>
                <form method= "GET" action="patientQuery.php">
                    <p><font size="3"> Patient ID: <input type="text" value="" name="patientid">
                    <p><input type="submit" value="submit" name="patientquery"></p>
                </form>
                
                <h5></br><b>Patient Query Result</b></h5>
                <?php 
                    $pid = $_GET['patientid'];
                    echo "Patient ID: ".$pid."</br>"; 
                ?>

                <h6><b>Table 1: Treatment & Prescription History</b></h6>
                <?php
                    echo "note: we can change cols below, depends on what we wanna output </br>";
                    $cols1 = array("Date", "Medical Notes", "Drug Name", "Dosage", "Refills", "Total Amount");
                    echo "TODO: need to call fn to get data for table and store as result";
                    //$result1 = !!!;
                    $result1 = NULL;

                    printTable($result1, $cols1);
                ?>

                <h6></br><b>Table 2: Appointments</b></h6>
                <?php
                    echo "note: we can change cols below, depends on what we wanna output </br>";
                    $cols2 = array("Start Time", "End Time", "Doctor ID", "Patient ID", "Room Department", "Room ID");
                    echo "TODO: need to call fn to get data for table and store as result";
                    //$result2 = !!!;
                    $result2 = NULL;

                    printTable($result2, $cols2);
                ?>

                <h6></br><b>Table 3: Diseases</b></h6>
                <?php
                    echo "note: we can change cols below, depends on what we wanna output </br>";
                    $cols3 = array("Disease Name", "Status");
                    echo "TODO: need to call fn to get data for table and store as result";
                    //$result3 = !!!;
                    $result3 = NULL;

                    printTable($result3, $cols3);
                ?>

            </div>
        </div>

        <div class="footer">
            <p>2019 UBC CPSC 304 Group 14</p>
        </div>
    </body>

</html>


