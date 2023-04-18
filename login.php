<?php
session_start(); // Start a session for storing user information

if(isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $user_type = $_POST['user_type'];

    // Connect to the MySQL database
    $conn = mysqli_connect("localhost", "root", "password123", "minipro");

    // Check if the connection was successful
    if(!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Prepare the SQL statement to select the user with the given email and password
    if($user_type == "admin") {
        $table_name = "coordinator_users";
    } elseif($user_type == "company") {
        $table_name = "company_users";
    } elseif($user_type == "student") {
        $table_name = "student_users";
    } elseif($user_type == "coordinator") {
        $table_name = "coordinator_users";
    }
    $sql = "SELECT * FROM $table_name WHERE email='$email' AND password='$password'";
    $result = mysqli_query($conn, $sql);

    // Check if a user was found with the given email and password
    if(mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        
        $_SESSION['type'] = $user_type;
        
        session_start();
        // Redirect the user to the appropriate dashboard based on their user type
        if($_SESSION['type'] == "admin") {
            $_SESSION['sess_user'] = $email;
            header("Location: terminal.php");
        } elseif($_SESSION['type'] == "company") {
            $_SESSION['sess_user'] = $email;
            header("Location: CompanyHome.php");
        } elseif($_SESSION['type'] == "student") {
            $student_id = $row['student_id'];
            $_SESSION['sess_user'] = $student_id;
            header("Location: student_dashboard.php");
        } elseif($_SESSION['type'] == "coordinator") {
            $_SESSION['sess_user'] = $email;
            header("Location: coordinator_dashboard.php");
        }
    } else {
        $error = "Invalid email or password";
        // If no user was found with the given email and password, display an error message
    }

    // Close the MySQL connection
    mysqli_close($conn);
}

if(isset($_POST['signup'])) {
    // Handle signup logic here
    // ...
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Login Page</title>
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script>

    </script>
    <style>
    h1 {
        font-size: 36px;
        color: #333;
        margin-bottom: 20px;
    }
    
    /* Add a background color and padding to the body */
    body {
        background-color: #f9f9f9;
        padding: 20px;
    }
    
    /* Increase the size of the card and add a drop shadow */
    .card {
        border: none;
        border-radius: 15px;
        box-shadow: 5px 5px 5px #4e73df;
        max-width: 500px;
        margin: 0 auto;
        background-color: #fff;
        padding: 30px;
    }

    /* Adjust the font size and color of the card header */
    .card-header {
        background-color: #f1f1f1;
        border-bottom: none;
        font-size: 24px;
        color: #333;
        text-align: center;
        padding: 10px 0;
        border-radius: 15px 15px 0 0;
    }
    .background {
        background-image: url("bg.webp");
        background-size: cover;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        opacity: 1;
        z-index: -1;
        transition: opacity 1s ease-in-out;
        }

    /* Adjust the font size and color of the input labels */
    label {
        font-size: 18px;
        color: #333;
    }

    /* Adjust the font size and color of the error message */
    .alert-danger {
        font-size: 16px;
        color: #721c24;
        background-color: #f8d7da;
        border-color: #f5c6cb;
        padding: 10px;
        margin-bottom: 20px;
        border-radius: 5px;
    }

    /* Add a hover effect to the Login button */
    .btn-primary:hover {
        background-color: #2e59d9;
        color: #fff;
    }

    /* Adjust the font size and color of the "Don't have an account?" message */
    p {
        font-size: 16px;
        color: #333;
        margin-top: 20px;
    }

    /* Add a hover effect to the "Sign up" link */
    a:hover {
        color: #2e59d9;
    }
</style>

</head>
<body class='background'>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3>Login</h3>
                    </div>
                    <div class="card-body">
                        <form method="post">
                            <div class="form-group">
                                <label>User Type</label>
                                <select name="user_type" class="form-control" required>
                                    <option value="">Select User Type</option>
                                    <option value="admin">Admin</option>
                                    <option value="company">Company</option>
                                    <option value="student">Student</option>
                                    <option value="coordinator">Coordinator</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            <?php if(isset($error)) { ?>
                            <div class="alert alert-danger">
                                <?php echo $error; ?>
                            </div>
                            <?php } ?>
                            <div class="form-group">
                                <button type="submit" name="submit" class="btn btn-primary">Login</button>
                            </div>
                        </form>
                        <hr>
                        <p>Don't have an account? <a href="sign_up.php">Sign up</a>.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

