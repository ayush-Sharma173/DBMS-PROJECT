<!DOCTYPE html>
<html>
<head>
	<title>Job Listings</title>
	<style>
		body {
			font-family: Arial, sans-serif;
			padding: 0px;
			margin: 0px;
		}
		h1 {
			text-align: center;
		}
		table {
			border-collapse: collapse;
			width: 100%;
			margin-top: 20px;
		}
		th, td {
			text-align: left;
			padding: 8px;
			border-bottom: 1px solid #ddd;
		}
		th {
			background-color: #4CAF50;
			color: white;
		}
		tr:nth-child(even) {
			background-color: #f2f2f2;
		}
		tr:hover {
			background-color: #ddd;
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

		

		
		body {
			font-family: Arial, sans-serif;
			padding: 0px;
			margin: 0px;
		}
		h1 {
			text-align: center;
		}
		table {
			border-collapse: collapse;
			width: 100%;
			margin-top: 20px;
			background-color: #fff;
			box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
		}
		th, td {
			text-align: left;
			padding: 8px;
			border-bottom: 1px solid #ddd;
		}
		th {
			background-color: #4CAF50;
			color: white;
			font-weight: bold;
			text-transform: uppercase;
		}
		tr:nth-child(even) {
			background-color: #f2f2f2;
		}
		tr:hover {
			background-color: #ddd;
		}
	</style>
</head>
<body>
	<nav>
		<a href="CompanyHome.php">Home</a>
		<a href="CompanyProfile.php">Profile</a>
		<a href="AddJobListing.php">Add a Job Listing</a>
		<a href="CompaniesJobList.php">Listed Jobs</a>
		<a href="Company_RegisteredStudents.php">Students Registered</a>
		<a href="logout.php" style="float: right; background-color: red;">Logout</a>

	</nav>

	<h1>Your Jobs List</h1> 

	<table>
		<thead>
			<tr>
				<th>Company Details</th>
				<th>role</th>
				<th>min_qualification</th>
				<th>marks_criteria</th>
				<th>salary_package</th>
				<th>interview_mode</th>
			</tr>
		</thead>
		<tbody>
			
			<?php
				// Connect to MySQL database
				$servername = "localhost";
				$username = "root";
				$password = "password123";
				$dbname = "minipro";

				$conn = mysqli_connect($servername, $username, $password, $dbname);
				if (!$conn) {
					die("Connection failed: " . mysqli_connect_error());
				}
				session_start();
				$email = $_SESSION['sess_user'];
				if(!isset($_SESSION['sess_user'])){
					header('Location: login.php');
				}
              
				// Fetch data from MySQL table
				$sql = "SELECT * FROM job_details where company_email = '$email'";
				$result = mysqli_query($conn, $sql);

				// Display data row wise
				if (mysqli_num_rows($result) > 0) {
					while($row = mysqli_fetch_assoc($result)) {
						echo "<tr>";
						echo "<td>" . $row["company_name"] . "</td>";
						echo "<td>" . $row["role"] . "</td>";
						echo "<td>" . $row["min_qualification"] . "</td>";
                        echo "<td>" . $row["marks_criteria"] . "</td>";
                        echo "<td>" . $row["salary_package"] . "</td>";
                        echo "<td>" . $row["interview_mode"] . "</td>";
						echo "</tr>";
					}
				} else {
					echo "<tr><td colspan='3'>You have no job listed</td></tr>";
				} 
                
				
				// Close MySQL connection
				mysqli_close($conn);
			?>

			
		</tbody>
	</table>


</body>
</html>
