<?php
   if(!isset($_GET['name'])) {
      die("Name parameter missing");
   }else {
      $user_name = htmlentities($_GET['name']);
   }


   if(isset($_POST['logout'])) {
      header('Location: login.php');
   }

   $names = ['Rock', 'Paper', 'Scissors'];
   //Check Function

   function check($computer, $human) {
      if ($computer == $human) {
         return 'Tie';
      }if (($human+3-1)%3 == $computer){
         return 'You Win';
      }else {
         return 'You Lose';
      }
   }

   if(isset($_POST['submit'])) {
      $c = rand(0,2);
      $h = $_POST['human'];


      if ($h == '3') {
         $output='';
         for($c=0; $c<3; $c++){
            for ($h=0; $h<3; $h++){
               $output .= 'Human='.$names[$h].' Computer='.$names[$c].' Result='.check($c, $h).'<br>';
            }
         }
      }else if($h != '-1'){
         $output = 'Your Play='.$names[$h].' Computer Play='.$names[$c].' Result='.check($c, $h).'<br>';
      }
   }

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <!-- Add bootstrap css files -->
   <?php include('bootstrap-css.php'); ?>
   <title>Aseer KT</title>
</head>
<body>
   <div class="container">
         <h1 class="heading">Rock Paper Scissors</h1>
   <p>Welcome: <?= $user_name ?></p>

   <form method="POST">
      <select class="form-control form-control-sm mb-1" name="human">
         <option value="-1">-- Select strategy --</option>
         <option value="0">Rock</option>
         <option value="1">Paper</option>
         <option value="2">Scissors</option>
         <option value="3">Test</option>
      </select>
      <input type="submit" class="btn btn-sm btn-primary" name="submit" value="Play">
      <input type="submit" class="btn btn-sm btn-secondary" name="logout" value="Logout">
   </form>

   <pre class="alert alert-secondary mt-1">
<?=
$output ?? 'Please select a strategy and press Play.'
?>
   </pre>
   </div>
   <?php include('bootstrap-js.php'); ?>
</body>
</html>
