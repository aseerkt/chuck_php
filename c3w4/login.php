<?php 
   session_start();

   if(isset($_POST['cancel'])){
      header('Location: index.php');
   }
   if(isset($_POST['login'])){

      $email = htmlentities($_POST['email']);
      $_SESSION['name'] = $email;
      $password = htmlentities($_POST['pass']);

      if (empty($email) || empty($password)){
         $_SESSION['error'] = 'Email and password are required';
      }
      else if(!preg_match('/.@/i', $email)){
         $_SESSION['error'] = 'Email must have an at-sign (@)';
      }else {
         $salt = 'XyZzy12*_';
         $stored_hash = '1a52e17fa899cf40fb04cfc42e6352f1';
         // Password: php123
         $md5 = hash('md5', $salt.$password);
         if($md5 == $stored_hash){
            error_log('Login Success: '. $_SESSION['who']);
            header('Location: view.php');
            return;
         }else {
            error_log('Login Failed: '.$_SESSION['who'].' $md5');
            $_SESSION['error'] = "Incorrect password";
         }
      }
      header('Location: login.php');
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
      <h1>Please Login</h1>
      <p style="color: red;">
         <?= $_SESSION['error'] ?? ''; ?>
         <?php unset($_SESSION['error']); ?>
      </p>
      <form method="POST">
         <p class="row">
            <label class="form-label col-12 col-sm-2" for="email">Email</label>
            <input class="form-control form-control-sm col-12 col-md-3" type="text" name="email" id="email" 
            value="<?= $_SESSION['who'] ?? '' ?>" />
         </p>
         <p class="row">
            <label class="form-label col-12 col-md-2" for="pwd">Password</label>
            <input class="form-control form-control-sm col-12 col-md-3" type="password" name="pass" id="pwd" />
         </p>
         <input class="btn btn-sm btn-primary" type="submit" name="login" value="Log In" />
         <button class="btn btn-sm btn-secondary" type="submit" name="cancel">Cancel</button>
      </form>
      <small class="text-muted">Check 'View Page Source' for password</small>
      <!-- Password : php123 -->
   </div>
</body>
</html>