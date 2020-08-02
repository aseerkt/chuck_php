<?php 
   if(isset($_POST['cancel'])){
      header('Location: index.php');
   }
   session_start();
   // Checking login credentials
   if(isset($_POST['login'])){
      $email = $_POST['email'];
      $password = $_POST['pass'];

      if(empty($email) || empty($password)){
         $_SESSION['error'] = 'User name and password are required';
      }elseif ($password !='php123') {
         $_SESSION['error'] = 'Incorrect password';
      }else {
         $_SESSION['name'] = $email;
         header('Location: index.php');
         return;
      }
      header('Location: '.$_SESSION['PHP_SELF']);
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
      <h1>Please Log In</h1>
      <hr>
      <form method="POST">
         User Name <input type="text" name="email"><br/>
         Password <input type="text" name="pass"><br/>
         <input class="btn btn-sm btn-primary mt-3" type="submit" name="login" value="Log In">
         <input class="btn btn-sm btn-secondary mt-3" type="submit" name="cancel" value="Cancel">
      </form>
      <small class="row text-muted mt-3 border-top">Password Hint: Check 'View page source'</small>
      <!-- Password: php123 -->
   </div>
   
</body>
</html>