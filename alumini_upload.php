<!DOCTYPE html> 
<html> 
  <head> 
    <title>Student Details</title> 
    <style> 
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

      </style> 
      <script>
  function showFields() {
    document.getElementById("yesplaced").style.display = "block";
  }
  
  function hideFields() {
    document.getElementById("yesplaced").style.display = "none";
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
        <h1>Student Details:</h1> 
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

    
    // If the form has been submitted, insert the data into the database
    if (isset($_POST['submit'])) {
        $stmt = $pdo->prepare("
        INSERT INTO aluminiTable
          (rollno, Branch, year,company_name,salary,role)
        VALUES
          (:roll, :specialization, :batch_year, :company,:salary,:role)
      ");
      $stmt->execute([
        ':roll' => $_POST['roll'],
        ':specialization' => $_POST['specialization'],
        ':batch_year' => $_POST['batch_year'],
        ':company'  => $_POST['company'],
        ':salary'   => $_POST['package'],
        ':role'   => $_POST['role'],
      ]);
    echo '<script type ="text/JavaScript">';  
    echo 'alert("Data has been added to the database.")';  
    echo '</script>';  
    header("Location: student_dashboard.php");

  }
?>
<form method="post">


  <label for="roll">Roll Number:</label>
  <input type="text" id="roll" name="roll" required>

  <label for="specialization">Specialization:</label>
  <select id="specialization" name="specialization" required >
        <option value="">--Select--</option>
        <option value="Computer_Science">Computer Science & Engineering</option>
        <option value="AIDS">Artificial Intelligence & Data Science</option>
        <option value="EEE">Electrical & Electronics Engineering</option>
        <option value="Chemical">Chemical Engineering</option>
        <option value="Mechanical">Mechanical Engineering</option>
        <option value="Physics">Engineering Physics</option>
        <option value="MNC">Mathematics & Computing</option>
        <option value="Civil">Civil Engineering</option>
        <option value="MME">Material Sciences & Metullury</option>
      </select>

      
  <label for="batch_year">Batch Year:</label>
  <input type="text" id="batch_year" name="batch_year" placeholder="YYYY" required>

  
  <label for="Company">Company :</label>
  <input type="text" id="company" name="company" value=" ">
  <label for="Package">Package : (*provide package in LPA) <br>(*if not placed leave empty)</label>
  <input type="number" id="package" name="package" value="0" step="0.01" >
  <label for="Role">Role :</label>
  <select id="role" name="role" required value=" ">
        <option value=" ">--Select--</option>
        <option value="SDE">SDE</option>
        <option value="Management">Mangement</option>
        <option value="Quant">Quant</option>
        <option value="Core">Core</option>
        <option value="Consultancy">Consultancy</option>
    </select>
    <label for="declare">
    I agree to the terms and conditions.All the information is correct.
      <input type="checkbox" id="declaration" name="declaration" value="declared">
    </label>
    
  <input type="submit" name="submit" id="submitBtn" value="Submit">
    </form>
