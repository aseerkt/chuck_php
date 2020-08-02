<?php 
   // Import PDO from pdo.php
   require_once ('pdo.php');

   if(isset($_POST['cancel'])){
      header('Location: index.php');
   }

   if(isset($_POST['login'])){
      if(empty($_POST['who']) || empty($_POST['pass'])){

         $error = 'Email and password are required';

      }else {
         
         $email = htmlentities($_POST['who']);
         $password = htmlentities($_POST['pass']);

         $regex = "/.@/i";
         if(!preg_match($regex, $email)){
            $error = 'Email must have an at-sign (@)';
         }else {
            $salt = 'XyZzy12*_';
            $stored_hash = '1a52e17fa899cf40fb04cfc42e6352f1';
            // password - php123
            $check = hash('md5', $salt.$password);
            if($stored_hash != $check){
               $error = 'Incorrect password';
               error_log("Login fail ".$_POST['who']." $check");
            }else {
               error_log("Login success ".$_POST['who']);
               header("Location: autos.php?name=".urlencode($_POST['who']));

            }
         }


      }
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
      <h1>Please Login</h1>
      <p style="color: red">
         <?= $error ?? '' ?>
      </p>
      <form method="POST">
         <p class="row"> <!-- Email -->
            <label class="form-label col-12 col-sm-2" for="email">Email</label>
            <input class="form-control form-control-sm col-12 col-sm-4" type="text" name="who" id="email">
         </p>
         <p class="row"> <!-- Password -->
            <label class="form-label col-12 col-sm-2" for="pwd">Password</label>
            <input class="form-control form-control-sm col-12 col-sm-4" type="password" name="pass" id="pwd"><br>
         </p>
         <input class="btn btn-sm btn-primary" type="submit" name="login" value="Log In">
         <input class="btn btn-sm btn-secondary" type="submit" name="cancel" value="Cancel">
      </form>
   </div>
   <?php include 'boot-js.php'; ?>
</body>
</html>