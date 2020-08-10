<!-- MODAL -->
<?php
  session_start();
  require_once('config/pdo.php');

  $stmt = $pdo->prepare('SELECT * FROM Profile');
  $stmt->execute();
  $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- VIEW -->

<?php include('templates/header.php'); ?>

<h1>Profile Registery</h1>
<hr>
<p class="text-danger">
  <?= $_SESSION['error'] ?? '' ?>
  <?php unset($_SESSION['error']); ?>
</p>
<p class="text-success">
  <?= $_SESSION['success'] ?? '' ?>
  <?php unset($_SESSION['success']); ?>
</p>
<?php if(!empty($rows)): ?>
  <div>
    <table class="table table-responsive table-responsive">
      <thead>
        <tr>
          <th>Full Name</th>
          <th>Headline</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($rows as $row): ?>
          <tr>
            <td><?= $row['first_name']." ".$row['last_name'] ?></td>
            <td><?= $row['headline'] ?></td>
            <?php if(isset($_SESSION['user_id']) && $row['user_id'] === $_SESSION['user_id']): ?>
              <td>
                <a href="edit.php?profile_id=<?= $row['profile_id'] ?>">Edit</a> |
                <a href="delete.php?profile_id=<?= $row['profile_id'] ?>">Delete</a>
              </td>
            <?php endif; ?>
          </tr>
        <?php endforeach; ?>
      </tbody> 
    </table>
  </div>
<?php else: ?>
  <p>No profiles in database</p>
<?php endif; ?>
<?php if(!isset($_SESSION['user_id'])): ?>
  <a href="login.php">Please log in</a>
<?php else: ?>
  <a href="add.php">Add New Entry</a> | 
  <a href="logout.php">Logout</a>
<?php endif; ?>

<?php include('templates/footer.php'); ?>