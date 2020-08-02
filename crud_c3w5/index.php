<?php
   session_start();
   if(isset($_SESSION['name'])){

      require_once 'pdo.php';
      $user = $_SESSION['name'];

      $sql = 'SELECT * FROM autos';
      $stmt = $pdo->prepare($sql);
      $stmt->execute();
      $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
      <h1>Welcome to Automobiles Database</h1>
      <hr>

      <?php if(!isset($_SESSION['name'])): ?>
         <p><a href="login.php">Please log in</a></p>
         <p>Going to <a href="add.php">add.php</a> will fail with error message</p>
         <p>Going to <a href="edit.php">edit.php</a> will fail with error message</p>

      <?php else: ?>
         <!-- ERROR MESSAGE -->
         <p style="color: red">
            <?= $_SESSION['error'] ?? '' ?>
            <?php unset($_SESSION['error']); ?>
         </p>
         <!-- SUCCESS MESSAGE -->
         <p style="color: green">
            <?= $_SESSION['success'] ?? '' ?>
            <?php unset($_SESSION['success']); ?>
         </p>
         <!-- If there are rows in the database -->
         <?php if(!empty($rows)): ?>
            <table class="table table-striped table-responsive">
            <thead>
               <tr>
                  <th>Make</th>
                  <th>Model</th>
                  <th>Year</th>
                  <th>Mileage</th>
                  <th>Action</th>
               </tr>
            </thead>
            <tbody>
               <?php foreach ($rows as $row):?>
                  <tr>
                     <td><?= htmlentities($row['make']) ?></td>
                     <td><?= htmlentities($row['model']) ?></td>
                     <td><?= htmlentities($row['year']) ?></td>
                     <td><?= htmlentities($row['mileage']) ?></td>
                     <td>
                        <a href="edit.php?autos_id=<?= htmlentities($row['autos_id']) ?>">Edit</a>
                        /
                        <a href="delete.php?autos_id=<?= htmlentities($row['autos_id']) ?>">Delete</a></td>
                  </tr>
               <?php endforeach; ?>
            </tbody>
         </table>
         <!-- If there are no rows in the database --> 
         <?php else: ?>
            <p><b>No rows found</b></p>
         <?php endif; ?>
         <hr>
         <!-- Links Add and Logout -->
         <p><a href="add.php">Add New Entry</a></p>
         <p><a href="logout.php">Logout</a></p>
      <?php endif; ?>
   </div>
   
</body>
</html>