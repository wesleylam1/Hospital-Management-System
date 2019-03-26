<?php
function dbConnect() {
	// NOTE: Change DB information to your own
	return OCILogon("ora_n0l1b", "a47141106", "dbhost.ugrad.cs.ubc.ca:1522/ug");
}
function dbLogout($db_conn) {
	OCILogoff($db_conn);
}
function executeMultipleSqlCommands($arr) {
    foreach ($arr as $cmd) {
        executePlainSQL($cmd);
    }
}
function executePlainSQL($cmdstr) { 
    // Take a plain (no bound variables) SQL command and execute it.
   //echo "<br>running ".$cmdstr."<br>";
   global $db_conn, $success;
   $statement = OCIParse($db_conn, $cmdstr); 
    // There is a set of comments at the end of the file that 
    // describes some of the OCI specific functions and how they work.
   if (!$statement) {
       echo "<br>Cannot parse this command: " . $cmdstr . "<br>";
       $e = OCI_Error($db_conn); 
          // For OCIParse errors, pass the connection handle.
       echo htmlentities($e['message']);
       $success = False;
   }
   $r = OCIExecute($statement, OCI_DEFAULT);
   if (!$r) {
       echo "<br>Cannot execute this command: " . $cmdstr . "<br>";
       $e = oci_error($statement); 
          // For OCIExecute errors, pass the statement handle.
       echo htmlentities($e['message']);
       $success = False;
   } else {
   }
   return $statement;
}
function executeBoundSQL($cmdstr, $list) {
	/* Sometimes the same statement will be executed several times.
        Only the value of variables need to be changed.
	   In this case, you don't need to create the statement several
        times.  Using bind variables can make the statement be shared
        and just parsed once.
        This is also very useful in protecting against SQL injection
        attacks.  See the sample code below for how this function is
        used. */
	global $db_conn, $success;
	$statement = OCIParse($db_conn, $cmdstr);
	if (!$statement) {
		echo "<br>Cannot parse this command: " . $cmdstr . "<br>";
		$e = OCI_Error($db_conn);
		echo htmlentities($e['message']);
		$success = False;
	}
	foreach ($list as $tuple) {
		foreach ($tuple as $bind => $val) {
			//echo $val;
			//echo "<br>".$bind."<br>";
			OCIBindByName($statement, $bind, $val);
			unset ($val); // Make sure you do not remove this.
                              // Otherwise, $val will remain in an 
                              // array object wrapper which will not 
                              // be recognized by Oracle as a proper
                              // datatype.
		}
		$r = OCIExecute($statement, OCI_DEFAULT);
		if (!$r) {
			echo "<br>Cannot execute this command: " . $cmdstr . "<br>";
			$e = OCI_Error($statement);
                // For OCIExecute errors pass the statement handle
			echo htmlentities($e['message']);
			echo "<br>";
			$success = False;
		}
	}
}
function printTable($resultFromSQL, $namesOfColumnsArray)
{
    echo "<table>";
    echo "<tr>";
    // iterate through the array and print the string contents
    foreach ($namesOfColumnsArray as $name) {
        echo "<th>$name</th>";
    }
    echo "</tr>";
    while ($row = OCI_Fetch_Array($resultFromSQL, OCI_BOTH)) {
        echo "<tr>";
        $string = "";
        // iterates through the results returned from SQL query and
        // creates the contents of the table
        for ($i = 0; $i < sizeof($namesOfColumnsArray); $i++) {
            $string .= "<td>" . $row["$i"] . "</td>";
        }
        echo $string;
        echo "</tr>";
    }
    echo "</table>";
}
// JC: test function, to remove...
function testfun1($x, $y) {
    return array("val1", "val2", "val3");
}
function populateDb() {
    executePlainSQL("DROP TABLE Patient CASCADE CONSTRAINTS");
    executePlainSQL("CREATE TABLE Patient(
        id INTEGER PRIMARY KEY,
        care_card_num CHAR(50) NOT NULL UNIQUE,
        name CHAR(50) NOT NULL,
        age INTEGER,
        address CHAR(50) NOT NULL,
        phone CHAR(50) NOT NULL,
        emergency_contact_num CHAR(50) NOT NULL,
        UNIQUE(name, phone))"
    );
    executeMultipleSqlCommands(array(
        "INSERT INTO Patient
        VALUES (100, '9999 212 909', 'John Hanks', 35, '1234 Robson St, Vancouver, BC V7Y 0A2', '778 909 1232',
        '604 211 2211')",
        "INSERT INTO Patient
        VALUES (101, '9000 788 500', 'Emily Brown', 60, '1000 Mathers Ave, West Vancouver, BC V7V 2G7', '778
        398 2233', '778 888 3910')",
        "INSERT INTO Patient
        VALUES (102, '9899 255 444', 'Tommy Lee', 12, '6400 Hawke Ave, Vancouver, BC V6R 2C9', '778 556
        0000', '604 234 9190')",
        "INSERT INTO Patient
        VALUES (103, '9989 299 144', 'Michelle Smith', 55, '1011 Richards St, Vancouver, BC V7B 0A2', '604 123
        5577', '604 778 2332')",
        "INSERT INTO Patient
        VALUES (104, '9123 098 230', 'Jill Garcia', 78, '5000 Main St, Vancouver, BC V6B 1A9', '778 387 5321',
        '604 239 8109')"
    ));
    executePlainSQL("DROP TABLE Disease CASCADE CONSTRAINTS");
    executePlainSQL("CREATE TABLE Disease(name CHAR(50) PRIMARY KEY)");
    executeMultipleSqlCommands(array(
        "INSERT INTO Disease VALUES ('Alzheimers Disease')",
        "INSERT INTO Disease VALUES ('Type I Diabetes')",
        "INSERT INTO Disease VALUES ('Cardiovascular Disease')",
        "INSERT INTO Disease VALUES ('Liver Cancer')",
        "INSERT INTO Disease VALUES ('Chickenpox')",
        "INSERT INTO Disease VALUES ('Mental Illness')",
        "INSERT INTO Disease VALUES ('Liver Cancer Stage 2')"
    ));
    executePlainSQL("DROP TABLE Has_Disease CASCADE CONSTRAINTS");
    executePlainSQL("CREATE TABLE Has_Disease(
        disease_name CHAR(50),
        cured CHAR(1) NOT NULL,
        patient_id INTEGER,
        PRIMARY KEY(disease_name, patient_id),
        FOREIGN KEY(patient_id) REFERENCES Patient(id) ON DELETE CASCADE,
        FOREIGN KEY(disease_name) REFERENCES Disease(name) ON DELETE CASCADE
        )");
    executeMultipleSqlCommands(array(
        "INSERT INTO Has_Disease VALUES('Liver Cancer', '0', 100)", 
        "INSERT INTO Has_Disease VALUES('Cardiovascular Disease', '0', 101)", 
        "INSERT INTO Has_Disease VALUES('Chickenpox', '0', 102)", 
        "INSERT INTO Has_Disease VALUES('Type I Diabetes', '0', 103)",
        "INSERT INTO Has_Disease VALUES('Type I Diabetes', '0', 100)", 
        "INSERT INTO Has_Disease VALUES('Alzheimers Disease', '0', 104)"
        )
    );
    executePlainSQL("DROP TABLE Doctor CASCADE CONSTRAINTS");
    executePlainSQL("CREATE TABLE Doctor (
        id INTEGER PRIMARY KEY,
        name CHAR(50) NOT NULL,
        phone CHAR(50) NOT NULL,
        address CHAR(50),
        specialization CHAR(50) NOT NULL,
        department CHAR(50),
        UNIQUE(name, phone))"
    );
    executeMultipleSqlCommands(array(
        "INSERT INTO Doctor
        VALUES (1000, 'Jake Holt', '778 290 4839', '5948 Granville St, Vancouver, BC V4D 1R2', 'Cardiovascular
        Disease', 'Cardiology')",
        "INSERT INTO Doctor
        VALUES (1001, 'Rachel Wilkins', '604 129 8109', '1239 Apple St, Vancouver, BC V5A 1Z2', 'Liver Cancer',
        'Oncology')",
        "INSERT INTO Doctor
        VALUES (1002, 'Billy Yang', '604 120 2984', '9928 Davie St, Vancouver, BC V6B 1R3', 'Type I Diabetes',
        'Nutrition and Dietetics')",
        "INSERT INTO Doctor
        VALUES (1003, 'Amy Whittle', '778 109 2491', '5819 Graham St, Vancouver, BC V9A 1B6', 'Chickenpox',
        'Infection Control')",
        "INSERT INTO Doctor
        VALUES (1004, 'Tim Watsons', '778 129 8419', '1209 Renfrew St, Vancouver, BC V1T 1S3', 'Alzheimers
        Disease', 'Elderly Services')"
    ));
    executePlainSQL("DROP TABLE Nurse CASCADE CONSTRAINTS");
    executePlainSQL("CREATE TABLE Nurse (
        id INTEGER PRIMARY KEY,
        name CHAR(50) NOT NULL,
        phone CHAR(50) NOT NULL,
        address CHAR(50),
        department CHAR(50),
        UNIQUE(name, phone))"
    );
    executeMultipleSqlCommands(array(
        "INSERT INTO Nurse
        VALUES (3000, 'Arthur Davila', '778 333 8898', '1209 Hawke Ave, Vancouver, BC V6R 2C9', 'Cardiology')",
        "INSERT INTO Nurse
        VALUES (3001, 'Susan Lovell', '604 239 8849', '2219 Hastings St, Vancouver, BC V2A 1B2', 'Oncology')",
        "INSERT INTO Nurse
        VALUES (3002, 'Harry Torres', '604 709 2293', '9089 Hazelbridge Way St, Vancouver, BC V6X 4J7', 'Oncology')",
        "INSERT INTO Nurse
        VALUES (3003, 'Shakir Leblanc', '778 120 9482', '2309 Main St, Vancouver, BC V6B 1A9', 'Oncology')",
        "INSERT INTO Nurse
        VALUES (3004, 'Aubrey Mitchell', '778 435 0921', '1209 Apple St, Vancouver, BC V5A 1Z2', 'Cardiology')"
    ));
    executePlainSQL("DROP TABLE Room CASCADE CONSTRAINTS");
    executePlainSQL("CREATE TABLE Room (
        room_type CHAR(50) NOT NULL,
        department CHAR(50),
        room_number INTEGER,
        available CHAR(1) NOT NULL,
        PRIMARY KEY (department, room_number))"
    );
    executeMultipleSqlCommands(array(
        "INSERT INTO Room
        VALUES ('Surgery Room', 'Cardiology', 100, '0')",
        "INSERT INTO Room
        VALUES ('Meeting Room', 'Cardiology', 110, '1')",
        "INSERT INTO Room
        VALUES ('Surgery Room', 'Oncology', 200,'0')",
        "INSERT INTO Room
        VALUES ('Meeting Room', 'Oncology', 210, '1')",
        "INSERT INTO Room
        VALUES ('Meeting room', 'Nutrition and Dietetics', 300, '1')",
        "INSERT INTO Room
        VALUES ('Meeting room', 'Elderly Services', 400, '1')",
        "INSERT INTO Room
        VALUES ('Meeting room', 'Infection Control', 500, '1')"
    ));
    executePlainSQL("DROP TABLE AssignTo CASCADE CONSTRAINTS");
    executePlainSQL("CREATE TABLE AssignTo (
        staff_id INTEGER, 
        room_department CHAR(50), 
        room_number INTEGER,
        PRIMARY KEY (staff_id, room_department, room_number),
        FOREIGN KEY (staff_id) REFERENCES Nurse(id) ON DELETE CASCADE, 
        FOREIGN KEY (room_department, room_number) REFERENCES Room (department, room_number) ON DELETE CASCADE)"
    );
    executeMultipleSqlCommands(array(
        "INSERT INTO AssignTo
        VALUES (3000, 'Cardiology', 100)",
        "INSERT INTO AssignTo
        VALUES (3001, 'Oncology',200)",
        "INSERT INTO AssignTo
        VALUES (3002, 'Oncology', 200)",
        "INSERT INTO AssignTo
        VALUES (3003, 'Oncology', 200)",
        "INSERT INTO AssignTo
        VALUES (3004, 'Cardiology', 100)"
    ));
    executePlainSQL("DROP TABLE Appointment CASCADE CONSTRAINTS");
    executePlainSQL("CREATE TABLE Appointment(
        patient_id INTEGER,
        doctor_id INTEGER,
        room_dept CHAR(50),
        room_num INTEGER,
        start_date_time DATE NOT NULL,
        end_date_time DATE NOT NULL,
        PRIMARY KEY(patient_id, doctor_id, room_dept, room_num, start_date_time, end_date_time),
        FOREIGN KEY(patient_id) REFERENCES Patient(id) ON DELETE CASCADE,
        FOREIGN KEY(doctor_id) REFERENCES Doctor(id) ON DELETE CASCADE,
        FOREIGN KEY(room_dept, room_num) REFERENCES Room(department, room_number) ON
        DELETE CASCADE)"
    );
    executeMultipleSqlCommands(array(
        "INSERT INTO Appointment
        VALUES (100, 1001, 'Oncology', 210, TO_DATE ('2019-03-11 12:30:00', 'yyyy/mm/dd hh24:mi:ss'),
        TO_DATE('2019-03-11 13:30:00', 'yyyy/mm/dd hh24:mi:ss'))",
        "INSERT INTO Appointment
        VALUES (100, 1001, 'Oncology', 210, TO_DATE ('2019-03-12 12:30:00', 'yyyy/mm/dd hh24:mi:ss'),
        TO_DATE('2019-03-12 13:30:00', 'yyyy/mm/dd hh24:mi:ss'))",
        "INSERT INTO Appointment
        VALUES (100, 1002, 'Nutrition and Dietetics', 300, TO_DATE ('2019-11-10 8:30:00', 'yyyy/mm/dd hh24:mi:ss'),
        TO_DATE('2019-11-10 9:30:00', 'yyyy/mm/dd hh24:mi:ss'))",
        "INSERT INTO Appointment
        VALUES (100, 1001, 'Oncology', 210, TO_DATE ('2019-07-30 11:30:00', 'yyyy/mm/dd hh24:mi:ss'),
        TO_DATE('2019-07-30 12:30:00', 'yyyy/mm/dd hh24:mi:ss'))",
        "INSERT INTO Appointment
        VALUES (101, 1000, 'Cardiology', 110, TO_DATE('2019-04-01 15:30:00', 'yyyy/mm/dd hh24:mi:ss'),
        TO_DATE('2019-04-01 16:30:00', 'yyyy/mm/dd hh24:mi:ss'))",
        "INSERT INTO Appointment
        VALUES (102, 1003, 'Infection Control', 500, TO_DATE('2019-02-11 12:30:00', 'yyyy/mm/dd hh24:mi:ss'),
        TO_DATE('2019-02-11 13:30:00', 'yyyy/mm/dd hh24:mi:ss'))",
        "INSERT INTO Appointment
        VALUES (103, 1002, 'Nutrition and Dietetics', 300, TO_DATE ('2019-05-20 12:00:00', 'yyyy/mm/dd
        hh24:mi:ss'), TO_DATE('2019-05-20 12:30:00', 'yyyy/mm/dd hh24:mi:ss'))",
        "INSERT INTO Appointment
        VALUES (104, 1004, 'Elderly Services', 400, TO_DATE('2019-05-20 14:30:00', 'yyyy/mm/dd hh24:mi:ss'),
        TO_DATE('2019-05-20 15:30:00', 'yyyy/mm/dd hh24:mi:ss'))"
    ));
    executePlainSQL("DROP TABLE Equipment1 CASCADE CONSTRAINTS");
    executePlainSQL("CREATE TABLE Equipment1(
        name CHAR(50) PRIMARY KEY,
        usage CHAR(50))");
    executeMultipleSqlCommands(array(
        "INSERT INTO Equipment1
        VALUES ('EKG Machine', 'Measures electrical activity of heart')",
        "INSERT INTO Equipment1
        VALUES ('Stress Testing Machine', 'Monitors heart rate during exercise')",
        "INSERT INTO Equipment1
        VALUES ('Radiation Delivery Machines', 'Cancer treatment')",
        "INSERT INTO Equipment1
        VALUES ('Blood Glucose Meter', 'Measures amount of glucose in blood')",
        "INSERT INTO Equipment1
        VALUES ('Insulin Pumps', 'Used for type I diabetes')",
        "INSERT INTO Equipment1
        VALUES ('MRI Machine', 'Used for brain scans')",
        "INSERT INTO Equipment1
        VALUES ('X-Ray Machine', 'Used for bone imaging')"
    ));
    executePlainSQL("DROP TABLE Equipment2 CASCADE CONSTRAINTS");
    executePlainSQL("CREATE TABLE Equipment2(
        name CHAR(50),
        brand CHAR(50),
        manufactured_in CHAR(50),
        PRIMARY KEY (name, brand),
        FOREIGN KEY (name) REFERENCES Equipment1(name))");
    executeMultipleSqlCommands(array(
        "INSERT INTO Equipment2
        VALUES ('EKG Machine', 'Bionet', 'USA')",
        "INSERT INTO Equipment2
        VALUES ('Stress Testing Machine','Welch Allyn', 'Germany')",
        "INSERT INTO Equipment2
        VALUES ('Radiation Delivery Machines', 'TrueBeam', 'Australia')",
        "INSERT INTO Equipment2
        VALUES ('Blood Glucose Meter', 'Accu-Chek', 'USA')",
        "INSERT INTO Equipment2
        VALUES ('Insulin Pumps', 'Medtronic', 'Japan')",
        "INSERT INTO Equipment2
        VALUES ('MRI Machine', 'MedFirst', 'Korea')",
        "INSERT INTO Equipment2
        VALUES ('X-Ray Machine', 'Radiant Medical', 'Canada')"
    ));
    executePlainSQL("DROP TABLE Equipment3 CASCADE CONSTRAINTS");
    executePlainSQL("CREATE TABLE Equipment3(
        brand CHAR(50) PRIMARY KEY,
        customer_support_number CHAR(50))");
    executeMultipleSqlCommands(array(
       "INSERT INTO Equipment3
        VALUES ('Bionet', '778 129 8948')",
        "INSERT INTO Equipment3
        VALUES ('Welch Allyn', '778 290 4823')",
        "INSERT INTO Equipment3
        VALUES ('TrueBeam', '778 520 9481')",
        "INSERT INTO Equipment3
        VALUES ('Accu-Chek', '778 320 9482')",
        "INSERT INTO Equipment3
        VALUES ('Medtronic', '778 998 2300')",
        "INSERT INTO Equipment3
        VALUES ('MedFirst', '778 664 2353')",
        "INSERT INTO Equipment3
        VALUES ('Radiant Medical', '1800 598 2322')"
    ));
    executePlainSQL("DROP TABLE Equipment CASCADE CONSTRAINTS");
    executePlainSQL("CREATE TABLE Equipment (
        id INTEGER PRIMARY KEY,
        name CHAR(50) NOT NULL,
        brand CHAR(50) NOT NULL,
        purchase_date DATE,
        price REAL,
        FOREIGN KEY (brand) REFERENCES Equipment3(brand),
        FOREIGN KEY (name, brand) REFERENCES Equipment2(name, brand),
        FOREIGN KEY (name) REFERENCES Equipment1(name))"
    );
    executeMultipleSqlCommands(array(
        "INSERT INTO Equipment
        VALUES (1000, 'EKG Machine', 'Bionet', DATE '2017-01-02', 3000)",
        "INSERT INTO Equipment
        VALUES (1001, 'Stress Testing Machine', 'Welch Allyn', DATE '2016-10-11', 24000)",
        "INSERT INTO Equipment
        VALUES (1002, 'Radiation Delivery Machines', 'TrueBeam', DATE '2015-04-22', 750000)",
        "INSERT INTO Equipment
        VALUES (1003, 'Blood Glucose Meter', 'Accu-Chek', DATE '2015-03-20', 100)",
        "INSERT INTO Equipment
        VALUES (1004, 'Insulin Pumps', 'Medtronic', DATE '2016-07-08', 4500)",
        "INSERT INTO Equipment
        VALUES (1005, 'MRI Machine', 'MedFirst', DATE '2015-07-01', 150000)",
        "INSERT INTO Equipment
        VALUES (1006, 'X-Ray Machine', 'Radiant Medical', DATE '2011-01-08', 79599)"
    ));
    executePlainSQL("DROP TABLE LocatedAt CASCADE CONSTRAINTS");
    executePlainSQL("CREATE TABLE LocatedAt (
        room_department CHAR(50),
        room_number INTEGER,
        equipment_id INTEGER,
        PRIMARY KEY (room_department, room_number, equipment_id),
        FOREIGN KEY (equipment_id) REFERENCES Equipment(id) ON DELETE CASCADE,
        FOREIGN KEY (room_department, room_number) REFERENCES Room(department,
        room_number) ON DELETE CASCADE)");
    executeMultipleSqlCommands(array(
        "INSERT INTO LocatedAt
        VALUES ('Cardiology', 100, 1000)",
        "INSERT INTO LocatedAt
        VALUES ('Cardiology', 100, 1001)",
        "INSERT INTO LocatedAt
        VALUES ('Oncology', 200, 1002)",
        "INSERT INTO LocatedAt
        VALUES ('Oncology', 200, 1003)",
        "INSERT INTO LocatedAt
        VALUES ('Oncology', 200, 1004)",
        "INSERT INTO LocatedAt
        VALUES ('Oncology', 210, 1004)",
        "INSERT INTO LocatedAt
        VALUES ('Oncology', 210, 1005)",
        "INSERT INTO LocatedAt
        VALUES ('Oncology', 210, 1006)",
        "INSERT INTO LocatedAt
        VALUES ('Nutrition and Dietetics', 300, 1003)"
    ));
    executePlainSQL("DROP TABLE Treatment_History CASCADE CONSTRAINTS");
    executePlainSQL("CREATE TABLE Treatment_History (
        id INTEGER PRIMARY KEY,
        treatment_date DATE,
        medical_notes CHAR(50),
        patient_id INTEGER NOT NULL,
        FOREIGN KEY (patient_id) REFERENCES Patient(id) ON DELETE CASCADE)");
    executeMultipleSqlCommands(array(
        "INSERT INTO Treatment_History
        VALUES (1, DATE '2019-02-01', 'Patient had chemotherapy', 100)",
        "INSERT INTO Treatment_History
        VALUES (6, DATE '2019-02-15', 'Patient had surgery to remove tumour', 100)",
        "INSERT INTO Treatment_History
        VALUES (7, DATE '2019-03-30', 'Patient came for monthly cancer relapse checkup', 100)",
        "INSERT INTO Treatment_History
        VALUES (2, DATE '2019-01-10', 'Prescribed medications for cardiovascular disease', 101)",
        "INSERT INTO Treatment_History
        VALUES (3, DATE '2019-01-15', 'Prescribed antibiotics for chickenpox', 102)",
        "INSERT INTO Treatment_History
        VALUES (4, DATE '2019-02-03', 'Treated with insulin', 103)",
        "INSERT INTO Treatment_History
        VALUES (5, DATE '2019-02-05', 'Prescribed with Razadyne', 104)"
    ));
    executePlainSQL("DROP TABLE Prescription1 CASCADE CONSTRAINTS");
    executePlainSQL("CREATE TABLE Prescription1 (
        drug_name CHAR(50),
        total_amount INTEGER,
        price REAL,
        PRIMARY KEY (drug_name, total_amount))");
    executeMultipleSqlCommands(array(
        "INSERT INTO Prescription1
        VALUES ('Ranitidine', 90, 200)",
        "INSERT INTO Prescription1
        VALUES ('Benazepril', 30, 300)",
        "INSERT INTO Prescription1
        VALUES ('Zovirax', 45, 100)",
        "INSERT INTO Prescription1
        VALUES ('Insulin glulisine', 600, 250)",
        "INSERT INTO Prescription1
        VALUES ('Razadyne', 300, 150)"
    ));
    executePlainSQL("DROP TABLE Prescription2 CASCADE CONSTRAINTS");
    executePlainSQL("CREATE TABLE Prescription2 (
        dosage INTEGER,
        duration_days INTEGER,
        total_amount INTEGER,
        PRIMARY KEY (dosage, duration_days))");
    executeMultipleSqlCommands(array(
        "INSERT INTO Prescription2
        VALUES (3, 30, 90)",
        "INSERT INTO Prescription2
        VALUES (1, 30, 30)",
        "INSERT INTO Prescription2
        VALUES (3, 15, 45)",
        "INSERT INTO Prescription2
        VALUES (30, 20, 600)",
        "INSERT INTO Prescription2
        VALUES (10, 30, 300)"
    ));
    executePlainSQL("DROP TABLE Prescription CASCADE CONSTRAINTS");
    executePlainSQL("CREATE TABLE Prescription (
        drug_name CHAR(50),
        refills INTEGER,
        dosage INTEGER,
        duration_days INTEGER,
        treatment_history_id INTEGER NOT NULL,
        PRIMARY KEY (drug_name, treatment_history_id),
        FOREIGN KEY (dosage, duration_days) REFERENCES Prescription2(dosage, duration_days),
        FOREIGN KEY (treatment_history_id) REFERENCES Treatment_History(id))");
    executeMultipleSqlCommands(array(
        "INSERT INTO Prescription
        VALUES ('Ranitidine', 0, 3, 30, 1)",
        "INSERT INTO Prescription
        VALUES ('Benazepril', 5, 1, 30, 1)",
        "INSERT INTO Prescription
        VALUES ('Zovirax', 0, 3, 15, 2)",
        "INSERT INTO Prescription
        VALUES ('Insulin glulisine', 2, 30, 20, 3)",
        "INSERT INTO Prescription
        VALUES ('Razadyne', 0, 10, 30, 4)"
    ));
}
?>