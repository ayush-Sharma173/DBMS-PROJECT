<!DOCTYPE html>
<html>
<head>
	<title>Navigation Bar Example</title>
	<style>
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

	<div>
		<h1>Students Registered</h1>
		<form method="post">
        <label for='role_select' >Select Role</label>
        <select name="role_select" id='role_select' class="form-control" >
            <option value=" ">--SELECT--</option>
            <option value="SDE">SDE</option>
            <option value="Quant">Quant</option>
            <option value="Management">Management</option>
            <option value="Core">Core</option>
        </select>
		<input type="submit" name="submit" id="submitBtn" value="Submit">
	</form>
        <table>
		<thead>
			<tr>
				<!-- <th>Company Name</th> -->
				<th>ROLL</th>
                <th>NAME</th> 
				<th>CPI </th>
				<th> ROLE</th>
				<th> RESUME LINK</th>
				

			</tr>
		</thead>
		<tbody>
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
	
	$Cname = $row["company_name"];
	if (isset($_POST['submit'])) {
	$role =$_POST['role_select'];
	
		$sql = "SELECT * FROM registrations r inner join studentDetails s on r.roll=s.roll where r.company_name ='$Cname' and r.role ='$role' AND s.area_of_interest='$role'";
    $result = mysqli_query($conn, $sql);

    // Display data row wise
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row["roll"] . "</td>";
            echo "<td>" . $row["name"] . "</td>";
			echo "<td>" . $row["Cpi"] . "</td>";
			echo "<td>" ;echo $role ;echo "</td>";
			echo "<td><a href=". $row["resume"] .">link</a></td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='3'>No Student registered </td></tr>";
    } 
	// $name = $row["name"];
	}

?>
			

			
		</tbody>
	</table>
        
	</div>
</body>
</html>
