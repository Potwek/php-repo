<?php
//register.php
//Inserts new student record to tbl_students table in newbies_db database.
	include("./SQLConnect.php");
	echo"<pre>";
	print_r($_POST);
	echo"</pre>";
	
	$query = mysqli_query($con,"INSERT INTO tbl_students (stud_ID, lastName, firstName, MI,course,yearlevel) VALUES ('$_POST[stud_ID]','$_POST[lastName]','$_POST[firstName]','$_POST[MI]','$_POST[course]','$_POST[yearLevel]')") or die(mysql_error());
	if(!$query){
		echo "Alert! Student not added.";
	}
	else{
		echo "Student successfully added!";
	}
	
	echo "<a href='./index.php'><input type='button' value='Back'/></a>";
	
?>