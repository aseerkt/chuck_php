<?php
   session_start();
   if(isset($_POST['cancel'])){
      header('Location: index.php');
      return;
   }
   // Check whether user logged in or not.
   if(!isset($_SESSION['name'])){
      die("ACCESS DENIED");
   }else {
      $user = $_SESSION['name'];
   }

   if(isset($_POST['add'])){
      require_once 'pdo.php';

      $make = $_POST['make'];
      $model = $_POST['model'];
      $year = $_POST['year'];
      $mileage = $_POST['mileage'];

      if(empty($make) || empty($model) || empty($year) || empty($mileage)){
         $_SESSION['error'] = 'All fields are required';
      }else{
         $_SESSION['error'] = '';
         if(!is_numeric($year)) $_SESSION['error'] .= 'Year must be an integer<br>';
         if(!is_numeric($mileage)) $_SESSION['error'] .= 'Mileage must be an integer';

         if(empty($_SESSION['error'])){
            $stmt = $pdo->prepare('INSERT INTO autos (make, model, year, mileage) VALUES (:mk, :mo, :yr, :mi)');
            $stmt->execute(array(
               ':mk' => $make,
               ':mo' => $model,
               ':yr' => $year,
               ':mi' => $mileage
            ));
            $_SESSION['success'] = 'Record added';
            header('Location: index.php');
            return;
         }

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
      <h1>Adding Automobile to Database - <?= htmlentities($user) ?></h1>
      <hr>
      <p style="color: red">
         <?= $_SESSION['error'] ?? '' ?>
         <?php unset($_SESSION['error']) ?>
      </p>
      <form method="POST">
         <p class="row form-group">
            <label class="form-label col-12 col-md-1" for="make">Make</label>
            <input class="form-control form-control-sm col-12 col-md-3" type="text" name="make" id="make" />
         </p>
         <p class="row form-group">
            <label class="form-label col-12 col-md-1" for="model">Model</label>
            <input class="form-control form-control-sm col-12 col-md-3" type="text" name="model" id="model" />
         </p>
         <p class="row form-group">
            <label class="form-label col-12 col-md-1" for="year">Year</label>
            <input class="form-control form-control-sm col-12 col-md-3" type="text" name="year" id="year" />
         </p>
         <p class="row form-group">
            <label class="form-label col-12 col-md-1" for="mileage">Mileage</label>
            <input class="form-control form-control-sm col-12 col-md-3" type="text" name="mileage" id="mileage" />
         </p>
         <input class="btn btn-sm btn-primary" type="submit" name="add" value="Add" >
         <input class="btn btn-sm btn-secondary" type="submit" name="cancel" value="Cancel">
      </form>
   </div>
   
</body>
</html>