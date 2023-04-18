<!DOCTYPE html>
<html>
<head>
	<title>System Admin Terminal</title>
	<style>
		body {
			font-family: Arial, sans-serif;
			background-color: #f2f2f2;
			margin: 0;
			padding: 0;
		}
		h2 {
			color: #333;
			text-align: center;
			margin-top: 30px;
		}
		form {
			display: flex;
			flex-direction: column;
			align-items: center;
			margin-top: 50px;
		}
		label {
			font-weight: bold;
			margin-bottom: 10px;
		}
		input[type="text"] {
			padding: 10px;
			font-size: 16px;
			border-radius: 5px;
			border: none;
			box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
			margin-bottom: 20px;
			width: 400px;
			max-width: 100%;
		}
		input[type="submit"] {
			padding: 10px 20px;
			font-size: 16px;
			background-color: #4CAF50;
			color: #fff;
			border: none;
			border-radius: 5px;
			cursor: pointer;
		}
		input[type="submit"]:hover {
			background-color: #3e8e41;
		}
		table {
			border-collapse: collapse;
			margin-top: 50px;
			margin-bottom: 50px;
			width: 100%;
			border: 1px solid #ddd;
		}
		th, td {
			padding: 10px;
			text-align: left;
			border-bottom: 1px solid #ddd;
		}
		th {
			background-color: #4CAF50;
			color: #fff;
		}
	</style>
</head>
<body>

	<h2>System Admin Terminal</h2>
	<form method="POST">
		<label for="sql_command">Enter MySQL Command:</label>
		<input type="text" name="sql_command" id="sql_command">
		<input type="submit" value="Execute">
	</form>

	<?php
		// Database connection details
		$servername = "localhost";
		$username = "root";
		$password = "password123";
		$dbname = "minipro";

		// Create connection
		$conn = new mysqli($servername, $username, $password, $dbname);

		// Check connection
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			// Execute the MySQL command
			$sql_command = $_POST["sql_command"];
			$result = $conn->query($sql_command);

			// Display the result in a table
			if ($result->num_rows > 0) {
				echo "<table>";
				// Table header
				echo "<tr>";
				foreach ($result->fetch_fields() as $field) {
					echo "<th>" . $field->name . "</th>";
				}
				echo "</tr>";
				// Table rows
				while ($row = $result->fetch_assoc()) {
					echo "<tr>";
					foreach ($row as $value) {
						echo "<td>" . $value . "</td>";
					}
					echo "</tr>";
				}
				echo "</table>";
			} else {
				echo "<p>No results found.</p>";
			}
		}

		// Close connection
		$conn->close();
	?>
	<br>
<center><a href="logout.php" style=" background-color: red;">Logout</a></center>

</body>
</html>