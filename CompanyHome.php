<!DOCTYPE html>
<html>
<head>
	<title>Navigation Bar Example</title>
	<style>
		.watermark-container {
  position: relative;
}



		body {
			font-family: Arial, sans-serif;
			margin: 0px;
			padding: 0px;
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
        a{
            display: block;
            text-decoration: none;
        }
	</style>
</head>

<body>
<?php 
    // Connect to the MySQL database
	ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);

    // Connect to the MySQL database
    $host = 'localhost';
    $user = 'root';
    $password = 'password123';
    $dbname = 'minipro';
      
      	$conn = mysqli_connect("localhost", "root", "password123", "minipro");
	session_start();

	$email = $_SESSION['sess_user'];
	  if(!isset($_SESSION['sess_user'])){
		header('Location: login.php');
	}
	$result = mysqli_query($conn, "select * from company_users where email = '$email'"); 
	$row = mysqli_fetch_array($result);
	$name = $row["name"];
?>
	<nav>
	    <a href="CompanyHome.php">Home</a>
		<a href="CompanyProfile.php">Profile</a>
		<a href="AddJobListing.php">Add a Job Listing</a>
		<a href="CompaniesJobList.php">Listed Jobs</a>
		<a href="Company_RegisteredStudents.php">Students Registered</a>
		<a href="logout.php" style="float: right; background-color: red;">Logout</a>

	</nav>

	<div>
		<h1>Welcome : <?php echo $name ; ?></h1>
        
	</div>
</body>
</html>
