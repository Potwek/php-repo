<?php
//edit.php
include("./SQLConnect.php");

// Check if form was submitted for updating
if(isset($_POST['btn_update'])) {
    // Update the student record
    $query = mysqli_query($con, "UPDATE tbl_students SET 
        lastName = '".$_POST['lastName']."',
        firstName = '".$_POST['firstName']."',
        MI = '".$_POST['MI']."',
        course = '".$_POST['course']."',
        yearLevel = '".$_POST['yearLevel']."'
        WHERE stud_ID = '".$_POST['stud_ID']."'") 
        or die(mysqli_error($con));
    
    if(!$query) {
        echo "Record update failed!";
    } else {
        echo "Record successfully updated!";
        // Redirect to index page after short delay
        echo "<script>
                setTimeout(function() {
                    window.location.href = '../index.php';
                }, 2000);
              </script>";
    }
}
// If ID is in URL, fetch the record to edit
else if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = mysqli_query($con, "SELECT * FROM tbl_students WHERE stud_ID = '$id'") or die(mysqli_error($con));
    $row = mysqli_fetch_array($query, MYSQLI_ASSOC);
    
    if($row) {
        // Display edit form with current values
        ?>
        <html>
        <head>
            <title>Edit Student Record</title>
            <style>
                body { font-family: Arial, sans-serif; background-color: #dddeee; padding: 20px; }
                form { max-width: 500px; margin: 0 auto; background: white; padding: 20px; border-radius: 5px; }
                input[type="text"] { width: 100%; padding: 8px; margin: 5px 0; box-sizing: border-box; }
                input[type="submit"], input[type="button"] { padding: 10px; background-color: green; color: white; border: none; cursor: pointer; margin-right: 10px; }
                input[type="button"] { background-color: #555; }
                h2 { text-align: center; }
            </style>
        </head>
        <body>
            <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <h2>Edit Student Record</h2>
                <input type="hidden" name="stud_ID" value="<?php echo $row['stud_ID']; ?>">
                
                <label for="firstName">First Name:</label>
                <input type="text" name="firstName" value="<?php echo $row['firstName']; ?>" required>
                
                <label for="lastName">Last Name:</label>
                <input type="text" name="lastName" value="<?php echo $row['lastName']; ?>" required>
                
                <label for="MI">Middle Initial:</label>
                <input type="text" name="MI" value="<?php echo $row['MI']; ?>">
                
                <label for="course">Course:</label>
                <input type="text" name="course" value="<?php echo $row['course']; ?>" required>
                
                <label for="yearLevel">Year Level:</label>
                <input type="text" name="yearLevel" value="<?php echo $row['yearLevel']; ?>" required>
                
                <div style="margin-top: 20px;">
                    <input type="submit" name="btn_update" value="Update">
                    <a href="../index.php"><input type="button" value="Cancel"></a>
                </div>
            </form>
        </body>
        </html>
        <?php
    } else {
        echo "Student record not found!";
        echo "<br><a href='../index.php'><input type='button' value='Back'/></a>";
    }
} else {
    // No ID provided
    echo "No student ID specified for editing.";
    echo "<br><a href='../index.php'><input type='button' value='Back'/></a>";
}
?>