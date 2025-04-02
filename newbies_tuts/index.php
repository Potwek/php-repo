<html>
<head>
	
	<style>
		a{color:#fff;}
		a:hover{background-color:yellow; color:black;}
	</style>
</head>
<body bgcolor="#dddeee">
<?php include("./SQLConnect.php");?>
	<?php 
		// echo "<strong>Printing in PHP</strong><br>";
		// echo "Hello! This is my body.<br>"; 
		// echo "Hello! This is my body.<br>"; 
		// echo "Hello! This is my body.<br>"; 
		// echo "Hello! This is my body.<br>"; 
		// echo "Hello! This is my body.<br><br>";


		// echo "<strong>Variables in PHP</strong><br>";
		
			// $var1 = '"I am a string!"';
			// $var2 =	125;
			// $var3 =	4999.99;
			
			// echo "<br>String:".$var1;
			// echo "<br>Integer:".$var2;
			// echo "<br>Float:".$var3;
			
		// echo "<br><strong>Operators in PHP</strong><br>";
		
			//Initialize variables
			// $op1=5; $op2=25;
			
		//Operations
		// echo "<strong>Addition</strong><br>";
		// echo "Sum: ".$op1 + $op2."<br>";
		// echo "<strong>subtraction</strong><br>";
		// echo "Difference:".$op1 - $op2."<br>";
		// echo "<strong>Multiplication</strong><br>";
		// echo "Product: ".$op1 * $op2."<br>";
		// echo "<strong>Division</strong><br>";
		// echo "Quotient: ".$op1 / $op2."<br>";		
		
			// $sum =0;
			// $sum = $op1 + $op2;
			// if($sum > 0){
				// echo"<br>The sum is positive";
			// }
			// else{
				// echo"<br>The sum is negative";
			// }
		
		// echo "<br><strong>Arrays in PHP</strong><br>";
		// $array = array(0=>"Edubas", 1=>"Milay", 2=>"Capirig", 3=>"Valcorza");
		
		
		// for($x=0; $x<4; $x++)
		// {
			// echo $array[$x]."<br>";
		// }
		// echo"--------------------------<br>";
		// $x=0;
		// while($x<4){
			// echo $array[$x]."<br>";
		// $x++;
		// }
		
		// foreach($array as $element){
		
			// echo $element;
		// }
		?>
		
		
<table border="1" width="120%">
<tr><td width="50%">
		<?php
		echo "<br>----------------------------------------------------------------------------------<br>";
		echo "Tutorial 1 PHP-MySQL (Fetching data from the database using SELECT statement)";
	
		//Fetch data from table (e.g. tbl_students)
		//Retrieve
		
		$query = mysqli_query($con,"SELECT * FROM tbl_students") or die(mysql_error());
		echo "<br  ><br>";
		
		echo "<table border='1' style='border-collapse:collapse;background-color:green; color:#fff;'>
				<th>Student ID</th>
				<th>Last Name</th>
				<th>First Name</th>
				<th>Middle Initial</th>
				<th>Course</th>
				<th>Year</th>
			 ";
		while($row = mysqli_fetch_array($query,MYSQLI_ASSOC)){
			echo "<tr>
					<td>$row[stud_ID]</td>
					<td>$row[lastName]</td>
					<td>$row[firstName]</td>
					<td>$row[MI]</td>
					<td>$row[course]</td>
					<td>$row[yearLevel]<br>
				  </tr>";
		}
		echo "</table>";
		
		echo "<br>----------------------------------------------------------------------------------<br>";
		echo "Tutorial 2 PHP-MySQL (Inserting data to the database using INSERT statement)";
	?>
	<form method="POST" action="register.php">	
		<table>
		<tr>
			<td><input type ="text" name="stud_ID" placeholder="Student ID"></td>
			<td><input type ="text" name="firstName" placeholder="First Name"></td>
			<td><input type ="text" name="lastName" placeholder="Last Name"></td>
			<td><input type ="text" name="MI" placeholder="Middle Initial"></td>
		</tr><tr>
			<td><input type ="text" name="course" placeholder="Course"></td>
			<td><input type ="text" name="yearLevel" placeholder="Year Level"></td>
			</tr><tr>
			<td colspan="4">
			<input type ="submit" name="btn_register" value="Register"/>
			</td>
		</tr>
		</table>
	</form>
	
	<?php 
		echo "<br>----------------------------------------------------------------------------------<br>";
		echo "Tutorial 3 PHP-MySQL (Deleting data to the database using DELETE and UPDATE statement)";
		echo "<br><br>";
		echo "<table border='1' style='border-collapse:collapse;background-color:green; color:#fff;'>
				<th>Student ID</th>
				<th>Last Name</th>
				<th>First Name</th>
				<th>Middle Initial</th>
				<th>Course</th>
				<th>Year</th>
				<th>Status</th>
				<th>Action</th>
			 ";
	$query1 = mysqli_query($con,"SELECT * FROM tbl_students") or die(mysql_error());
		while($row = mysqli_fetch_array($query1,MYSQLI_ASSOC)){
			echo "<tr>
					<td>$row[stud_ID]</td>
					<td>$row[lastName]</td>
					<td>$row[firstName]</td>
					<td>$row[MI]</td>
					<td>$row[course]</td>
					<td>$row[yearLevel]<br>
					<td>$row[status]</td>
					<td align='center'><a style='text-decoration:none;' href='delete.php/?id=$row[stud_ID]'>X</a></td>
					<td align='center'><a style='text-decoration:none;' href='edit.php/?id=$row[stud_ID]'>Edit</a></td>
				  </tr>";
		}
		echo "</table><br><br>"
	?>
</td><td valign="top">
	<?php //second column?>
	<form method="POST" action="login.php">
	<table align="center" style="padding-top:100px;">
		<tr><td>Username:</td><td><input type="text" name="uname"></td></tr>
		<tr><td>Password:</td><td><input type="text" name="pwd"></td></tr>
		<tr><td colspan="2" align="center"><input type="submit" name="btn_login" value="login"></td></tr>
	</table>
	</form>
	
	<table border="1" width="100%" height="500px">
		<tr>
			<td>
				<table>
					<tr>
					<?php
						$query2 = mysqli_query($con,"SELECT * FROM tbl_students") or die(mysql_error());
						while($row = mysqli_fetch_array($query2,MYSQLI_ASSOC)){
							echo "<td style='color:#fff;background-color:green;height:200px;width:200px;'>
										<img src='./imgs/Daniel_Padilla_at_Celebrate_Mega_in_Iceland_2016_(6).jpg' height='130px' width='150px'><br>
										ID: $row[stud_ID]<br>
										Lastname: $row[lastName]<br>
										firstname: $row[firstName]
								 </td>";
						}
					?>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</td></tr>
</table>
</body>
</html>
