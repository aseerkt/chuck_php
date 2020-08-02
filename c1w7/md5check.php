<?php
   if(isset($_GET['submit'])) {
      $input_hash = htmlentities($_GET['md5']);

      $count = 0;
      $history = array();

      $time = microtime(true);

      foreach (range(0,9) as $first){
         foreach (range(0,9) as $second) {
            foreach (range(0,9) as $third) {
               foreach (range(0,9) as $fourth) {
                  $test_pin = $first.$second.$third.$fourth;
                  $test_hash = hash('md5', $test_pin);
                  if($count <15) $history[]=['hash' => $test_hash, 'pin' => $test_pin];
                  $count ++;
                  if ($test_hash == $input_hash) {
                     $cracked_pin = $test_pin;
                     break 4;
                  }
               }
            }
         }
      }

      $time = microtime(true) - $time;


   }
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <title>MP5 Cracker</title>
</head>
<body>
   <h1>MD5 Cracker</h1>
   <p>This application takes an MD5 hash of a four digit pin and check all 10,000 possible four digit PINs to determine the PIN.</p>
<!-- PRE TAG -->
<pre>
<?php
echo 
'Debug Output:<br>';
if(isset($_GET['submit'])){
   foreach ($history as $hist_entry) {
echo $hist_entry['hash'].' '.$hist_entry['pin'].'<br>';
   }
echo 
'Total checks: '.$count.'<br>';
echo 
'Elapsed time: '.$time.'<br>';
}

?>
</pre>

   <p>PIN Output: <?php echo $cracked_pin ?? 'Not Found'; ?></p>
   <div>
      <form method="GET" action="<?php echo $_SERVER['PHP_SELF']; ?>">
         <input type="text" name="md5" size="40">
         <button type="submit" name="submit" value="">Crack MD5</button>
      </form>
   </div>

   <div>
      <ul>
         <li><a href="<?php echo $_SERVER['PHP_SELF']; ?>">Reset this Page</a></li>
         <li><a href="makehash.php">MD5 Hasher</a></li>
      </ul>
   </div>
</body>
</html>