<?php
function dbConnect() {
	// NOTE: Change DB information to your own
	return OCILogon("ora_n0l1b", "a47141106", "dbhost.ugrad.cs.ubc.ca:1522/ug");
}
function dbLogout($db_conn) {
	OCILogoff($db_conn);
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
?>