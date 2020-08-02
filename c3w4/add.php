<?php 
   session_start();
   if(isset($_POST['logout'])){
      header('Location: index.php');
   }
   if(!isset($_SESSION['name'])){
      die("Not logged in");
   }else {
      $user = htmlentities($_SESSION['name']);
   }

   require_once 'pdo.php';

   if(isset($_POST['add'])){
      echo 'add presses';
      $make = htmlentities($_POST['make']);
      $year = htmlentities($_POST['year']);
      $mileage = htmlentities($_POST['mileage']);

      if(empty($mileage) || empty($year)) {
         $_SESSION['error'] = "Input fields should not be empty";
      }else if (empty($make)){
         $_SESSION['error'] = "Make is required";
      }else if(!is_numeric($year) || !is_numeric($mileage)){
         $_SESSION['error'] = "Mileage and year must be numeric";
      }else {
         echo 'up here';
         $sql = 'INSERT INTO autos (make, year, mileage) VALUES (:mk, :yr, :mi)';
         $stmt = $pdo->prepare($sql);
         $stmt->execute([
            ':mk' => $make,
            ':yr' => $year,
            ':mi' => $mileage
         ]);
         $_SESSION['success'] = "Record inserted";
         header('Location: view.php');
         return;
      }
      header('Location: add.php');
      return;
   }
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <?php include 'boot-css.php' ?>
   <title>Aseer KT</title>
</head>
<body>
   <div class="container">
      <h1>Add Autos to Database</h1>
      <p style="color: red">
         <?= $_SESSION['error'] ?? '' ?>
         <?php unset($_SESSION['error']) ?>
      </p>
      <form method="POST">
         <p class="row">
            <label class="form-label col-12 col-md-1" for="make">Make</label>
            <input class="form-control form-control-sm col-12 col-md-2" type="text" name="make" id="make" />
         </p>
         <p class="row">
            <label class="form-label col-12 col-sm-1" for="year">Year</label>
            <input class="form-control form-control-sm col-12 col-md-2" type="text" name="year" id="year" />
         </p>
         <p class="row">
            <label class="form-label col-12 col-sm-1" for="mileage">Mileage</label>
            <input class="form-control form-control-sm col-12 col-md-2" type="text" name="mileage" id="mileage" />
         </p>
         <button class="btn btn-sm btn-primary" type="submit" name="add">Add</button>
         <button class="btn btn-sm btn-secondary" type="submit" name="logout">Logout</button>
      </form>
   </div>
   
</body>
</html>