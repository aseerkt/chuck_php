<?php
   session_start();
   require_once 'pdo.php';

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

   //GET OPERATION
   if(isset($_GET['autos_id'])){

      $id = $_GET['autos_id'];
      $_SESSION['id'] = $id;

      //Reading data for given autos_id
      $sql = 'SELECT * FROM autos WHERE autos_id=:id';
      $stmt = $pdo->prepare($sql);
      $stmt->execute(array(
         ':id' => $id
      ));
      $row = $stmt->fetch(PDO::FETCH_ASSOC);

   }else {
      $_SESSION['error']= 'Bad value for id';
      header('Location: index.php');
      return;
   }

   if(isset($_POST['edit'])){

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
            $sql = 'UPDATE autos SET make = :mk, model = :mo, year = :yr, mileage = :mi WHERE autos_id=:id';
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array(
               ':mk' => $make,
               ':mo' => $model,
               ':yr' => $year,
               ':mi' => $mileage,
               ':id' => $_SESSION['id']
            ));
            unset($_SESSION['id']);
            $_SESSION['success'] = 'Record edited';
            header('Location: index.php');
            return;
         }

      }
      header("Location: edit.php?autos_id=".$_SESSION['id']);
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
      <h1>Editing Automobile</h1>
      <hr>
      <p style="color: red">
         <?= $_SESSION['error'] ?? '' ?>
         <?php unset($_SESSION['error']) ?>
      </p>
      <form method="POST">
         <p class="row form-group">
            <label class="form-label col-12 col-md-1" for="make">Make</label>
            <input class="form-control form-control-sm col-12 col-md-3" type="text" name="make" id="make" 
            value="<?= htmlentities($row['make']) ?>" />
         </p>
         <p class="row form-group">
            <label class="form-label col-12 col-md-1" for="model">Model</label>
            <input class="form-control form-control-sm col-12 col-md-3" type="text" name="model" id="model" 
            value="<?= htmlentities($row['model']) ?>" />
         </p>
         <p class="row form-group">
            <label class="form-label col-12 col-md-1" for="year">Year</label>
            <input class="form-control form-control-sm col-12 col-md-3" type="text" name="year" id="year" 
            value="<?= htmlentities($row['year']) ?>" />
         </p>
         <p class="row form-group">
            <label class="form-label col-12 col-md-1" for="mileage">Mileage</label>
            <input class="form-control form-control-sm col-12 col-md-3" type="text" name="mileage" id="mileage" 
            value="<?= htmlentities($row['mileage']) ?>" />
         </p>
         <input class="btn btn-sm btn-primary" type="submit" name="edit" value="Save" >
         <input class="btn btn-sm btn-secondary" type="submit" name="cancel" value="Cancel">
      </form>
   </div>
   
</body>
</html>