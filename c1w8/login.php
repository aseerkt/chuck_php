<?php
   if (isset($_POST['submit'])) {
      $password = htmlentities($_POST['pass']);

      $salt = 'XyZzy12*_';
      $stored_hash = '1a52e17fa899cf40fb04cfc42e6352f1';
      // password - php123

      $md5 = hash('md5', $salt.$password );

      if ($md5 == $stored_hash) {
         header('location: game.php?name='.urldecode($_POST['who']));
      }else {
        if (!$password) {
          $error = 'Password is required';
        }else {
          $error = 'Incorrect password';
        }
      }
   }
   if (isset($_POST['cancel'])){
     header('Location: index.php');
   }
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <!-- Add bootstrap css files -->
   <?php include('bootstrap-css.php') ?>
   <title>Aseer KT</title>
</head>
<body>
   <div class="container">
     <h1 class="heading">Login to play</h1>

     <div>
       <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">
          <p class="row">
             <input class="form-control form-control-sm" type="text" name="who" id="uname" placeholder="Username">
          </p>
          <p class="row">
             <input class="form-control form-control-sm" type="password" name="pass" id="pwd" placeholder="Password">
          </p>
          <p class="row">
            <small class="form-text text-muted">Password hint: Check 'View page source'</small>
          </p>
          <?php if(isset($error)): ?>
            <p class="alert alert-danger">
               <?= $error ?? '' ?>
            </p>
          <?php endif; ?>

          <p><!-- Password : php123 --></p>
          <button class="btn btn-primary btn-sm m-0" type="submit" name="submit">Log In</button>
          <button class="btn btn-secondary btn-sm" type="submit" name="cancel">Cancel</button>
       </form>
     </div>
   </div>
   <!-- Add jquery, popper, bootstrap js files -->
   <?php include('bootstrap-js.php') ?>
</body>
</html>
