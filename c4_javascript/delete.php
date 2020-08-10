<!-- MODEL -->
<?php
  require_once('check-login.php');
  require_once('config/pdo.php');

  if(!isset($_GET['profile_id'])){
    $_SESSION['error'] = 'GET parameter missing';
    header('Location: index.php');
  }else {
    $stmt = $pdo->prepare('SELECT user_id, first_name, last_name FROM Profile WHERE profile_id=:pid ;');
    $stmt->execute(array(
      ':pid' => $_GET['profile_id']
    ));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if(empty($row)){
      $_SESSION['error'] = 'Invalid GET Parameter';
      header('Location: index.php');
    }else if(!$row['user_id'] === $_SESSION['user_id']){
      $_SESSION['error'] = "You don't the user previliages to delete this profile";
      header('Location: index.php');
    }
  }

  if(isset($_POST['delete'])){
    $pid = $_GET['profile_id'];

    $stmt = $pdo->prepare('DELETE FROM Profile 
      WHERE profile_id=:pid AND user_id=:uid ;');
    $stmt->execute(array(
      ':pid' => $_GET['profile_id'],
      ':uid' => $_SESSION['user_id']
    ));
    $_SESSION['success'] = 'Profile deleted';
    header('Location: index.php');
    return;
  }
?>

<!-- VIEW -->

<?php include('templates/header.php'); ?>

<h1>Delete Profile</h1>
<hr>
<form method="POST">
  <p>Confirm delete : <?= $row['first_name'].' '.$row['last_name'] ?></p>
  <input class="btn btn-sm btn-primary" type="submit" name="delete" value="Delete">
  <a class="btn btn-sm btn-secondary" href="index.php">Cancel</a>
</form>

<?php include('templates/footer.php'); ?>