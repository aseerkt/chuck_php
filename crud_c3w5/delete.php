<?php 
   session_start();
   require_once 'pdo.php';

   // Check whether user logged in or not.
   if(!isset($_SESSION['name'])){
      die("ACCESS DENIED");
   }

   //POST OPERATION
   if(isset($_POST['delete'])){
      $sql = 'DELETE FROM autos WHERE autos_id=:id';
      $stmt = $pdo->prepare($sql);
      $stmt->execute(array(
         ':id' => $_SESSION['id']
      ));
      unset($_SESSION['id']);
      $_SESSION['success'] = 'Record deleted';
      header('Location: index.php');
   }  

   //GET OPERATION
   if(isset($_GET['autos_id'])){

      $id = $_GET['autos_id'];
      $_SESSION['id'] = $id;

      //Reading data for given autos_id
      $sql = 'SELECT make FROM autos WHERE autos_id=:id';
      $stmt = $pdo->prepare($sql);
      $stmt->execute(array(
         ':id' => $id
      ));
      $data = $stmt->fetch(PDO::FETCH_ASSOC);
      $make = $data['make'];
      if(empty($make)){
         $_SESSION['error']= 'Bad value for id';
         header('Location: index.php');
      }

   }else {
      
      return;
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
      <form method="POST">
         <p>Confirm: Deleting <?= htmlentities($make) ?></p>
         <button class="btn btn-sm btn-danger" type="submit" name="delete">Delete</button>
         <a href="index.php">Cancel</a>
      </form>
   </div>
   
</body>
</html>