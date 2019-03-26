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
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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

    /*add drop down list in navbar*/
    .dropdown {
        float: left;
        overflow: hidden;
    }
    .dropdown .dropbtn {
        font-size: 16px;  
        border: none;
        outline: none;
        color: white;
        padding: 14px 16px;
        background-color: inherit;
        font-family: inherit;
        margin: 0;
    }
    .dropdown-content {
        display: none;
        position: absolute;
        background-color: #f9f9f9;
        min-width: 160px;
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
        z-index: 1;
    }

    .dropdown-content a {
        float: none;
        color: black;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
        text-align: left;
    }

    .dropdown-content a:hover {
        background-color: #ddd;
    }

    .dropdown:hover .dropdown-content {
        display: block;
    }
    </style>

    <div class = "header">
        <h1><b><a href= "home.php" style="text-decoration:none;">Hospital Management System </a></b></h1>
        <p>UBC CPSC304 Project </p>
    </div>

    </head>

    <body>
        <div class="navbar">
            <div class="dropdown">
                <button class="dropbtn">User Classes 
                    <i class="fa fa-caret-down"></i>
                </button>
                    <div class="dropdown-content">
                        <a href="doctor.php">Doctor</a>
                        <a href="nurse.php">Nurse</a>
                        <a href="admin.php">Admin</a>
                    </div>
            </div>
            <a href="patientQuery.php">Patient Query</a>
            <a href="equipmentQuery.php">Equipment Query</a>
            <a href="maintenanceRecordQuery.php">Maintenance Record Query</a>
            <a href="equipmentPurchaseSummary.php">Equipment Purchase Summary</a>
            <a href="patientDiseaseSummary.php">Patient Disease Summary</a>
            <a href="patientList.php">Patient List</a>
        </div>
            <div class="main">
                <h3><b>Maintenance Records Query</b><h3>
                <h6>This query will generate all maintenance records for the given equipment. 
                The admin is able to add new maintenance record.</h6>
                <h6>Please enter the equipment id below:</h6>
                <form method= "GET" action="maintenanceRecordQuery.php">
                    <p><font size="3" color=black> Equipment ID: 
                        <input type="number" name="equipid">
                    <input type="submit" value="get records" name="mrecordquery"></p>
                </form>
                </br> <!-- Render maintenance records for the selected equipment -->
                <h6><b>Maintenance Reocrds:</b></h6>
                <?php
                    $epid = $_GET['equipid'];
                    echo "Equipment ID: ".$epid."</br>";
                    $result = NULL;
                    
                    if ($db_conn) {
                        if (array_key_exists('mrecordquery', $_GET)) {
                            $cols = array("Record ID", "Date", "Pass", "Admin ID");
                            // call fn here...
                            
                            printTable($result, $cols);
                        } elseif ($epid != NULL){
                            echo "invalid input...</br>";
                        }
                    }
                    
                ?>

                </br> <!-- Form for inserting a maintenance record -->
                <h6><b>Add New Maintenance Reocrd:</b></h6>
                <form method= "GET" action="maintenanceRecordQuery.php">
                    <p><font size="3" color=black> 
                        Equipment ID: &nbsp;&nbsp;
                            <input type="number" name="equipid"> </br>
                        Date: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="date" name="date"> </br>
                        Pass/Fail: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <select name="pass"> 
                                <option value="true">Pass</option>
                                <option value="false">Fail</option>
                            </select> </br>
                        Admin ID: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="number" name="adminid"> </br>
                            
                    <input type="submit" value="Add" name="insert_mrecord"></p>
                </form>
                <?php
                    if ($db_conn) {
                        if (array_key_exists('insert_mrecord', $_POST)) {
                            // call fn here
                        }
                    }
                ?>

            </div>
        </div>

        <div class="footer">
            <p>2019 UBC CPSC 304 Group 14</p>
        </div>
    </body>

</html>


