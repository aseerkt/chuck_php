<!-- Source: https://en.wikipedia.org/wiki/Post/Redirect/Get -->
<?php 
   
   session_start();
   if( isset($_POST['guess'])){
      $guess = htmlentities($_POST['guess']) +0; //convert to int
      $_SESSION['guess'] = $guess;
      $correct = 42;
      if($guess<$correct) $_SESSION['message'] = 'Your guess is too low';
      else if($guess == $correct) $_SESSION['message'] = 'Congratulations - Your guess is right';
      else $_SESSION['message'] = 'You guess is too high';
      // Important part
      // Refresh won't carry post request
      // Refresh won't ask for Form Resubmission
      // Save us from repeated POST submission which could affect database to have copies of the same entry
      header('Location: guess.php');
      return;
   }
?>

<?php 
   $guess = $_SESSION['guess'] ?? '';
   $message = $_SESSION['message'] ?? null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <title>Guess Game</title>
</head>
<body>
   <h1>Guess Game</h1>
   <small>Test sample for POST/Redirect/GET</small>
   <p>
      <?= $message ?? '' ?>
   </p>
   
   <form method="POST">
      <p>
         <label for="guess">Guess the number</label>
         <input type="text" name="guess" id="guess" value="<?= htmlentities($guess) ?>" />
      </p>
      <button type="submit" name='submit'>Submit</button>
   </form>
</body>
</html>