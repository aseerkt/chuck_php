<?php
   if(isset($_GET['submit'])){
      $error = '';
      $pin = htmlentities($_GET['pin']);
      $check_digits = false ;

      switch ($pin) {
         case !is_numeric($pin):
            $error = 'PIN is not number';
            break;
         case !is_integer($pin+0):
            $error = 'PIN is not integer';
            break;
         case strlen($pin)>4:
            $error = 'Number of digits exceeded 4';
            break;
         default:
            $hash = hash('md5', $pin);
            break;
      }
   }

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <title>MD5 Hash Maker</title>
</head>
<body>
   <h1>MD5 Hash Maker</h1>
   <p>Provdie 4 digit PIN to make MD5 Hash.</p>
   <form method="GET" action="<?php echo $_SERVER['PHP_SELF']; ?>">
      <input type="text" name="pin">
      <button type="submit" name="submit">Hash PIN</button>
   </form>
   <p><b>Output Hash:</b> 
      <?php
         echo ($hash ?? 'Provide PIN in correct format to get hash').'<br><br>';
      ?>
      <span style="color: red">
         <?php if (!empty($error)){
            echo '<b>Error</b>: '.$error.'<br>';
         }
         ?>
      </span>
      
   </p>

   <div>
      <ul>
         <li><a href="<?php echo $_SERVER['PHP_SELF']; ?>">Rest this page</a></li>
         <li><a href="md5check.php">MD5 Cracker</a></li>
      </ul>
   </div>
</body>
</html>