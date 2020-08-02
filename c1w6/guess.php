<?php
   $correct_guess = 41;
   $user_guess = $_GET['guess'] ?? 'NIL';

   if(is_numeric($user_guess)) {
      switch ($user_guess) {
         case $correct_guess:
            $message = "Congratulations - You are right";
            break;
         case ($user_guess < $correct_guess):
            $message = "Your guess is too low";
            break;
         case ($user_guess > $correct_guess):
            $message = "Your guess is too high";
            break;
      }
   }
   else {
      switch ($user_guess) {
         case 'NIL':
            $message = "Missing guess parameter";
            break;
         case '':
            $message = "Your guess is too short";
            break;
         default:
            $message = "Your guess is not a number";
            break;
         }
      }

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <title>Aseer KT</title>
</head>
<body>
   <h1>Welcome to someone's guessing game</h1>
   <p><?php echo $message ?></p>
   
</body>
</html>