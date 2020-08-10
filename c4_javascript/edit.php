<!-- MODEL -->
<?php
  require_once('check-login.php');
  require_once('config/pdo.php');

  if(!isset($_GET['profile_id'])){
    $_SESSION['error'] = 'GET parameter missing';
    header('Location: index.php');
    exit();
  }else{
    $stmt = $pdo->prepare('SELECT * FROM Profile WHERE profile_id=:pid ;');
    $stmt->execute(array(
      ':pid' => $_GET['profile_id']
    ));
    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    if(empty($data)){
      $_SESSION['error'] = 'Invalid GET Parameter';
      header('Location: index.php');
    }else if(!$data['user_id'] === $_SESSION['user_id']){
      $_SESSION['error'] = "You don't the user previliages to edit this profile";
      header('Location: index.php');
    }
  }

  if(isset($_POST['save'])){
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

      $stmt = $pdo->prepare('UPDATE Profile SET
        first_name=:fn, last_name=:ln, email=:em, headline=:hl, summary=:su
        WHERE profile_id=:pid AND user_id=:uid ;');
      $stmt->execute(array(
          ':uid' => $_SESSION['user_id'],
          ':pid' => $_GET['profile_id'],
          ':fn' => $firstname,
          ':ln' => $lastname,
          ':em' => $email,
          ':hl' => $headline,
          ':su' => $summary)
      );
      $_SESSION['success'] = 'Profile edited';
      header('Location: index.php');
      return;

    }

    header('Location: edit.php?profile_id='.$_GET['profile_id']);
    return;
  }
?>

<!-- VIEW  -->

<?php include('templates/header.php'); ?>

<h1>hEdit Page</h1>
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
    <input class="col-12 col-md-3 form-control form-control-sm" type="text" name="first_name" id="first_name"
      value="<?= htmlentities($data['first_name']) ?>">
  </p>
  <p class="row">
    <label class="col-12 col-md-2" for="last_name">Lastname</label>
    <input class="col-12 col-md-3 form-control form-control-sm" type="text" name="last_name" id="last_name"
      value="<?= htmlentities($data['last_name']) ?>">
  </p>
  <p class="row">
    <label class="col-12 col-md-2" for="email">Email</label>
    <input class="col-12 col-md-3 form-control form-control-sm" type="text" name="email" id="email"
      value="<?= htmlentities($data['email']) ?>">
  </p>
  <p class="row">
    <label class="col-12 col-md-2" for="headline">Headline</label>
    <input class="col-12 col-md-3 form-control form-control-sm" type="text" name="headline" id="headline"
      value="<?= htmlentities($data['headline']) ?>">
  </p>
  <p class="row">
    <label class="col-12 col-md-2" for="summary">Summary</label>
    <input class="col-12 col-md-3 form-control form-control-sm" type="text" name="summary" id="summary"
      value="<?= htmlentities($data['summary']) ?>">
  </p>
  <input class="btn btn-sm btn-primary" type="submit" name="save" value="Save">
  <a href="index.php">Cancel</a>
</form>

<?php include('templates/footer.php'); ?>