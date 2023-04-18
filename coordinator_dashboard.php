<!DOCTYPE html>
<html>
<head>
	<title>Navigation Bar Example</title>
	
</head>
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
	
</style>

<body>

<?php 
ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
    // Connect to the MySQL database

      	$conn = mysqli_connect("localhost", "root", "password123", "minipro");
	session_start();
	
	
if(!isset($_SESSION['sess_user'])){
    header('Location: login.php');
}
	
	$email = $_SESSION['sess_user'];
	$result = mysqli_query($conn, "select * from coordinator_users where email = '$email'"); 
	$row = mysqli_fetch_array($result);
	$name = $row["name"];
    $name ='TPC';


	  if (isset($_POST['copy_button'])) {
        // SQL query to copy data from finalyPlaced to alumni
        $sql = "INSERT INTO aluminiTable SELECT * FROM finalyPlaced where year=year(curdate())";
        
        if (mysqli_query($conn, $sql)) {
            echo "Data copied successfully!";
        } else {
            echo "Error copying data: " . mysqli_error($conn);
        }
    }
?>
	<nav>
	<a href="http://localhost/minpro/coordinator_dashboard.php">HOME</a>
	<a href="http://localhost/minpro/addFinalyPlaced.php">ADD</a>
	    <a href="http://localhost/minpro/stats.php">stats</a>
		<a href="http://localhost/minpro/overview.php">overview</a>
		<a href="http://localhost/minpro/companywise.php">Company Wise</a>
		<a href="logout.php" style="float: right; background-color: red;">Logout</a>

	</nav>

	<div>
		<h1>Welcome <?php echo $name ?></h1>
		<div id = 'nnn' >

			<h3>Move this year placements to aluminies...
				
                        <form method="post">
                <button class= "button" type="submit" name="copy_button">Copy data</button>
            </form>
                </h3>
            </div>
	</div>
</body>
</html>
