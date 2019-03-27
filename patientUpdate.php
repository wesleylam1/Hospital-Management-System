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
            <a href="patientUpdate.php">Patient Update</a>
            <a href="patientList.php">Patient List</a>
            <a href="patientDiseaseSummary.php">Patient Disease Summary</a>
            <a href="sickpatients.php">Sickly Patients</a>
        </div>
            <div class="main">
                <h3><b>Update Patient Records</b><h3>
                <!-- Form for adding new appointment -->
                <h6><b>Add New Appointment:</b></h6>
                <p>note: input date time is split into date and then start time and end time </br></p>
                <p></p>  
                <form method= "POST" action="patientUpdate.php">
                    <p> <font size="2" color=black> Doctor ID:  <input type="number" name="doctorid"> &nbsp;&nbsp; </br>
                        <font size="2" color=black> Patient ID: <input type="number" name="patientid"> &nbsp;&nbsp; </p>
                    <p> <font size="2" color=black> Date: <input type="date" name="date"> &nbsp;&nbsp; 
                        <font size="2" color=black> Start time: <input type="text" placeholder="hh24:mi:ss" name="starttime"> &nbsp;&nbsp; 
                        <font size="2" color=black> End time: <input type="text" placeholder="hh24:mi:ss" name="endtime"> &nbsp;&nbsp; </p>
                    <p> <font size="2" color=black> Room department: <input type="text" name="roomdpmt"> &nbsp;&nbsp; </br>
                        <font size="2" color=black> Room number: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type="number" name="roomnum"> &nbsp;&nbsp; </p>
                    <p><input type="submit" value="Add Appointment" name="insertappointment"></p>
                </form>
                <?php
                    $doctorid = $_POST['doctorid'];
                    $patientid = $_POST['patientid'];
                    $date = $_POST['date'];
                    $starttime = $date . ' ' . $_POST['starttime'];
                    $endtime = $date . ' ' . $_POST['endtime'];
                    $roomdept = $_POST['roomdpmt'];
                    $roomnum = $_POST['roomnum'];
                    
                    if ($db_conn) {
                        if (array_key_exists('insertappointment', $_POST)) {
                            executePlainSQL("INSERT INTO Appointment
                            VALUES ($patientid, $doctorid, '$roomdept', $roomnum, TO_DATE ('$starttime', 'yyyy/mm/dd hh24:mi:ss'),
                            TO_DATE('$endtime', 'yyyy-mm-dd hh24:mi:ss'))");
                            
                            executePlainSQL("COMMIT WORK");
                        }
                    }
                ?>


                </br> <!-- Form for inserting new treatment history and prescription -->
                <h6><b>Add New Treatment History & Prescription Data:</b></h6>
                <p></p>
                <form method= "POST" action="patientUpdate.php">
                    <p> <font size="2" color=black> Patient ID: <input type="number" name="patientid"> &nbsp;&nbsp;</br> 
                        <font size="2" color=black> Date: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="date" name="date"> &nbsp;&nbsp; 

                    <p><b> <font size = "2" color = black>Prescription Detials: </b></p>
                        <font size="2" color=black> Drug name: 
                            <input type="text" name="drugname"> </br> 
                        <font size="2" color=black> Dosage: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="number" name="dosage"> </br> 
                        <font size="2" color=black> Refills: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="number"  name="refills"> </br> 
                        <font size="2" color=black> Total amount: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="number" name="totalamt"> </br> 
                        <font size="2" color=black> Duration (days): &nbsp;
                            <input type="number" name="duration"> </br> 
                        <font size="2" color=black> Price: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="number" step=0.01 name="price"> &nbsp;&nbsp;
                    </p>

                    <p><b> <font size = "2" color = black>Medical Notes: </b></p>
                        <textarea rows = "4" cols = "50" name = "mednotes"> Enter medical notes here... </textarea>
                    <p><input type="submit" value="Submit" name="inserttreatment"></p>
                </form>

                <?php
                    $patientid1 = $_POST['patientid'];
                    $date1 = $_POST['date'];
                    $medicalnotes1 = $_POST['mednotes'];
                    $id1 = rand(100, 1000000000);
                    
                    $drugname = $_POST['drugname'];
                    $dosage = $_POST['dosage'];
                    $refills = $_POST['refills'];
                    $totalamt = $_POST['totalamt'];
                    $duration = $_POST['duration'];
                    $price = $_POST['price'];

                    if ($db_conn) {
                        if (array_key_exists('inserttreatment', $_POST)) {
                            executePlainSQL("INSERT INTO Treatment_History VALUES ($id1, DATE '$date1', '$medicalnotes1', $patientid1)");
                            executePlainSQL("INSERT INTO Prescription1 VALUES ('$drugname', $totalamt, $price)");
                            executePlainSQL("INSERT INTO Prescription2 VALUES ($dosage, $duration, $totalamt)");
                            executePlainSQL("INSERT INTO Prescription VALUES ('$drugname', $refills, $dosage, $duration, $id1)");
                            executePlainSQL("COMMIT WORK");
                        }
                    }
                ?>


                </br> <!-- Form for updating disease name -->
                <h6><b>Update Disease Name:</b></h6>
                <p></p>
                <form method= "POST" action="patientUpdate.php">
                    <p> <font size="2" color=black> Patient ID: 
                            <input type="number" name="patientid"> &nbsp;&nbsp;
                        <font size="2" color=black> Disease old name: 
                            <input type="text" name="oldnm"> &nbsp;&nbsp; 
                        <font size="2" color=black> Disease new name: 
                            <input type="text" name="newnm"> &nbsp;&nbsp;</p>
                    <p><input type="submit" value="Update" name="updatediseasename"></p>
                </form>
                <?php
                    $pid = $_POST['patientid'];
                    $dname = $_POST['oldnm'];
                    $newname = $_POST['newnm'];

                    if ($db_conn) {
                        if (array_key_exists('updatediseasename', $_POST)) {
                            executePlainSQL("UPDATE Has_Disease SET disease_name='$newname' WHERE disease_name='$dname' AND patient_id=$pid");
                            executePlainSQL("COMMIT WORK");
                        }
                    }
                    
                ?>

                </br> <!-- Form for updaiting disease condition -->
                <h6><b>Update Patient's Disease Condition (cured or not cured):</b></h6>
                <form method= "POST" action="patientUpdate.php">
                    <p> <font size="2" color=black> Patient ID: 
                            <input type="number" name="patientid"> &nbsp;&nbsp;
                        <font size="2" color=black> Disease name: 
                            <input type="text" name="diseasenm">  &nbsp;&nbsp; 
                        <font size="2" color=black> Condition: 
                            <select name="cured"> 
                                <option value="true">Cured</option>
                                <option value="false">Not cured</option>
                            </select>&nbsp;&nbsp;</p>
                    <p><input type="submit" value="Update" name="updatediseasecondition"></p>
                </form>
                <?php
                    $pid1 = $_POST['patientid'];
                    $dname1 = $_POST['diseasenm'];
                    $condition = $_POST['cured'];
                    if ($condition == "true") {
                        $condition = '1';
                    } else {
                        $condition = '0';
                    }
                    
                    if ($db_conn) {
                        if (array_key_exists('updatediseasecondition', $_POST)) {
                            executePlainSQL("UPDATE Has_Disease SET cured='$condition' WHERE disease_name='$dname1' AND patient_id=$pid1");
                            executePlainSQL("COMMIT WORK");
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


