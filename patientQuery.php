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
            <a href="patientList.php">Patient List</a>
        </div>
            <div class="main">
                <h3><b>Patient Query</b><h3>
                <h6>Three tables will be generated for the given patient: treatment & prescription history, appointment table and disease table.</h6>
                <h6>Please enter the patient id below:</h6>
                <form method= "GET" action="patientQuery.php">
                    <p><font size="3" color=black> Patient ID: 
                        <input type="number" name="patientid">
                        <input type="submit" value="submit" name="patientquery"></p>
                </form>
                
                <h5></br><b>Patient Query Result</b></h5>
                <?php 
                    // populateDb(); // !!! COMMENT AFTER WE FINISH PROJECT, OR NEW DB INFO WILL BE LOST AFTER EACH REFRESH.
                    $pid = $_GET['patientid'];
                    echo "Patient ID: ".$pid."</br>"; 
                ?>

                <h6><b>Table 1: Treatment & Prescription History</b></h6>
                <?php
                    $cols1 = array("Date", "Medical Notes", "Drug Name", "Refills", "Dosage", "Duration (days)", "Total Amount", "Drug Price");
                    $result1 = NULL;
                    if ($db_conn) {
                        if (array_key_exists('patientquery', $_GET)) {
                            $result1 = executePlainSQL("SELECT th.treatment_date, th.medical_notes, p.drug_name, p.refills, p.dosage, p.duration_days, p1.total_amount, p1.price FROM Prescription p
                            JOIN Prescription2 p2 ON p2.dosage = p.dosage and p2.duration_days = p.duration_days
                            JOIN Prescription1 p1 ON p.drug_name = p1.drug_name and p2.total_amount = p1.total_amount
                            RIGHT OUTER JOIN Treatment_History th ON th.id = p.treatment_history_id
                            WHERE th.patient_id = $pid
                            ORDER BY th.id"
                            );
                            
                            printTable($result1, $cols1);
                        }
                    }
                    
                ?>

                <h6></br><b>Table 2: Appointments</b></h6>
                <?php
                    $cols2 = array("Doctor ID", "Specialization", "Start Time", "End Time", "Room Department", "Room ID", "Equipment Count");
                    $resultx = NULL;
                    $result2 = NULL;

                    if ($db_conn) {
                        if (array_key_exists('patientquery', $_GET)) {
                            $resultx = executePlainSQL("CREATE VIEW RoomEquipmentCount(room_dept, room_num, numEquipment) AS 
                                SELECT room_department, room_number, count(*)
                                FROM locatedAt
                                GROUP BY room_department, room_number
                            ");

                            $result2 = executePlainSQL("SELECT a.doctor_id, d.specialization, a.start_date_time, a.end_date_time, r.department, r.room_number, re.numEquipment
                                FROM appointment a, doctor d, room r LEFT OUTER JOIN RoomEquipmentCount re ON re.room_dept = r.department AND re.room_num = r.room_number
                                WHERE a.doctor_id = d.id AND a.patient_id = $pid AND a.room_dept = r.department AND a.room_num = r.room_number
                                ORDER BY a.start_date_time, a.end_date_time
                            ");
                            
                            executePlainSQL("DROP VIEW RoomEquipmentCount");

                            printTable($result2, $cols2);
                        }
                    }
                ?>

                <h6></br><b>Table 3: Diseases</b></h6>
                <?php
                    $cols3 = array("Disease Name", "Cured (0-False, 1-True)");
                    $result3 = NULL;
                    if ($db_conn) {
                        if (array_key_exists('patientquery', $_GET)) {
                            $result3 = executePlainSQL("select disease_name, cured from Has_Disease where patient_id=$pid");
                            OCICommit($db_conn);

                            printTable($result3, $cols3);
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


