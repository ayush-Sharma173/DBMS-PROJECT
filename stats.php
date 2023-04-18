<!DOCTYPE html>
<html>
<head>
	<title>Placement Statistics</title>
	<style type="text/css">
		table {
			border-collapse: collapse;
			width: 100%;
		}
		table, th, td {
			border: 1px solid black;
			padding: 5px;
			text-align: center;
		}
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
	 <?php 
	 session_start();
    
	 if(!isset($_SESSION['sess_user'])){
	   header('Location: login.php');
	 }
	// ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);

	 if ($_SERVER["REQUEST_METHOD"] === "POST") : ?> 
		 <script type="text/javascript" src="loader.js"></script>
		 <script type="text/javascript">
	google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Year', 'Number of Students Placed'],  
            <?php
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
				  $pedo = new PDO($dsn, $user, $password, $options);
				} catch (\PDOException $e) {
				  throw new \PDOException($e->getMessage(), (int)$e->getCode());
				}
				
				$roles=array("SDE","Management","Quant","Consultancy","Core");
				$y=$_POST['year'];
				// $reg=$pedo->prepare("SELECT count(*) as val FROM students WHERE batch_year=:year;");
				// $reg->execute([
				// 	':year'=>$y
				// ]);
                // $register=$reg->fetch();
				// $sum=0;
				// $temp="NOT PLACED";
				foreach($roles as $role){
                  $st=$pedo->prepare("SELECT Count(rollno) as stat from finalyPlaced WHERE year=:year group by role having role=:role ;");
				  $st->execute([
					':role'=>$role,
					':year'=>$y
				]);
				  $rowC=$st->rowCount();
				  $row=$st->fetch();
				  if($rowC==0){
					$val=0;
				  }
				  else $val=$row['stat'];
				// $sum=$sum+$val;
				  echo "['".$role."',".$val."],";
				}
				// echo "['".$temp."',".$sum."],";
				?>
		]);
		var option = {
		<?php
          $ye1=$_POST["year"];
          $t1="ROLE-WISE PLACEMENT STATS ".strval($ye1);
          echo "title:'".$t1."'";
          ?>
          };

          var chart = new google.visualization.PieChart(document.getElementById('b_max'));
          chart.draw(data, option);
        }
		</script>
		<?php endif; ?> 
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
	<h1>Placement Statistics</h1>
	<form method="post">
		<label for="year">Select year:</label>
		<select name="year" id="year">
		<option value=" ">Select User Type</option>
		<?php
		   $current_year = date('Y');
		//    $current_year = 2026;
		   for($x = $current_year-1; $x >=2018 ; $x--){
			echo "<option value=\"$x\">$x</option>";
		   }
		?>
        <input type="submit" name="submit" value="Submit">
        <?php
			// Connect to MySQL database
			session_start();
    
    if(!isset($_SESSION['sess_user'])){
      header('Location: login.php');
    }
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


			
				if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				$year=$_POST['year'];
					echo "<h2>".$year."</h2><br>";
					// echo "<div style=\"display:flex;\">";
					echo "<div id=\"b_max\" style=\"width: 900px; height: 500px;\"></div>";
					// echo "<div id=\"c_max\" style=\"width: 900px; height: 500px;\"></div>";
					// Query the database to get the placement statistics
					// Company-wise
					$sql =$pdo->prepare("SELECT company_name, COUNT(*) AS `Total Placements`,AVG(`salary`) as `Average salary`,MAX(`salary`) as `MAX salary` FROM finalyPlaced WHERE `year` = :year GROUP BY `company_name`;");
					$sql->execute([':year'=>$year]);
					
					if ($sql->rowCount() > 0) {
						// Display the data as a table
						echo "<h3>Placement Statistics for $year (Company-wise)</h3>";
						echo "<table><thead><tr><th>company_name</th><th>Total Placements</th><th>Average salary</th><th>MAX salary</th></tr></thead><tbody>";
						while($row = $sql->fetch()) {
							echo "<tr><td>".$row['company_name']."</td><td>".$row['Total Placements']."</td><td>".$row['Average salary']."</td><td>".$row['MAX salary']."</td></tr>";
						}
						echo "</tbody></table>";
					} else {
						echo "No data found for the selected year";
					}

					// Role-wise
					$sql = $pdo->prepare("SELECT `role`, COUNT(*) AS `Total Placements`,AVG(`salary`) AS `Average salary`,MAX(`salary`) AS `MAX salary` FROM finalyPlaced WHERE `year` = :year GROUP BY `role`;");
					$sql->execute([':year'=>$year]);
					// $result =$sql->fetch();
					if ($sql->rowCount() > 0) {
						// Display the data as a table
						echo "<h3>Placement Statistics for $year (Role-wise)</h3>";
						echo "<table><thead><tr><th>Role</th><th>Total Placements</th><th>Average salary</th><th>MAX salary</th></tr></thead><tbody>";
						while($row = $sql->fetch()) {

							echo "<tr><td>".$row['role']."</td><td>".$row['Total Placements']."</td><td>".$row['Average salary']."</td><td>".$row['MAX salary']."</td></tr>";
							
						}
						echo "</tbody></table>";
					} else {
						echo "No data found for the selected year";
					}
					
					// Branch-wise
					$sql = $pdo->prepare("SELECT `Branch`, COUNT(*) AS `Total Placements`,AVG(`salary`) as `Average salary`,MAX(`salary`) as `MAX salary` FROM finalyPlaced WHERE `year` = :year GROUP BY `Branch`;");
					$sql->execute([':year'=>$year]);
					
					if ($sql->rowCount() > 0) {
						// Display the data as a table
						echo "<h3>Placement Statistics for $year (Branch-wise)</h3>";
						echo "<table><thead><tr><th>Branch</th><th>Total Placements</th><th>Average salary</th><th>MAX salary</th></tr></thead><tbody>";
						while($row = $sql->fetch()) {
							echo "<tr><td>".$row['Branch']."</td><td>".$row['Total Placements']."</td><td>".$row['Average salary']."</td><td>".$row['MAX salary']."</td></tr>";
						}
						echo "</tbody></table>";
					} else {
						echo "No data found for the selected year";
					}
				}
				
			// $conn->close();
			?>
		</select>
	</form>
	

</body>
</html>

