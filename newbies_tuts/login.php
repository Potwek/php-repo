<?php
// login_user.php
// Secure user login with password verification

// Initialize the session
session_start();

// Check if user is already logged in, with proper session initialization check
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    // Redirect to welcome page according to user level
    if(isset($_SESSION["user_level"]) && $_SESSION["user_level"] === "Admin") {
        header("location: Admin-home.php");
    } else {
        header("location: User-home.php");
    }
    exit;
}

// Include database connection file
include("SQLConnect.php");

// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = $login_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["btn_login"])) {
    
    // Check if username is empty
    if(empty(trim($_POST["username"]))) {
        $username_err = "Please enter username.";
    } else {
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)) {
        // First check in tbl_users (new secure user table)
        $sql = "SELECT id, username, password, email, user_level FROM tbl_users WHERE username = ?";
        
        if($stmt = mysqli_prepare($con, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)) {
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1) {                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password, $email, $user_level);
                    if(mysqli_stmt_fetch($stmt)) {
                        if(password_verify($password, $hashed_password)) {
                            // Password is correct, store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;
                            $_SESSION["email"] = $email;
                            $_SESSION["user_level"] = $user_level;
                            
                            // Redirect user to appropriate home page
                            if($user_level === "Admin") {
                                header("location: Admin-home.php");
                            } else {
                                header("location: User-home.php");
                            }
                        } else {
                            // Password is not valid
                            $login_err = "Invalid username or password.";
                        }
                    }
                } else {
                    // Fallback to old login system (tbl_students) for backward compatibility
                    $query = mysqli_query($con, "SELECT stud_ID, lastName, user_level FROM tbl_students WHERE stud_ID='$username'") 
                             or die(mysqli_error($con));
                    
                    if(mysqli_num_rows($query) > 0) {
                        $row = mysqli_fetch_array($query, MYSQLI_ASSOC);
                        
                        if($row['lastName'] == $password) {
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $row['stud_ID'];
                            $_SESSION["username"] = $row['stud_ID'];
                            $_SESSION["user_level"] = $row['user_level'] ?? "User";
                            
                            // Redirect user to appropriate home page
                            if($row['user_level'] === "Admin") {
                                header("location: Admin-home.php");
                            } else {
                                header("location: User-home.php");
                            }
                        } else {
                            $login_err = "Invalid username or password.";
                        }
                    } else {
                        $login_err = "Invalid username or password.";
                    }
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #dddeee; padding: 20px; }
        .wrapper { max-width: 400px; margin: 0 auto; background: white; padding: 20px; border-radius: 5px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        h2 { text-align: center; color: #333; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; }
        input[type="text"], input[type="password"] { width: 100%; padding: 8px; box-sizing: border-box; border: 1px solid #ddd; border-radius: 3px; }
        .btn { display: block; width: 100%; padding: 10px; background-color: green; color: white; border: none; border-radius: 3px; cursor: pointer; }
        .btn:hover { background-color: darkgreen; }
        .help-block { color: red; font-size: 0.9em; }
        .alert { padding: 15px; margin-bottom: 20px; border: 1px solid transparent; border-radius: 4px; color: #721c24; background-color: #f8d7da; border-color: #f5c6cb; }
        .register-link { text-align: center; margin-top: 15px; }
        .register-link a { color: green; text-decoration: none; }
        .register-link a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Login</h2>
        
        <?php 
        if(!empty($login_err)){
            echo '<div class="alert">' . $login_err . '</div>';
        }        
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Username</label>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="password" class="form-control">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn" name="btn_login" value="Login">
            </div>
            <p class="register-link">Don't have an account? <a href="register_user.php">Sign up now</a>.</p>
        </form>
    </div>
</body>
</html>