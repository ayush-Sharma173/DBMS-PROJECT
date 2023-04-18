<?php
ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);

// Create a new MySQLi object and connect to the database
$mysqli = new mysqli('localhost', 'root', 'password123', 'minipro');

// Check for connection errors
if ($mysqli->connect_errno) {
    echo 'Failed to connect to MySQL: ' . $mysqli->connect_error;
    exit();
}
session_start();
    
    if(!isset($_SESSION['sess_user'])){
      header('Location: login.php');
    }
// Check if the form has been submitted
if (isset($_POST['submit'])) {
    // Retrieve the user input from the form
    $rollno = $_POST['rollno'];
    $company_name = $_POST['company_name'];
    $role = $_POST['role'];
    $Branch = $_POST['Branch'];
    $salary = $_POST['salary'];

    // Prepare the MySQL INSERT statement
    $stmt = $mysqli->prepare('INSERT INTO finalyPlaced (rollno, company_name, role,Branch,salary) VALUES (?, ?, ?, ?, ?)');

    // Bind the input parameters to the statement
    $stmt->bind_param('sssss', $rollno, $company_name, $role,$Branch,$salary);

    // Execute the statement
    if ($stmt->execute()) {
        echo '<div class="success-message">Record inserted successfully!</div>';
    } else {
        echo '<div class="error-message">Error inserting record: ' . $stmt->error . '</div>';
    }

    // Close the statement
    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Record to finalyPlaced Table</title>
    <style>
        * {
		margin: 0;
		padding: 0;
		font-family: 'Roboto', sans-serif;
	}


	nav {
			background-color: #333;
			color: #fff;
			overflow: hidden;
		}

		nav a {
			float: left;
			display: block;
			color: #fff;
			text-align: center;
			padding: 14px 16px;
			text-decoration: none;
		}

		nav a:hover {
			background-color: #ddd;
			color: #333;
		}


	button {
		background-color: #4CAF50;
		color: #fff;
		border: none;
		padding: 10px 20px;
		border-radius: 5px;
		font-size: 18px;
		margin-top: 20px;
	}
	
        body {
            background-color: #f5f5f5;
            font-family: Arial, sans-serif;
        }
        form {
            max-width: 500px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.3);
        }
        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }
        input[type="text"] {
            width: 96%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            margin-bottom: 20px;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: #fff;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
        }
        .success-message {
            color: green;
            margin-bottom: 20px;
        }
        .error-message {
            color: red;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<nav>
	<a href="http://localhost/minpro/coordinator_dashboard.php">HOME</a>
	<a href="http://localhost/minpro/addFinalyPlaced.php">ADD</a>
	    <a href="http://localhost/minpro/stats.php">stats</a>
		<a href="http://localhost/minpro/overview.php">overview</a>
		<a href="http://localhost/minpro/companywise.php">Company Wise</a>
		<a href="logout.php" style="float: right; background-color: red;">Logout</a>

	</nav>
    <h1>Add Data</h1>
    <form method="post">
        <label for="rollno">Roll No:</label>
        <input type="text" name="rollno" id="rollno" required>

        <label for="company_name">Company Name:</label>
        <input type="text" name="company_name" id="company_name" required>

        <label for="role">Role:</label>
        <input type="text" name="role" id="role" required>

        <label for="Branch">Branch:</label>
        <input type="text" name="Branch" id="Branch" required>

        <label for="role">Salary:</label>
        <input type="text" name="salary" id="salary" required>

        <input type="submit" name="submit" value="Add Record">
    </form>
</body>
</html>

