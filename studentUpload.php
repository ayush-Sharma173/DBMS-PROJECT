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
    if($Alumini==true)header('Location: alumini_upload.php');

    
    // If the form has been submitted, insert the data into the database
    if (isset($_POST['submit'])) {
      $area_of_interests = $_POST['option'];
      foreach ($area_of_interests as $area_of_interest) {
        $stmt = $pdo->prepare("
        INSERT INTO studentDetails
          (name, age,roll, branch, area_of_interest, batch_year, 10marks, 12marks,sem_1,sem_2,sem_3,sem_4,sem_5,sem_6,sem_7,sem_8,Comp_name,package,role,resume)
        VALUES
          (:name, :age,:roll, :specialization, :area_of_interest, :batch_year, :class_10_marks, :class_12_marks,:sem1_spi,:sem2_spi,:sem3_spi,:sem4_spi,:sem5_spi,:sem6_spi,:sem7_spi,:sem8_spi,:company,:salary,:role,:resume)
      ");
      $stmt->execute([
        ':name' => $_POST['name'],
        ':age' => $_POST['age'],
        ':roll' => $_POST['roll'],
        ':specialization' => $_POST['specialization'],
        ':area_of_interest' => $area_of_interest,  
        ':batch_year' => $_POST['batch_year'],
        ':class_10_marks' => $_POST['class_10_marks'],
        ':class_12_marks' => $_POST['class_12_marks'],
        ':sem1_spi' => $_POST['sem1_spi'],
        ':sem2_spi' => $_POST['sem2_spi'],
        ':sem3_spi' => $_POST['sem3_spi'],
        ':sem4_spi' => $_POST['sem4_spi'],
        ':sem5_spi' => $_POST['sem5_spi'],
        ':sem6_spi' => $_POST['sem6_spi'],
        ':sem7_spi' => $_POST['sem7_spi'],
        ':sem8_spi' => $_POST['sem8_spi'],
        ':company'  => $_POST['company'],
        ':salary'   => $_POST['package'],
        ':role'   => $_POST['role'],
        ':resume'   => $_POST['resume'],
      ]);
      }
    echo '<script type ="text/JavaScript">';  
    echo 'alert("Data has been added to the database.")';  
    echo '</script>';  
    header("Location: student_dashboard.php");

  }
?>
<form method="post">
  <label for="name">Name:</label>
  <input type="text" id="name" name="name" required>

  <label for="age">Age:</label>
  <input type="number" id="age" name="age" required>

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

      <label for="area_of_interest">Area of Interest:</label>
        <div class="fff">
        <label for="SDE">
        <input type="checkbox" name="option[]" value="SDE">
        SDE</label>
        <label for="Management">
        <input type="checkbox" name="option[]" value="Management">
        Management</label>
        <label for="Core">
        <input type="checkbox" name="option[]" value="Core">
        Core</label>
        <label for="Consultancy">
        <input type="checkbox" name="option[]" value="Consultancy">
        Consultancy</label>
        <label for="Quant">
        <input type="checkbox" name="option[]" value="Quant">
        Quant</label>
        <br>
        </div>

  <label for="batch_year">Batch Year:</label>
  <input type="text" id="batch_year" name="batch_year" placeholder="YYYY" required>

  <h3>Academic Details:</h3> 

  <label for="class_10_marks">Class 10 Marks:</label>
  <input type="number" id="class_10_marks" name="class_10_marks" step="0.01" required>

  <label for="class_12_marks">Class 12 Marks:</label>
  <input type="number" id="class_12_marks" name="class_12_marks" step="0.01" required>

  <label for="sem1_spi">Semester 1 SPI:</label>
  <input type="number" id="sem1_spi" name="sem1_spi" value="0" step="0.01"  >
  <label for="sem2_spi">Semester 2 SPI:</label>
  <input type="number" id="sem2_spi" name="sem2_spi" value="0" step="0.01" > 
  <label for="sem3_spi">Semester 3 SPI:</label>
  <input type="number" id="sem3_spi" name="sem3_spi" value="0" step="0.01" > 
  <label for="sem4_spi">Semester 4 SPI:</label>
  <input type="number" id="sem4_spi" name="sem4_spi" value="0" step="0.01" > 
  <label for="sem5_spi">Semester 5 SPI:</label>
  <input type="number" id="sem5_spi" name="sem5_spi" value="0" step="0.01" > 
  <label for="sem6_spi">Semester 6 SPI:</label>
  <input type="number" id="sem6_spi" name="sem6_spi" value="0" step="0.01" > 
  <label for="sem7_spi">Semester 7 SPI:</label>
  <input type="number" id="sem7_spi" name="sem7_spi" value="0" step="0.01" > 
  <label for="sem8_spi">Semester 8 SPI:</label>
  <input type="number" id="sem8_spi" name="sem8_spi" value="0" step="0.01" > 
  <label for="roll">Resume Link:</label>
  <input type="text" id="resume" name="resume" required>
  <label> Are you placed?</label>
  <label>
  <input type="radio" name="yesno" value="yes" onclick="showFields()">
  Yes
</label>

<label>
  <input type="radio" name="yesno" value="no" onclick="hideFields()">
  No
</label>

<label for="declare">
I agree to the terms and conditions.All the information is correct.
  <input type="checkbox" id="declaration" name="declaration" value="declared">
</label>

<div id="yesplaced" style="display: none;">
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
</div>
    
  <input type="submit" name="submit" id="submitBtn" value="Submit">
    </form>
