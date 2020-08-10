<!-- MODEL -->
<?php
  require_once('check-login.php');
  require_once('config/pdo.php');

  if(isset($_POST['add'])){
    $firstname = htmlentities($_POST['first_name']);
    $lastname = htmlentities($_POST['last_name']);
    $email = htmlentities($_POST['email']);
    $headline = htmlentities($_POST['headline']);
    $summary = htmlentities($_POST['summary']);

    if(empty($firstname) || empty($lastname) || empty($email) || empty($headline) || empty($summary)){
      $_SESSION['error'] = 'All fields are required';
    }else if(!preg_match('/.@./i', $email)){
      $_SESSION['error'] = 'Email address must contain @';
    }else {

      $stmt = $pdo->prepare('INSERT INTO Profile
        (user_id, first_name, last_name, email, headline, summary)
        VALUES ( :uid, :fn, :ln, :em, :he, :su)');
      $stmt->execute(array(
          ':uid' => $_SESSION['user_id'],
          ':fn' => $firstname,
          ':ln' => $lastname,
          ':em' => $email,
          ':he' => $headline,
          ':su' => $summary)
      );
      $_SESSION['success'] = 'Profile added';
      header('Location: index.php');
      return;

    }

    header('Location: add.php');
    return;
  }
?>


<?php include('templates/header.php'); ?>

<h1>Add Profile</h1>
<hr>
<p class="text-danger">
  <strong>
    <?= $_SESSION['error'] ?? '' ?>
  </strong>
  <?php unset($_SESSION['error']) ?>
</p>
<form method="POST">
  <p class="row">
    <label class="col-12 col-md-2" for="first_name">Firstname</label>
    <input class="col-12 col-md-3 form-control form-control-sm" type="text" name="first_name" id="first_name">
  </p>
  <p class="row">
    <label class="col-12 col-md-2" for="last_name">Lastname</label>
    <input class="col-12 col-md-3 form-control form-control-sm" type="text" name="last_name" id="last_name">
  </p>
  <p class="row">
    <label class="col-12 col-md-2" for="email">Email</label>
    <input class="col-12 col-md-3 form-control form-control-sm" type="text" name="email" id="email">
  </p>
  <p class="row">
    <label class="col-12 col-md-2" for="headline">Headline</label>
    <input class="col-12 col-md-3 form-control form-control-sm" type="text" name="headline" id="headline">
  </p>
  <p class="row">
    <label class="col-12 col-md-2" for="summary">Summary</label>
    <textarea class="col-12 col-md-3 form-control form-control-sm" rows="4" name="summary" id="summary"></textarea>
  </p>
  <input class="btn btn-sm btn-primary" type="submit" name="add" value="Add">
  <a class="btn btn-sm btn-secondary" href="index.php">Cancel</a>
</form>

<?php include('templates/footer.php'); ?>