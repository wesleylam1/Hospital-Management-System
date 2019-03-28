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
            <a href="equipmentQuery.php">Equipment Query</a>
            <a href="maintenanceRecordQuery.php">Maintenance Record Query</a>
            <a href="equipmentPurchaseSummary.php">Equipment Purchase Summary</a>
        </div>
            <div class="main">
                <h3><b>Equipment Query</b><h3>
                <h6>A table containing the equipment info will be generated in this query. 
                The admin is able to update, insert and delete the equipment records.</h6>
                
                <h6>Please enter the equipment id below:</h6>
                <form method= "GET" action="equipmentQuery.php">
                    <p><font size="3" color=black> Equipment ID: <input type="number" value="" name="equipmentid">
                    <input type="submit" value="submit" name="equipmentquery"></p>
                </form>

                </br> <!-- Render table for the selected equipment -->
                <h6><b>Equipment Data:</b></h6>
                <?php
                    $epid = $_GET['equipmentid'];
                    echo "Equipment ID: ".$epid."</br>";
                    $result = NULL;
                    $cols = array("Name", "Brand", "Usage", "Purchase Date", 
                    "Price", "Manufacturing Location", "Customer Support Phone Number");
                    if ($db_conn){
                        if (array_key_exists('equipmentquery', $_GET)){
                    		$result = executePlainSQL("SELECT e.name, e.brand, e1.usage, e.purchase_date, e.price, e2.manufactured_in, e3.customer_support_number
                                                      FROM Equipment e, Equipment1 e1, Equipment2 e2, Equipment3 e3
                                                      WHERE e.brand = e3.brand AND e.name = e1.name AND e.name = e2.name AND e.brand = e2.brand AND e.id = $epid");
                            
                            printTable($result, $cols);
                        }
                    }
                ?>
                
                </br> <!-- Add new equipment -->
                <h6><b>Add New Equipment:</b></h6>
                <form method= "POST" action="equipmentQuery.php">
                    <p><font size="2" color=black> 
                    Equipment ID: &nbsp;&nbsp;&nbsp;<input type="number" value="" name="equipmentid_insert"> </br>
                    Name: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="text" value="" name="name"> </br>
                    Brand: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="text" value="" name="brand"> </br>
                    Usage: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="text" value="" name="usage"> </br>
                    Purchase Date:&nbsp;
                        <input type="date" value="" name="date"> </br>
                    Purchase Price: 
                        <input type="number" step=0.01 value="" name="price"> </br>
                    Manufacturing Location: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="text" value="" name="m_loc"> </br>
                    Customer Support Phone Number: 
                        <input type="text" value="" name="phone"> </br>
                    <p><input type="submit" value="Add" name="insert_equipment"></p>
                </form>
                <?php
                    $id = $_POST['equipmentid_insert'];
                    $name = $_POST['name'];
                    $brand = $_POST['brand'];
                    $usage = $_POST['usage'];
                    $purchasedate = $_POST['date'];
                    $price = $_POST['price'];
                    $manufacturedin = $_POST['m_loc'];
                    $csphonenum = $_POST['phone'];
                    if ($db_conn) {
                            if (array_key_exists('insert_equipment', $_POST)){
                            executePlainSQL("INSERT INTO Equipment3 Values('$brand', '$csphonenum')");
                            executePlainSQL("INSERT INTO Equipment1 Values('$name', '$usage')");
                            executePlainSQL("INSERT INTO Equipment2 Values('$name', '$brand', '$manufacturedin')");
                            executePlainSQL("INSERT INTO Equipment Values('$id', '$name', '$brand', DATE '$purchasedate', '$price')");
                            executePlainSQL("COMMIT WORK");
                            }
                    }
                ?>
                
                </br> <!-- Update equipment record -->
                <h6><b>Update Equipment Customer Support Number:</b></h6>
                <!-- form to be created!!! -->
                <form method= "POST" action="equipmentQuery.php">
                    <p><font size="2" color=black> 
                    Equipment ID: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="number" value="" name="equipmentid_update">
                    <p><font size="2" color=black> 
                    Customer Support Number: 
                        <input type="text" value="" name="csphonenum"></br>
                    <p><input type="submit" value="Update" name="update_equipment"></p>
                </form>
                <?php
                    $csphonenum = $_POST['csphonenum'];
                    $eid1 = $_POST['equipmentid_update'];
                    if ($db_conn) {
                        if (array_key_exists('update_equipment', $_POST)) {
                            executePlainSQL("UPDATE Equipment3 SET customer_support_number = '$csphonenum' 
                                            WHERE brand = (SELECT brand e FROM Equipment e WHERE e.brand = brand AND e.id = $eid1)");
                            executePlainSQL("COMMIT WORK");
                        }
                    }
                ?>

                </br> <!-- delete equipment -->
                <h6><b>Delete Equipment:</b></h6>
                <form method= "POST" action="equipmentQuery.php">
                    <p><font size="2" color=black> Equipment ID: <input type="number" value="" name="equipmentid_del">
                    <p><input type="submit" value="Delete" name="delete_equipment"></p>
                </form>
                <?php
                    $epid_del = $_GET['equipmentid_del'];
                    $eid = $_POST['equipmentid_del'];
                    if ($db_conn) {
                        if (array_key_exists('delete_equipment', $_POST)) {
                            executePlainSQL("DELETE FROM Equipment WHERE  id=$eid");
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
