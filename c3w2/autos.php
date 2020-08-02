<?php 
   // Import PDO connection
   require_once ('pdo.php');
   // Logout
   if(isset($_POST['logout'])){
      header('Location: index.php?name=$user_mail');
   }
   // Checking name GET parameter in the url
   if(!isset($_GET['name'])) {
      die("Name parameter missing");
   }else {
      $user_mail = htmlentities($_GET['name']);
   }  

   // If Add button is clicked
   if(isset($_POST['add'])){
      if(empty($_POST['year']) || empty($_POST['mileage'])){
         $error = 'Fields should not be empty';
      }else {
         if (empty($_POST['make'])){
            $error = 'Make is required';
         }else if(!is_numeric($_POST['year']) || !is_numeric($_POST['mileage'])) {
            $error = 'Mileage and year must be numeric';
         }else {
            $sql = 'INSERT INTO autos (make, year, mileage) VALUES ( :mk, :yr, :mi)';
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array(
              ':mk' => htmlentities($_POST['make']),
              ':yr' => htmlentities($_POST['year']),
              ':mi' => htmlentities($_POST['mileage']))
            );
            $success = 'Record inserted';
         }

      }
   }

   // Checking any automobiles under current logged in user
   try {
      $sql = 'SELECT make,mileage,year FROM autos ORDER BY make';
      $stmt = $pdo->prepare($sql);
      $stmt->execute();
   }catch (Exception $e){
      echo 'Sasi';
   }



?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <?php include 'boot-css.php'; ?>
   <title>Aseer KT</title>
</head>
<body>
   <div class="container">
      <h1>Tracking autos for <?= $user_mail ?></h1>
      <p id="error" style="color: red"> 
         <?= $error ?? '' ?>
      </p>
      <p id="success" style="color: green">
         <?= $success ?? '' ?>
      </p>

      <div id="form-div">
         <form method="POST">
            <p class="row">
               <label class="form-label col-12 col-sm-2" for="make">Make</label>
               <input class="form-control form-control-sm col-12 col-sm-4" type="text" name="make" id="make">
            </p>
            <p class="row">
               <label class="form-label col-12 col-sm-2" for="year">Year</label>
               <input class="form-control form-control-sm col-12 col-sm-4" type="text" name="year" id="year">
            </p>
            <p class="row">
               <label class="form-label col-12 col-sm-2" for="mileage">Mileage</label>
               <input class="form-control form-control-sm col-12 col-sm-4" type="text" name="mileage" id="mileage">
            </p>
            <button class="btn btn-sm btn-primary" type="submit" name="add">Add</button>
            <button class="btn btn-sm btn-secondary" type="submit" name="logout">Logout</button>
         </form>
      </div>
      <div>
         <h2 class="mt-5">Automobiles List</h2>
         <?php if(isset($stmt)): ?>
            <ul>
               <?php while($row=$stmt->fetch(PDO::FETCH_ASSOC)): ?>
                  <li><?=  $row['year'].' '.$row['make'].' /'.$row['mileage'] ?></li>
               <?php endwhile; ?>
            </ul>   
         <?php endif; ?>
      </div>
   </div>
   <?php include 'boot-js.php'; ?>
</body>
</html>