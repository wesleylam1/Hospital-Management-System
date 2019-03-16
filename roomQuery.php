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
    <link rel="stylesheet" href="./css/result_table.css" />
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
            <a href="roomQuery.php">Room Assignment Query</a>
        </div>
            <div class="main">
                <h6>This query will generate a list of rooms that a nurse is assigned to.</h6>
                <h6>Please enter the your nurse id below and select which field(s) to output in the result table:</h6>
                <form method= "GET" action="roomQuery.php">
                    <p><font size="3"> Nurse ID: <input type="text" value="" name="staffid">
                    <p><input type="checkbox" name="roomtype" value="true" checked> room type </br>
                    <p><input type="submit" value="submit" name="roomquery"></p>
                </form>

                <?php
                    $nurseid = $_GET['staffid'];
                ?>

                <h5></br><b>Room Assignment Query Result</b></h5>
                <?php echo "Nurse ID: ".$nurseid; ?>

                <h6><b>Table: List of assigned rooms</b></h6>
                <?php
                    echo "note: we can change cols below, depends on what we wanna output </br>";
                    $cols = array("Room Department", "Room Number");
                    if ($_GET['roomtype'] == "true") {
                        //$cols = array("Room Department", "Room Number", "Room Type");
                        $cols = array("Room Department", "Room Number", "Type");
                    }
                    echo "TODO: need to call fn to get data for table and store as result";
                    //$result = !!!;
                    $result = NULL;

                    printTable($result, $cols);
                ?>
            </div>
        </div>

        <div class="footer">
            <p>2019 UBC CPSC 304 Group 14</p>
        </div>
    </body>

</html>


