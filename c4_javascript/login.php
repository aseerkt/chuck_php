<!-- MODEL -->

<?php 
  session_start();
  require_once('config/pdo.php');

  if(isset($_POST['login'])){
    $email = htmlentities($_POST['email']);
    $pass = htmlentities($_POST['pass']);

    if(empty($email) || empty($pass)){
      $_SESSION['error'] = 'Both Fields are required';
    }elseif(!preg_match("/.@./i", $email)) {
      $_SESSION['error'] = 'Invalid Email Address';
    }else {
      $salt = "XyZzy12*_";
      $check = hash('md5', $salt.$pass);
      $stmt = $pdo->prepare('SELECT user_id,name FROM users WHERE email=:em AND password=:pw');
      $stmt->execute(array(
        ':em' => $email,
        ':pw' => $check
      ));
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      if(!empty($row)){
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['name'] = $row['name'];
        header('Location: index.php');
        return;
      }else {
        $_SESSION['error'] = 'Incorrect Password';
      }
    }


    header('Location: login.php');
    return;
  }
?>
<!-- VIEW -->
<?php include('templates/header.php'); ?>

<h1>Login Page</h1>
<hr>
<p class="text-danger">
  <strong>
    <?= $_SESSION['error'] ?? '' ?>
  </strong>
  <?php unset($_SESSION['error']); ?>
</p>
<form method="POST">
  <p class="row">
    <label class="col-12 col-md-2" for="email">Email</label>
    <input class="col-12 col-md-3 form-control form-control-sm" type="text" name="email" id="email">
  </p>
  <p class="row">
    <label class="col-12 col-md-2" for="pass">Password</label>
    <input class="col-12 col-md-3 form-control form-control-sm" type="password" name="pass" id="pass">
  </p>
  <input class="btn btn-sm btn-primary" id="login" type="submit" name="login" value="Log In">
  <a href="index.php">Cancel</a>
</form>

<!-- Form Validation using JavaScript -->
<script type="text/javascript">
  const btn = document.getElementById('login');
  btn.addEventListener('click', doValidate);

  function doValidate(event){
    console.log('Validation on progress');
    
    const email = document.getElementById('email').value;
    const pass = document.getElementById('pass').value;

    if(email == null || email == ''){
      console.log('email empty');
      alert('Both fields must be filled out');
      return false;
    }else if(!/.@./i.test(email)){
      console.log('invalid email');
      alert('Invalid Email Address');
      return false;
    }
    if(pass == null || pass == ''){
      console.log('pass empty');
      alert('Both fields must be filled out');
      return false;
    }
  }
</script>
<?php include('templates/footer.php'); ?>