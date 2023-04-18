<?php
// MySQL database credentials
if(isset($_POST['submit'])) {
$servername = "localhost";
$username = "root";
$password = "password123";
$dbname = "minipro";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get form data
$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];
$user_type = $_POST['user_type'];

// Insert user data into appropriate MySQL table
if ($user_type == 'admin') {
    $sql = "INSERT INTO coordinator_users ( email, password) VALUES ( '$email', '$password')";
} elseif ($user_type == 'company') {
    $company_name = $_POST['company_name'];
    $company_address = $_POST['company_address'];
    $sql = "INSERT INTO company_users ( name, email,company_name, password) VALUES ( '$name','$email', '$company_name','$password')";
} elseif ($user_type == 'student') {
    $student_id = $_POST['student_id'];
    $gradYr = $_POST['graduating_yr'];
    $sql = "INSERT INTO student_users (student_id,name, email, password,  Graduating_yr) VALUES ( '$student_id','$name', '$email', '$password', '$gradYr')";
    // $sql = "UPDATE  student_users set alumini = TRUE where Graduating_yr< year(CURDATE())";
    // $sql = "UPDATE  student_users set alumini = FLASE where Graduating_yr>= year(CURDATE())";
    
} elseif ($user_type == 'coordinator') {
    $coordinator_id = $_POST['coordinator_id'];
    $department = $_POST['department'];
    $sql = "INSERT INTO coordinator_users (name, email, password) VALUES ('$name', '$email', '$password')";
}
else{

    echo "select a user!";
}

if (mysqli_query($conn, $sql)) {
 echo "Registration successful!";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Registration</title>
    <link rel="stylesheet" href="style.css">
</head>
<style>

    body {
  background-color: #e3f2fd;
}
.background {
        background-image: url("regbg.jpg");
        background-size: cover;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        opacity: 1;
        z-index: -1;
        transition: opacity 1s ease-in-out;
        }
.container {
    
  width: 40%;
  margin: 30px;
  /* height: 50%; */
  /* text-align: center; */
  padding: 20px;
  border: 2px solid #ccc;
  background-color: #f5f5f5;
  box-shadow: 0 0 10px rgba(0,0,0,0.1);
  border-radius: 5px;
  border: none;
        border-radius: 15px;
        box-shadow: 5px 5px 5px #4e73df;
        max-width: 500px;
        margin: 0 auto;
        background-color: #fff;
        padding: 30px;
}

input[type="text"],
input[type="email"],
input[type="password"],
select {
  width: 70%;
  padding: 3px;
  margin-bottom: 10px;
  border: none;
  border-bottom: 2px solid #ccc;
  background-color: transparent;
  font-size: 18px;
}

select {
  margin-top: 10px;
}

label {
  display: inline;
  margin-bottom: 5px;
  font-size: 20px;
}

button[type="submit"] {
  background-color: #4CAF50;
  color: white;
  padding: 12px 20px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  font-size: 18px;
  transition: background-color 0.2s ease;
}

button[type="submit"]:hover {
  background-color: #3e8e41;
}



/* style.css */
body {
  background-color: #e3f2fd;
  font-family: Arial, sans-serif;
}

.background {
  background-image: url("regbg.jpg");
  background-size: cover;
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  opacity: 1;
  z-index: -1;
  transition: opacity 1s ease-in-out;
}

.container {
  max-width: 500px;
  margin: 20px auto;
  padding: 30px;
  border-radius: 15px;
  background-color: #fff;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

h1 {
  font-size: 28px;
  text-align: center;
  margin-bottom: 8px;
  margin-top: 5px;
}

label {
  display: block;
  font-size: 18px;
  margin-bottom: 5px;
}

input[type="text"],
input[type="email"],
input[type="password"],
select {
  width: 100%;
  padding: 10px;
  margin-bottom: 10px;
  border: none;
  border-bottom: 2px solid #ccc;
  background-color: transparent;
  font-size: 18px;
}

select {
  margin-top: 3px;
}

button[type="submit"] {
  display: block;
  width: 100%;
  background-color: #4CAF50;
  color: white;
  padding: 12px 20px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  font-size: 12px;
  transition: background-color 0.2s ease;
}

button[type="submit"]:hover {
  background-color: #3e8e41;
}

hr {
  margin: 10px 0;
}

p {
  text-align: center;
}

a {
  color: #4e73df;
}

</style>
<body class ='background'>
    <div class="container">
        <h1>User Registration</h1>
        <form method="post">
            <label for="user_type">User Type:</label>
            <select id="user_type" name="user_type" onchange="showAdditionalFields()">
                <option value="">Select User Type</option>
                <option value="admin">Admin</option>
                <option value="company">Company</option>
                <option value="student">Student</option>
                <option value="coordinator">Coordinator</option>
            </select>
            
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>



            <div id="additional-fields">
                <!-- Fields for Company Users -->
                <div id="company-fields" style="display:none;">
                
                    <label for="company_name">Company Name:</label>
                    <input type="text" id="company_name" name="company_name">
                    <label for="company_address" style="display:block;">Company Address:</label>
                    <input type="text" id="company_address" name="company_address">
                </div>

                <!-- Fields for Student Users -->
                <div id="student-fields" style="display:none;">
                    
                    <label for="student_id">Student ID:</label>
                    <input type="text" id="student_id" name="student_id">
                    <label for="graduating_yr">Graduation Year:</label>
                    <input type="text" id="graduating_yr" name="graduating_yr">
                </div>

                <!-- Fields for Coordinator Users -->
                <div id="coordinator-fields" style="display:none;">
                    <label for="coordinator_id">Coordinator ID:</label>
                    <input type="text" id="coordinator_id" name="coordinator_id">
                    <label for="department">Department:</label>
                    <input type="text" id="department" name="department">
                </div>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            </div>

            <button type="submit" name="submit">Register</button>
        </form>
        <hr>
                        <p>Already have an account? <a href="login.php">logIn</a>.</p>
    </div>

    <script>
        function showAdditionalFields() {
            var userType = document.getElementById("user_type").value;
            var companyFields = document.getElementById("company-fields");
            var studentFields = document.getElementById("student-fields");
            var coordinatorFields = document.getElementById("coordinator-fields");

            if (userType === "company") {
                companyFields.style.display = "block";
                studentFields.style.display = "none";
                coordinatorFields.style.display = "none";
            } else if (userType === "student") {
                companyFields.style.display = "none";
                studentFields.style.display = "block";
                coordinatorFields.style.display = "none";
            } else if (userType === "coordinator") {
                companyFields.style.display = "none";
                studentFields.style.display = "none";
                coordinatorFields.style.display = "block";
            } else {
                companyFields.style.display = "none";
                studentFields.style.display = "none";
                coordinatorFields.style.display = "none";
            }
        }
    </script>
</body>
</html>

