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
    header('Location: login.php');
}
	
	$student_id = $_SESSION['sess_user'];
	$result = mysqli_query($conn, "select * from student_users where student_id = '$student_id'"); 
	$row = mysqli_fetch_array($result);
	$name = $row["name"];
	$Alumini =$row["alumini"];
	$stmt = $pdo->prepare("SELECT * FROM aluminiTable WHERE rollno = :roll");
      $stmt->execute([':roll' => $student_id]);
      $student = $stmt->fetch();

	  if(!$student){
		echo "<script> 
		function hideFields(){
			document.getElementById(\"nnn\").style.display=\"block\";
			document.getElementById(\"www\").style.display=\"none\";
		}
		window.onload = function() {
			hideFields();
		};
		</script>";
	}else{

	}
?>
	<nav>
	    <a href="http://localhost/minpro/student_dashboard.php">Home</a>
		<a href="http://localhost/minpro/studentDisplay.php">Profile</a>
		<div id="www">
			<a href="http://localhost/minpro/studentUpdate.php">Update</a>
		</div>
		<a href="logout.php" style="float: right; background-color: red;">Logout</a>

	</nav>

	<div>
		<h1>Welcome <?php echo $name ?></h1>
		<div id = 'nnn' style='display:none;'>

			<h3>If not uploaded data ...then upload here 
				
				<button><a href="http://localhost/minpro/studentUpload.php">Upload</a></button>
			</h3>
		</div>
	</div>
</body>
</html>
