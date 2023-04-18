<!DOCTYPE html>
<html>
  <head>
    <title>Company Recruitment Details</title>
    <style>

      
      body {
       font-family: Arial, sans-serif;
        margin:0px ;
       }

      form {
          margin: 20px 0;
      }

      label {
          display: block;
          margin-bottom: 5px;
          margin-left:20px ;
      }

      input[type="text"],
      select {
          width: 10%;
          padding: 10px;
          background-color:lightgrey ;
          margin: 5px 0;
          border: 5px;
          margin-left:20px ;
          border-radius: 3px;
          box-sizing: border-box;
          
      }

      input[type="submit"] {
          background-color: #4CAF50;
          color: white;
          padding: 10px 20px;
          border: none;
          margin-left:90px ;
          border-radius: 3px;
          cursor: pointer;
      }

      input[type="submit"]:hover {
          background-color: #3e8e41;
      }

      select option {
          padding: 10px;
      }
    
      h1{
        margin-left:30px ;
      }

      nav {
        background-color: #333;
        color: #fff;
        overflow: hidden;
        margin:0px ;
      }

      nav a {
        float: left;
        display: block;
        color: #fff;
        text-align: center;
        padding: 14px 16px;
        text-decoration: none;
        margin:0px ;

      }

      nav a:hover {
        background-color: #ddd;
        color: #333;
      }
      a{
          display: block;
          text-decoration: none;
          margin:10px ;
      }
      /* CSS reset */
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

/* Global styles */
body {
  font-family: Arial, sans-serif;
}

/* Header */
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

/* Main content */
.container {
  max-width: 960px;
  margin: 0 auto;
  padding: 20px;
}

h1 {
  margin-bottom: 20px;
}

form {
  margin-bottom: 20px;
}

label {
  display: block;
  margin-bottom: 5px;
}

input[type="text"],
select {
  width: 10%;
  padding: 10px;
  margin-bottom: 10px;
  background-color: lightgrey;
  border: none;
  border-radius: 3px;
}

input[type="submit"] {
  background-color: #4CAF50;
  color: white;
  padding: 10px 20px;
  border: none;
  border-radius: 3px;
  cursor: pointer;
  
}

input[type="submit"]:hover {
  background-color: #3e8e41;
}

select option {
  padding: 10px;
}

a {
  display: block;
  text-decoration: none;
  margin: 10px;
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
    <h1>Job Details</h1>
    <?php
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
    
      $email = $_SESSION['sess_user'];
        if(!isset($_SESSION['sess_user'])){
        header('Location: login.php');
      }
      $result = mysqli_query($conn, "select * from company_users where email = '$email'"); 
      $row = mysqli_fetch_array($result);
      $company_name = $row["company_name"];

      // If the form has been submitted, insert the data into the database
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $stmt = $pdo->prepare("
          INSERT INTO job_details
            (company_name, min_qualification, marks_criteria, salary_package, interview_mode,role,company_email)
          VALUES
            (:company_name, :min_qual, :marks_criteria, :salary_package, :interview_mode,:role,:email)
        ");
        $stmt->execute([
          ':company_name' => $_POST['company_name'],
          ':min_qual' => $_POST['min_qual'],
          ':marks_criteria' => $_POST['marks_criteria'],
          ':salary_package' => $_POST['salary_package'],
          ':interview_mode' => $_POST['interview_mode'],
          ':role' => $_POST['role'],
          ':email' => $email,
        ]);
        echo '<script type ="text/JavaScript">';  
        echo 'alert("Data has been added to the database.")';  
        echo '</script>'; 
      }
    ?>
    <form method="post">
      <label for="company_name">Company Name:</label>
      <input type="text" id="company_name" name="company_name" required value="<?php echo $company_name; ?>" readonly>

      <label for="min_qual">Minimum Qualification:</label>
      <select id="min_qual" name="min_qual" required>
        <option value="B_tech">B.Tech</option>
        <option value="M_tech">M.Tech</option>
        <option value="P_hd">PhD</option>
      </select>

      <label for="marks_criteria">Marks Criteria:</label>
      <input type="text" id="marks_criteria" name="marks_criteria" required>

      <label for="salary_package">Salary Package:</label>
      <input type="text" id="salary_package" name="salary_package" required>

      <label for="interview_mode">Mode of Interview:</label>
      <select id="interview_mode" name="interview_mode" required>
        <option value="online_written">Online/Written</option>
        <option value="online_interview">Online/Interview</option>
        <option value="offline_written">Offline/Written</option>
        <option value="offline_interview">Offline/Interview</option>
      </select>

     
       <label for="role">Role:</label>

        <select id="role" name="role" required>
            <option value="SDE">SDE</option>
            <option value="Quant">Quant</option>
            <option value="Management">Management</option>
            <option value="Core">Core</option>
        </select>

      
      <br> 
      <input type="submit" name="submit" value="Submit">

