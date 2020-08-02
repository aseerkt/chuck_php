<?php 
   session_start();
   if(!isset($_SESSION['name'])){
      die("Not logged in");
   }

   require_once 'pdo.php';
   try {
      $sql = 'SELECT make,year,mileage from autos';
      $stmt = $pdo->query($sql);
   }catch (Exception $e){
      echo 'Really Nigga';
      error_log($e);
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
      <h1>Automobiles</h1>
      <p style="color: green">
         <?= $_SESSION['success'] ?? '' ?>
         <?php unset($_SESSION['success']) ?>
      </p>
      <ul>
         <?php while ($row=$stmt->fetch(PDO::FETCH_ASSOC)):?>
            <li>
               <p><?= $row['year']." ".$row['make']." /".$row['mileage'] ?? '' ?> </p>
            </li>
         <?php endwhile; ?>         
      </ul>
       
      <hr>   
      <a href="add.php">Add New</a> | 
      <a href="logout.php">Logout</a>
   </div>
   
</body>
</html>