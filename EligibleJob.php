	<!DOCTYPE html>
	<html>
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

			nav a:hover {
				background-color: #ddd;
				color: #333;
			}
			a{
				display: block;
				text-decoration: none;
			}
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

	nav a:hover {
		background-color: #ddd;
		color: #333;
	}
	a {
		display: block;
		text-decoration: none;
	}
	.button {
		background-color: #4CAF50;
		border: none;
		color: white;
		padding: 10px 20px;
		text-align: center;
		text-decoration: none;
		display: inline-block;
		font-size: 16px;
		margin: 4px 2px;
		cursor: pointer;
		border-radius: 8px;
	}
	.button:hover {
		background-color: #3e8e41;
	}
	nav {
  background-color: #333;
  color: #fff;
  overflow: hidden;
  top: 0;
  left: 0;
  width: 100%;
  z-index: 1;
}

nav a {
  float: left;
  display: block;
  color: #fff;
  text-align: center;
  padding: 14px 20px;
  text-decoration: none	;
}

nav a.active {
  background-color: #333;
  color: #fff;
}

nav a:hover {
  background-color: #ddd;
  color: #333;
}
.btn{
	background-color: grey;
		border: none;
		color: white;
		padding: 0px 2px;
		text-align: center;
		text-decoration: none;
		display: inline-block;
		font-size: 16px;
		margin: 4px 2px;
		cursor: pointer;
		border-radius: 8px;
}


</style>


	<head>
		<title style="margin=200px;">Job Listings</title>
	</head>
	<body>
		<nav>
  		
			  <a href="student_dashboard.php">Home</a>
			  <a href="studentDisplay.php">Profile</a>
			<a href="studentUpdate.php">Update</a>
			<a href="EligibleJob.php">Eligible Jobs</a>
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
					<th></th>

				</tr>
			</thead>
			<tbody>
				<?php
	ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);

					$host = 'localhost';
					$user = 'root';
					$password = 'password123';
					$dbname = 'minipro';
					$dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
					$options = [
					PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
					PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
					PDO::ATTR_EMULATE_PREPARES => false,
					];
					try {
					$pdo = new PDO($dsn, $user, $password, $options);
					} catch (\PDOException $e) {
					throw new \PDOException($e->getMessage(), (int)$e->getCode());
					}

					$conn = mysqli_connect("localhost", "root", "password123", "minipro");
					session_start();
					
					
					if(!isset($_SESSION['sess_user'])){
						header('Location: index.php');
					}
					$student_id = $_SESSION['sess_user'];
					$result = mysqli_query($conn, "select * from student_users where student_id = '$student_id'"); 
					$row = mysqli_fetch_array($result);
					
					$Alumini =$row["alumini"];
					if($Alumini==true)header('Location: alumini_upload.php');


					$stmt = $pdo->prepare("SELECT distinct Cpi,package FROM studentDetails WHERE roll = :roll");
					$stmt->execute([':roll' => $student_id]);
					$student = $stmt->fetch();
					// echo $stmt->rowCount();
					$st = $pdo->prepare("SELECT  area_of_interest FROM studentDetails WHERE roll = :roll");
					$st->execute([':roll' => $student_id]);



					//Fetch student
					// Retrieve the data from the students table
					
				
					// Fetch data from MySQL table

					while($role = $st->fetch())
						{
					$stmt = $pdo->prepare("
		SELECT * FROM job_details WHERE marks_criteria < :cpi AND role = :role AND salary_package >:package; 
		");
		$stmt->execute([
		':cpi' => $student['Cpi'],
		':role'   => $role['area_of_interest'],
		':package'   => $student['package'],

		]);
		$rownum=$stmt->rowCount();

		if($rownum >0){
			while ($row = $stmt->fetch()) {
				echo "<tr>";
								echo "<td>" . $row["company_name"] . "</td>";
								echo "<td>" . $row["role"] . "</td>";
								echo "<td>" . $row["min_qualification"] . "</td>";
								echo "<td>" . $row["marks_criteria"] . "</td>";
								echo "<td>" . $row["salary_package"] . "</td>";
								echo "<td>" . $row["interview_mode"] . "</td>";
								echo "<td><button class=\"button\"><a href='rsc.php?company=" . $row["company_name"] . "& role=".$role['area_of_interest']." '>Register</a></button></td>";

								echo "</tr>";
			}
		}
		// else{
		// 	echo "<tr><td colspan='3'>You have no job listed</td></tr>";
		// }
	}
				?>

				
			</tbody>
		</table>


	</body>
	</html>
