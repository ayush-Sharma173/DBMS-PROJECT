<?php 
    // Connect to the MySQL database
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
      header('Location: login.php');
    }
    
    $roll = $_SESSION['sess_user'];
    
    
    
    $result = mysqli_query($conn, "select * from student_users where student_id = '$roll'"); 
$row = mysqli_fetch_array($result);
$name = $row["name"];
$Alumini =$row["alumini"];
    // Retrieve the data from the students table
    $stmt = $pdo->prepare("SELECT * FROM aluminiTable WHERE rollno = :roll");
    $stmt->execute([':roll' => $roll]);
    $student = $stmt->fetch();
  // If the form has been submitted, insert the data into the database
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare("
      UPDATE aluminiTable
       SET company_name=:company,salary=:salary,role=:role
       WHERE rollno='$roll'
       
    ");
    $stmt->execute([

      ':company'  => $_POST['company'],
      ':salary'   => $_POST['package'],
      ':role'   => $_POST['role'],
    ]);
    echo "<p>Data has been updated to the database.</p>\n";
  }
?>


<!DOCTYPE html> 
<html> 
  <head> 
    <title>Update Student Details</title> 
    <style> 

* {
  margin: 0;
  padding: 0;
  font-family: Arial, sans-serif;
}

    body {
  font-family: Arial, sans-serif;
  background-color: #f2f2f2;
}

form {
  margin: 20px auto;
  max-width: 500px;
  background-color: #fff;
  padding: 20px;
  border-radius: 5px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

h1 {
  text-align: center;
  margin-top: 50px;
}

label {
  display: block;
  margin-bottom: 5px;
  font-weight: bold;
}

input[type="text"],
input[type="number"],
input[type="email"],
select {
  width: 90%;
  padding: 10px;
  border: none;
  border-radius: 5px;
  margin-bottom: 20px;
  background-color: lightgray;
}

select option {
  color: #000;
}

input[type="submit"] {
  display: block;
  margin: 20px auto 0;
  background-color: #4caf50;
  color: #fff;
  border: none;
  padding: 10px 20px;
  border-radius: 5px;
  font-weight: bold;
  cursor: pointer;
}

input[type="submit"]:hover {
  background-color: #3e8e41;
}

.error {
  color: red;
  margin-bottom: 10px;
}

/*nav css */
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

      </style> 
      <script>
  function showFields() {
    document.getElementById("yesplaced").style.display = "block";
  }
  
  function hideFields() {
    const company = document.getElementById("company");
    const package = document.getElementById("package");
    const role = document.getElementById("role");
    document.getElementById("yesplaced").style.display = "none";
    company.value="";
    package.value=0;
    role.value="";
  }

  const checkbox = document.getElementById('declaration');
const submitBtn = document.getElementById('submitBtn');

checkbox.addEventListener('change', function() {
  if (this.checked) {
    submitBtn.disabled = false;
  } else {
    submitBtn.disabled = true;
  }
});


</script>


      </head> 
      <body> 

<nav>
     
		<a href="http://localhost/minpro/student_dashboard.php">Home</a>
		<a href="http://localhost/minpro/studentDisplay.php">Profile</a>
		<a href="http://localhost/minpro/studentUpdate.php">Update</a>
    <a href="logout.php" style="float: right; background-color: red;">Logout</a>


	</nav>
  
  <h1>Update Profile :</h1>
<form method="post">
  <label for="name">Name:</label>
      <input type="text" id="name" name="name" value="<?php echo $name; ?>" readonly>

      <label for="roll">Roll Number:</label>
      <input type="text" id="roll" name="roll" value="<?php echo $student['rollno']; ?>" readonly>

      <label for="specialization">Specialization:</label>
      <input type="text" id="specialization" name="specialization" value="<?php echo $student['Branch']; ?>" readonly>


     

      <label for="batch_year">Batch Year:</label>
      <input type="text" id="batch_year" name="batch_year" value="<?php echo $student['year']; ?>" readonly>

      
 <label for="Company">Company :</label>
 <input type="text" id="company" name="company" value="<?php echo $student['company_name']; ?>" >
 <label for="Package">Package : (*provide package in LPA) <br>(*if not placed leave empty)</label>
 <input type="number" id="package" name="package" value="<?php echo $student['salary']; ?>">
 <label for="Role">Role :</label>
 <select id="role" name="role" required>
        <option value="<?php echo $student['role']; ?>"><?php echo $student['role']; ?></option>
        <option value="SDE">SDE</option>
        <option value="Management">Mangement</option>
        <option value="Quant">Quant</option>
        <option value="Core">Core</option>
        <option value="Consultancy">Consultancy</option>
      </select>
    
  <input type="submit" name="submit" id="submitBtn" value="Update">
    </form>
