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
            <a href="patientQuery.php">Patient Query</a>
            <a href="equipmentQuery.php">Equipment Query</a>
            <a href="maintenanceRecordQuery.php">Maintenance Record Query</a>
            <a href="equipmentPurchaseSummary.php">Equipment Purchase Summary</a>
            <a href="patientDiseaseSummary.php">Patient Disease Summary</a>
            <a href="patientList.php">Patient List</a>
        </div>
            <div class="main">
                <h6>This query will calculate the total amount of equipment procurement given the time period.</h6>
                <h6>Please enter the start and end dates:</h6>
                <form method= "GET" action="equipmentPurchaseSummary.php">
                    <p><font size="3"> Start date: <input type="date" value="" name="startdate"> &nbsp;&nbsp;&nbsp;
                    End date: <input type="date" value="" name="enddate">
                    <p><input type="submit" value="submit" name="equipmentpurchasesummaryquery"></p>
                </form>

                <h6> </br></h6>
                <?php
                    $startdate = $_GET['startdate'];
                    $enddate = $_GET['enddate'];
                    $totalamount = NULL;

                    if ($enddate < $startdate) {
                        echo "invalid date inputs...<br>";
                        $startdate = NULL;
                        $enddate = NULL;
                    } elseif ($startdate == NULL or $enddate == NULL){
                        $totalamount = 0;
                    } else {
                        $totalamount = "90.45 (dummy value)";
                        //$totalamount = testfun1($p2, $p1);//TODO: call the function;
                    }
                    
                    echo "Start date: $startdate <br>";
                    echo "End date: $enddate <br>";
                    echo "Total equipment purchase amount: $ $totalamount <br>";
                ?>
                
            </div>

        </div>

        <div class="footer">
            <p>2019 UBC CPSC 304 Group 14</p>
        </div>
    </body>

</html>


